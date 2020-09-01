<?php
/* * * * * * * * * * * * * * * * * * * * * * * * * * *
 * @package  : dan0sz/widget-area-halfway-post
 * @author   : Daan van den Bergh
 * @copyright: (c) 2020 Daan van den Bergh
 * @url      : https://daan.dev | https://woosh.dev
 * * * * * * * * * * * * * * * * * * * * * * * * * * */

class WidgetAreaHalfwayPost
{
    /** @var string $handle */
    private $handle = 'widget-area-halfway-post';

    /** @var string $plugin_text_domain */
    private $plugin_text_domain = 'widget-area-halfway-post';

    /**
     * WidgetAreaHalfwayPostGp constructor.
     */
    public function __construct()
    {
        $this->init();
    }

    /**
     * Hook into required actions. The stylesheet is added right before the closing <body> tag, because we don't need it
     * above the fold.
     */
    private function init()
    {
        add_action('widgets_init', [$this, 'register_sidebar'], 0, 100);
        add_action('wp_footer', [$this, 'maybe_enqueue_stylesheet']);
        add_action('wp', [$this, 'maybe_insert_sidebar'], 0, 200);
    }

    /**
     * Should we insert the widget area on this page?
     */
    public function maybe_insert_sidebar()
    {
        if (!is_admin()
            && is_single()
            && get_post_type() == 'post'
        ) {
            add_filter('the_content', [$this, 'insert_sidebar']);
        }
    }

    public function maybe_enqueue_stylesheet()
    {
        if (!is_admin()
            && is_single()
            && get_post_type() == 'post'
        ) {
            wp_enqueue_style($this->handle, plugin_dir_url(DAAN_WIDGET_AREA_HALFWAY_POST_PLUGIN_FILE) . 'assets/css/widget-area-halfway-post.min.css', [], DAAN_WIDGET_AREA_HALFWAY_POST_STATIC_VERSION);
        }
    }

    /**
     * Register the widget area in WP Admin.
     */
    public function register_sidebar()
    {
        register_sidebar(
            [
                'id'          => 'halfway-post',
                'name'        => __('Halfway Post Content', $this->plugin_text_domain),
                'description' => __('Insert widgets halfway the post\'s content.', $this->plugin_text_domain)
            ]
        );
    }

    /**
     * @param $html
     *
     * @return string
     */
    public function insert_sidebar($html)
    {
        $headers = preg_split('@(?=\<h2\>)@', $html);
        $middle  = (int) ceil(count($headers) / 2);

        ob_start();
        ?>
        <div class="halfway-post widget-area">
        <?php
        dynamic_sidebar('halfway-post');
        ?>
        </div>
        <?php
        $sidebar = ob_get_contents();
        ob_end_clean();

        array_splice($headers, $middle, 0, $sidebar);

        return implode('', $headers);
    }
}
