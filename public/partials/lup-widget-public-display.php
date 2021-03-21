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

$lupwidget_title = ! empty( $instance['title'] ) ? $instance['title'] : '';
$lupwidget_title = apply_filters( 'widget_title', $lupwidget_title, $instance, $this->id_base );

$lupwidget_posts_number     = ( ! empty( $instance['posts_number'] ) ) ? wp_strip_all_tags( $instance['posts_number'] ) : '';
$lupwidget_post_types       = ( ! empty( $instance['post_types'] ) ) ? $instance['post_types'] : array( 'post' => 1 );
$lupwidget_categories       = ! empty( $instance['categories'] ) ? '1' : '0';
$lupwidget_tags             = ! empty( $instance['tags'] ) ? '1' : '0';
$lupwidget_author           = ! empty( $instance['author'] ) ? '1' : '0';
$lupwidget_publication_date = ! empty( $instance['publication_date'] ) ? '1' : '0';
$lupwidget_update_date      = ! empty( $instance['update_date'] ) ? '1' : '0';
$lupwidget_comments_number  = ! empty( $instance['comments_number'] ) ? '1' : '0';
$lupwidget_excerpt          = ! empty( $instance['excerpt'] ) ? '1' : '0';
$lupwidget_sticky_posts     = ! empty( $instance['sticky_posts'] ) ? '1' : '0';

$lupwidget_query_args = array(
	'query_label'      => 'lupwidget_query',
	'orderby'          => 'modified',
	'suppress_filters' => false,
);

$lupwidget_post_types_enabled = array();

foreach ( $lupwidget_post_types as $lupwidget_post_type_name => $lupwidget_post_type_value ) {
	if ( 1 === $lupwidget_post_type_value ) {
		$lupwidget_post_types_enabled[] = $lupwidget_post_type_name;
	}
}

$lupwidget_query_args += array( 'post_type' => $lupwidget_post_types_enabled );

if ( $lupwidget_sticky_posts ) {
	$lupwidget_query_args += array( 'ignore_sticky_posts' => true );
}

$lupwidget_recently_updated_posts = new \WP_Query( $lupwidget_query_args );

echo wp_kses_post( $args['before_widget'] );

if ( ! empty( $lupwidget_title ) ) {
	echo wp_kses_post( $args['before_title'] ) . esc_html( $lupwidget_title ) . wp_kses_post( $args['after_title'] );
}

if ( $lupwidget_recently_updated_posts->have_posts() ) {
	?>
	<ul class="lup__list">
	<?php
	$lupwidget_i = 0;
	while ( $lupwidget_recently_updated_posts->have_posts() && $lupwidget_i < $lupwidget_posts_number ) {
		$lupwidget_recently_updated_posts->the_post();
		?>
		<li class="lup__item">
			<article class="lup__post">
				<header class="lup__header">
					<a href="<?php the_permalink(); ?>" class="lup__title"><?php the_title(); ?></a>
				</header>
				<?php if ( $lupwidget_categories || $lupwidget_tags || $lupwidget_author || $lupwidget_publication_date || $lupwidget_update_date || $lupwidget_comments_number ) { ?>
					<footer class="lup__footer">
						<dl class="lup__list">
							<?php
							if ( $lupwidget_categories && has_category() ) {
								$lupwidget_post_categories = get_the_category();
								?>
								<div class="lup__group lup__categories">
									<dt class="lup__term">
									<?php
									printf(
										esc_html(
											_n(
												'Category:',
												'Categories:',
												count( $lupwidget_post_categories ),
												'LUPWidget'
											)
										)
									);
									?>
									</dt>
									<dd class="lup__description">
										<?php the_category( ', ' ); ?>
									</dd>
								</div>
								<?php
							}
							if ( $lupwidget_tags && has_tag() ) {
								$lupwidget_post_tags = get_the_tags();
								?>
								<div class="lup__group lup__tags">
									<dt class="lup__term">
									<?php
									printf(
										esc_html(
											_n(
												'Tag:',
												'Tags:',
												count( $lupwidget_post_tags ),
												'LUPWidget'
											)
										)
									);
									?>
									</dt>
									<dd class="lup__description">
										<?php the_tags( '', ', ' ); ?>
									</dd>
								</div>
								<?php
							}
							if ( $lupwidget_author ) {
								?>
								<div class="lup__group lup__author">
									<dt class="lup__term">
										<?php esc_html_e( 'Author:', 'LUPWidget' ); ?>
									</dt>
									<dd class="lup__description">
										<?php the_author_posts_link(); ?>
									</dd>
								</div>
								<?php
							}
							if ( $lupwidget_publication_date ) {
								?>
								<div class="lup__group lup__publication-date">
									<dt class="lup__term">
										<?php esc_html_e( 'Published on', 'LUPWidget' ); ?>
									</dt>
									<dd class="lup__description">
										<?php the_date(); ?>
									</dd>
								</div>
								<?php
							}
							if ( $lupwidget_update_date ) {
								?>
								<div class="lup__group lup__update-date">
									<dt class="lup__term">
										<?php esc_html_e( 'Updated on', 'LUPWidget' ); ?>
									</dt>
									<dd class="lup__description">
										<?php the_modified_date(); ?>
									</dd>
								</div>
								<?php
							}
							if ( $lupwidget_comments_number && comments_open() ) {
								?>
								<div class="lup__group lup__comments">
									<dt class="lup__term">
										<?php esc_html_e( 'Comments:', 'LUPWidget' ); ?>
									</dt>
									<dd class="lup__description">
										<?php comments_popup_link(); ?>
									</dd>
								</div>
								<?php
							}
							?>
						</dl>
					</footer>
					<?php
				}
				if ( $lupwidget_excerpt ) {
					?>
						<div class="lup__excerpt">
							<?php
							$lupwidget_content = wp_strip_all_tags( get_the_excerpt(), true );
							echo esc_html( $lupwidget_content );
							?>
						</div>
						<?php
				}
				?>
			</article>
		</li>
		<?php
		$lupwidget_i++;
	}
	?>
	</ul>
	<?php
}
echo wp_kses_post( $args['after_widget'] );
