<?php
/**
 * Provide a public-facing view for the widget
 *
 * This file is used to markup the public-facing aspects of the widget.
 *
 * @package LUP_Widget
 * @link    https://github.com/armandphilippot/latest-updated-posts-widget
 * @since   0.0.1
 */

// If this file is called directly, abort.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$lupwidget_default_title = __( 'Latest updated posts', 'LUPWidget' );
$lupwidget_title         = ! empty( $instance['title'] ) ? $instance['title'] : $lupwidget_default_title;
$lupwidget_title         = apply_filters( 'widget_title', $lupwidget_title, $instance, $this->id_base );

echo wp_kses_post( $args['before_widget'] );
if ( ! empty( $lupwidget_title ) ) {
	echo wp_kses_post( $args['before_title'] ) . esc_html( $lupwidget_title ) . wp_kses_post( $args['after_title'] );
}
?>
<!-- Your widget content here. -->
<?php
echo wp_kses_post( $args['after_widget'] );
