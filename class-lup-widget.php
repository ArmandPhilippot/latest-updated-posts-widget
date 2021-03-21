<?php
/**
 * LUP_Widget
 *
 * Display a list of latest updated posts as a widget.
 *
 * @package   LUP_Widget
 * @link      https://github.com/armandphilippot/latest-updated-posts-widget
 * @author    Armand Philippot <ap@armandphilippot.com>
 *
 * @copyright 2020 Armand Philippot
 * @license   GPL-2.0-or-later
 * @since     0.0.1
 *
 * @wordpress-plugin
 * Plugin Name:       Latest updated posts
 * Plugin URI:        https://github.com/armandphilippot/latest-updated-posts-widget
 * Description:       Display a list of latest updated posts as a widget.
 * Version:           0.0.1
 * Requires at least: 5.2
 * Requires PHP:      7.2
 * Author:            Armand Philippot
 * Author URI:        https://www.armandphilippot.com/
 * License:           GPL v2 or later
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       LUPWidget
 * Domain Path:       /languages
 */

namespace LUPWidget;

// If this file is called directly, abort.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/*
 * Currently plugin version.
 * Start at version 1.0.0 and use SemVer - https://semver.org
 * Rename this for your plugin and update it as you release new versions.
 */
define( 'LUPWIDGET_VERSION', '0.0.1' );

/**
 * Class used to implement a LUP_Widget widget.
 *
 * @since 0.0.1
 *
 * @see WP_Widget
 */
class LUP_Widget extends \WP_Widget {
	/**
	 * Set up a new LUP_Widget widget instance with id, name & description.
	 *
	 * @since 0.0.1
	 */
	public function __construct() {
		$widget_options = array(
			'classname'   => 'lupwidget',
			'description' => __( 'Display a list of latest updated posts as a widget.', 'LUPWidget' ),
		);

		parent::__construct(
			'lupwidget',
			__( 'Latest updated posts', 'LUPWidget' ),
			$widget_options
		);

		add_action(
			'widgets_init',
			function() {
				register_widget( 'LUPWidget\LUP_Widget' );
			}
		);

		if ( is_active_widget( false, false, $this->id_base ) ) {
			add_action( 'plugins_loaded', array( $this, 'lupwidget_load_plugin_textdomain' ) );
			add_action( 'wp_enqueue_scripts', array( $this, 'lupwidget_enqueue_public_styles' ) );
			add_action( 'wp_enqueue_scripts', array( $this, 'lupwidget_enqueue_public_scripts' ) );
			add_action( 'admin_enqueue_scripts', array( $this, 'lupwidget_enqueue_admin_styles' ) );
			add_action( 'admin_enqueue_scripts', array( $this, 'lupwidget_enqueue_admin_scripts' ) );
		}
	}

	/**
	 * Load text domain files
	 *
	 * @since 0.0.1
	 */
	public function lupwidget_load_plugin_textdomain() {
		load_plugin_textdomain( 'LUPWidget', false, basename( dirname( __FILE__ ) ) . '/languages/' );
	}

	/**
	 * Define the WHERE clause of the query to obtain only modified posts.
	 *
	 * @since 0.0.2
	 *
	 * @param string $where The WHERE clause of the query.
	 * @return string The custom WHERE clause.
	 */
	public function lupwidget_modified_after_published( $where ) {
			$where .= ' AND post_modified > post_date';
			return $where;
	}

	/**
	 * Register and enqueue styles needed by the public view of
	 * LUP_Widget widget.
	 *
	 * @since 0.0.1
	 */
	public function lupwidget_enqueue_public_styles() {
		$styles_path = plugins_url( '/admin/css/style.min.css', __FILE__ );

		if ( file_exists( $styles_path ) ) {
			wp_register_style( 'lupwidget', $styles_path, array(), LUPWIDGET_VERSION );

			wp_enqueue_style( 'lupwidget' );
			wp_style_add_data( 'lupwidget', 'rtl', 'replace' );
		}
	}

