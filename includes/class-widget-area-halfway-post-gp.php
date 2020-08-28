<?php
/* * * * * * * * * * * * * * * * * * * * * * * * * * *
 * @package  : dan0sz/widget-area-halfway-post-gp
 * @author   : Daan van den Bergh
 * @copyright: (c) 2020 Daan van den Bergh
 * @url      : https://daan.dev | https://woosh.dev
 * * * * * * * * * * * * * * * * * * * * * * * * * * */

class WidgetAreaHalfwayPostGp
{
    /** @var string $handle */
    private $handle = 'widget-area-halfway-post-gp';

    /** @var string $plugin_text_domain */
    private $plugin_text_domain = 'widget-area-halfway-post-gp';

    /**
     * WidgetAreaHalfwayPostGp constructor.
     */
    public function __construct()
    {
        $this->init();
    }

    /**
     * Hook into required actions.
     */
    private function init()
    {
        add_action('widgets_init', [$this, 'register_sidebar'], 0, 100);
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
            wp_enqueue_style($this->handle, plugin_dir_url(DAAN_WIDGET_AREA_HALFWAY_POST_GP_PLUGIN_FILE) . 'assets/css/widget-area-halfway-post-gp.min.css', [ 'generate-style' ], DAAN_WIDGET_AREA_HALFWAY_POST_GP_STATIC_VERSION);
            add_filter('the_content', [$this, 'insert_sidebar']);
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
