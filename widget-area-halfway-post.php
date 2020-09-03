<?php
/**
 * @formatter:off
 * Plugin Name: Widget Area Halfway Post
 * Plugin URI: https://github.com/Dan0sz/widget-area-halfway-post
 * Description: Add a widget area before the middle chapter of your post's content.
 * Version: 1.0.1
 * Author: Daan van den Bergh
 * Author URI: https://daan.dev
 * Text Domain: widget-area-halfway-post-gp
 * Github Plugin URI: Dan0sz/widget-area-halfway-post
 * @formatter:on
 */

defined('ABSPATH') || exit;

/**
 * Define constants.
 */
define('DAAN_WIDGET_AREA_HALFWAY_POST_PLUGIN_DIR', plugin_dir_path(__FILE__));
define('DAAN_WIDGET_AREA_HALFWAY_POST_PLUGIN_FILE', __FILE__);
define('DAAN_WIDGET_AREA_HALFWAY_POST_PLUGIN_BASENAME', plugin_basename(__FILE__));
define('DAAN_WIDGET_AREA_HALFWAY_POST_STATIC_VERSION', '1.0.1');

/**
 * Takes care of loading classes on demand.
 *
 * @param $class
 *
 * @return mixed|void
 */
function daan_widget_area_halfway_post_autoload($class)
{
    $path = explode('_', $class);

    if ($path[0] != 'WidgetAreaHalfwayPost') {
        return;
    }

    if (!class_exists('FFWP_Autoloader')) {
        require_once(DAAN_WIDGET_AREA_HALFWAY_POST_PLUGIN_DIR . 'ffwp-autoload.php');
    }

    $autoload = new FFWP_Autoloader($class);

    return include DAAN_WIDGET_AREA_HALFWAY_POST_PLUGIN_DIR . 'includes/' . $autoload->load();
}

spl_autoload_register('daan_widget_area_halfway_post_autoload');

/**
 * @return WidgetAreaHalfwayPost
 */
function woosh_widget_area_halfway_post()
{
    static $widget_area_halfway_post = null;

    if ($widget_area_halfway_post === null) {
        $widget_area_halfway_post = new WidgetAreaHalfwayPost();
    }

    return $widget_area_halfway_post;
}

woosh_widget_area_halfway_post();