	/**
	 * Register and enqueue scripts needed by the public view of
	 * LUP_Widget widget.
	 *
	 * @since 0.0.1
	 */
	public function lupwidget_enqueue_public_scripts() {
		$scripts_path = plugins_url( '/public/js/scripts.min.js', __FILE__ );

		if ( file_exists( $scripts_path ) ) {
			wp_register_script( 'lupwidget-scripts', $scripts_path, array(), LUPWIDGET_VERSION, true );
			wp_enqueue_script( 'lupwidget-scripts' );
		}
	}

	/**
	 * Register and enqueue styles needed by the admin view of
	 * LUP_Widget widget.
	 *
	 * @since 0.0.1
	 */
	public function lupwidget_enqueue_admin_styles() {
		$styles_path = plugins_url( '/admin/css/style.min.css', __FILE__ );

		if ( file_exists( $styles_path ) ) {
			wp_register_style( 'lupwidget', $styles_path, array(), LUPWIDGET_VERSION );

			wp_enqueue_style( 'lupwidget' );
			wp_style_add_data( 'lupwidget', 'rtl', 'replace' );
		}
	}

	/**
	 * Register and enqueue scripts needed by the admin view of
	 * LUP_Widget widget.
	 *
	 * @since 0.0.1
	 */
	public function lupwidget_enqueue_admin_scripts() {
		$scripts_path = plugins_url( '/admin/js/scripts.min.js', __FILE__ );

		if ( file_exists( $scripts_path ) ) {
			wp_register_script( 'lupwidget-scripts', $scripts_path, array(), LUPWIDGET_VERSION, true );
			wp_enqueue_script( 'lupwidget-scripts' );
		}
	}

	/**
	 * Outputs the content for the current LUP_Widget widget instance.
	 *
	 * @since 0.0.1
	 * @since 0.0.2 Add filter to the WHERE clause.
	 *
	 * @param array $args HTML to display the widget title class and widget content class.
	 * @param array $instance Settings for the current widget instance.
	 */
	public function widget( $args, $instance ) {
		add_filter( 'posts_where', array( $this, 'lupwidget_modified_after_published' ) );
		include 'public/partials/lup-widget-public-display.php';
		remove_filter( 'posts_where', array( $this, 'lupwidget_modified_after_published' ) );
	}

	/**
	 * Outputs the settings form for the LUP_Widget widget.
	 *
	 * @since 0.0.1
	 *
	 * @param array $instance Current settings.
	 */
	public function form( $instance ) {
		include 'admin/partials/lup-widget-admin-display.php';
	}

	/**
	 * Handles updating settings for the current LUP_Widget widget instance.
	 *
	 * @since 0.0.1
	 *
	 * @param array $new_instance New settings for this instance as input by the user.
	 * @param array $old_instance Old settings for this instance.
	 *
	 * @return array Updated settings to save.
	 */
	public function update( $new_instance, $old_instance ) {
		$instance                     = $old_instance;
		$instance['title']            = sanitize_text_field( $new_instance['title'] );
		$instance['posts_number']     = ( ! empty( $new_instance['posts_number'] ) ) ? wp_strip_all_tags( $new_instance['posts_number'] ) : '';
		$instance['categories']       = ! empty( $new_instance['categories'] ) ? 1 : 0;
		$instance['tags']             = ! empty( $new_instance['tags'] ) ? 1 : 0;
		$instance['author']           = ! empty( $new_instance['author'] ) ? 1 : 0;
		$instance['publication_date'] = ! empty( $new_instance['publication_date'] ) ? 1 : 0;
		$instance['update_date']      = ! empty( $new_instance['update_date'] ) ? 1 : 0;
		$instance['comments_number']  = ! empty( $new_instance['comments_number'] ) ? 1 : 0;
		$instance['excerpt']          = ! empty( $new_instance['excerpt'] ) ? 1 : 0;
		$instance['sticky_posts']     = ! empty( $new_instance['sticky_posts'] ) ? 1 : 0;

		return $instance;
	}
}

$lupwidget = new LUP_Widget();
