<?php
/**
 * Plugin Name: Widget Area Halfway Post
 * Plugin URI: https://github.com/Dan0sz/widget-area-halfway-post
 * Description: Add a widget area before the middle chapter of your post's content.
 * Version: 1.0.3
 * Author: Daan from Daan.dev
 * Author URI: https://daan.dev
 * Text Domain: widget-area-halfway-post-gp
 * Github Plugin URI: Dan0sz/widget-area-halfway-post
 */

defined( 'ABSPATH' ) || exit;

/**
 * Define constants.
 */
define( 'DAAN_WIDGET_AREA_HALFWAY_POST_PLUGIN_DIR', plugin_dir_path( __FILE__ ) );
define( 'DAAN_WIDGET_AREA_HALFWAY_POST_PLUGIN_FILE', __FILE__ );
define( 'DAAN_WIDGET_AREA_HALFWAY_POST_PLUGIN_BASENAME', plugin_basename( __FILE__ ) );
define( 'DAAN_WIDGET_AREA_HALFWAY_POST_STATIC_VERSION', '1.0.3' );

/**
 * @return WidgetAreaHalfwayPost
 */
function daan_widget_area_halfway_post() {
	static $widget_area_halfway_post = null;
	
	if ( $widget_area_halfway_post === null ) {
		require_once( 'includes/class-widget-area-halfway-post.php' );
		
		$widget_area_halfway_post = new WidgetAreaHalfwayPost();
	}
	
	return $widget_area_halfway_post;
}

daan_widget_area_halfway_post();
