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

$lupwidget_posts_number     = ( ! empty( $instance['posts_number'] ) ) ? wp_strip_all_tags( $instance['posts_number'] ) : '';
$lupwidget_categories       = ! empty( $instance['categories'] ) ? '1' : '0';
$lupwidget_tags             = ! empty( $instance['tags'] ) ? '1' : '0';
$lupwidget_author           = ! empty( $instance['author'] ) ? '1' : '0';
$lupwidget_publication_date = ! empty( $instance['publication_date'] ) ? '1' : '0';
$lupwidget_update_date      = ! empty( $instance['update_date'] ) ? '1' : '0';
$lupwidget_comments_number  = ! empty( $instance['comments_number'] ) ? '1' : '0';
$lupwidget_excerpt          = ! empty( $instance['excerpt'] ) ? '1' : '0';
$lupwidget_sticky_posts     = ! empty( $instance['sticky_posts'] ) ? '1' : '0';

$lupwidget_query_args = array(
	'post_type' => 'post',
	'orderby'   => 'modified',
);

if ( $lupwidget_sticky_posts ) {
	$lupwidget_query_args += array( 'ignore_sticky_posts' => false );
}

$lupwidget_recently_updated_posts = new \WP_Query( $lupwidget_query_args );

echo wp_kses_post( $args['before_widget'] );
if ( ! empty( $lupwidget_title ) ) {
	echo wp_kses_post( $args['before_title'] ) . esc_html( $lupwidget_title ) . wp_kses_post( $args['after_title'] );
}

if ( $lupwidget_recently_updated_posts->have_posts() ) {
	?>
	<ul class="widget__list lup__list">
	<?php
	for ( $lupwidget_i = 0; $lupwidget_i < $lupwidget_posts_number; $lupwidget_i++ ) {
		$lupwidget_recently_updated_posts->the_post();
		?>
		<li class="widget__item lup__item">
			<article class="lup__post">
				<header class="lup__header">
					<a href="<?php the_permalink(); ?>" class="lup__title"><?php the_title(); ?></a>
				</header>
				<?php if ( $lupwidget_categories || $lupwidget_tags || $lupwidget_author || $lupwidget_publication_date || $lupwidget_update_date || $lupwidget_comments_number ) { ?>
					<footer class="lup__footer">
						<?php
						if ( $lupwidget_categories ) {
							?>
							<span class="lup__categories"><?php the_category( ', ' ); ?></span>
							<?php
						}
						if ( $lupwidget_tags ) {
							?>
							<span class="lup__tags"><?php the_tags( '', ', ' ); ?></span>
							<?php
						}
						if ( $lupwidget_author ) {
							?>
							<span class="lup__author"><?php the_author_posts_link(); ?></span>
							<?php
						}
						if ( $lupwidget_publication_date ) {
							?>
							<span class="lup__date lup__date--published"><?php the_date(); ?></span>
							<?php
						}
						if ( $lupwidget_update_date ) {
							?>
							<span class="lup__date lup__date--updated"><?php the_modified_date(); ?></span>
							<?php
						}
						if ( $lupwidget_comments_number ) {
							?>
							<span class="lup__comments"><?php comments_popup_link(); ?></span>
							<?php
						}
						?>
					</footer>
					<?php
				}
				if ( $lupwidget_excerpt ) {
					?>
					<div class="lup__excerpt"><?php the_excerpt(); ?></div>
					<?php
				}
				?>
			</article>
		</li>
	<?php } ?>
	</ul>
	<?php
}
echo wp_kses_post( $args['after_widget'] );
