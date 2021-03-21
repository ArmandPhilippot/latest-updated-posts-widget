<?php
/**
 * Provide an admin-facing view for the widget
 *
 * This file is used to markup the admin-facing aspects of the widget.
 *
 * @package LUP_Widget
 * @link    https://github.com/armandphilippot/latest-updated-posts-widget
 * @since   0.0.1
 */

// If this file is called directly, abort.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$lupwidget_title            = ! empty( $instance['title'] ) ? $instance['title'] : '';
$lupwidget_posts_number     = ! empty( $instance['posts_number'] ) ? $instance['posts_number'] : '';
$lupwidget_post_types       = ! empty( $instance['post_types'] ) ? $instance['post_types'] : array();
$lupwidget_categories       = ! empty( $instance['categories'] ) ? $instance['categories'] : false;
$lupwidget_tags             = ! empty( $instance['tags'] ) ? $instance['tags'] : false;
$lupwidget_author           = ! empty( $instance['author'] ) ? $instance['author'] : false;
$lupwidget_publication_date = ! empty( $instance['publication_date'] ) ? $instance['publication_date'] : false;
$lupwidget_update_date      = ! empty( $instance['update_date'] ) ? $instance['update_date'] : false;
$lupwidget_comments_number  = ! empty( $instance['comments_number'] ) ? $instance['comments_number'] : false;
$lupwidget_excerpt          = ! empty( $instance['excerpt'] ) ? $instance['excerpt'] : false;
$lupwidget_sticky_posts     = ! empty( $instance['sticky_posts'] ) ? $instance['sticky_posts'] : false;

$lupwidget_post_types_list = get_post_types( array( 'public' => true ) );
?>
<p>
	<label class="lupwidget__label"
		for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>">
		<?php echo esc_html__( 'Title:', 'LUPWidget' ); ?>
	</label>
	<input class="widefat"
		id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"
		name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>"
		type="text" value="<?php echo esc_attr( $lupwidget_title ); ?>" />
</p>
<p>
	<label class="lupwidget__label" for="<?php echo esc_attr( $this->get_field_id( 'posts_number' ) ); ?>"><?php echo esc_html__( 'Number of posts to display:', 'LUPWidget' ); ?></label>
	<input class="widefat"
		id="<?php echo esc_attr( $this->get_field_id( 'posts_number' ) ); ?>"
		name="<?php echo esc_attr( $this->get_field_name( 'posts_number' ) ); ?>"
		type="number" value="<?php echo esc_attr( $lupwidget_posts_number ); ?>" min="1" />
</p>
<p>
	<input class="checkbox"
		id="<?php echo esc_attr( $this->get_field_id( 'sticky_posts' ) ); ?>"
		name="<?php echo esc_attr( $this->get_field_name( 'sticky_posts' ) ); ?>"
		type="checkbox" <?php checked( $lupwidget_sticky_posts ); ?> />
	<label class="lupwidget__label"
		for="<?php echo esc_attr( $this->get_field_id( 'sticky_posts' ) ); ?>">
		<?php echo esc_html__( 'Ignore sticky posts', 'LUPWidget' ); ?>
	</label>
</p>
<p>
	<fieldset class="lupwidget__fieldset">
		<legend class="lupwidget__legend"><?php esc_html_e( 'Choose post types:', 'LUPWidget' ); ?></legend>
		<?php
		foreach ( $lupwidget_post_types_list as $lupwidget_post_type_name => $lupwidget_post_type_value ) {
			?>
			<label class="lupwidget__label lupwidget__label--capitalize"
			for="<?php echo esc_attr( $this->get_field_id( 'post_types' ) . '-' . $lupwidget_post_type_name ); ?>">
				<input
					type="checkbox"
					class="checkbox"
					id="<?php echo esc_attr( $this->get_field_id( 'post_types' ) . '-' . $lupwidget_post_type_name ); ?>"
					name="<?php echo esc_attr( $this->get_field_name( 'post_types' ) . '[' . $lupwidget_post_type_name . ']' ); ?>"
					<?php checked( $lupwidget_post_types[ $lupwidget_post_type_name ] ); ?>
				/>
				<?php echo esc_html( $lupwidget_post_type_name ); ?>
			</label>
			<br />
			<?php
		}
		?>
	</fieldset>
</p>
<p>
	<fieldset class="lupwidget__fieldset">
		<legend class="lupwidget__legend"><?php esc_html_e( 'Choose the information to display:', 'LUPWidget' ); ?></legend>
		<label class="lupwidget__label"
			for="<?php echo esc_attr( $this->get_field_id( 'categories' ) ); ?>">
			<input class="checkbox"
				id="<?php echo esc_attr( $this->get_field_id( 'categories' ) ); ?>"
				name="<?php echo esc_attr( $this->get_field_name( 'categories' ) ); ?>"
				type="checkbox" <?php checked( $lupwidget_categories ); ?>
			/>
			<?php echo esc_html__( 'Categories', 'LUPWidget' ); ?>
		</label>
		<br />
		<label class="lupwidget__label"
			for="<?php echo esc_attr( $this->get_field_id( 'tags' ) ); ?>">
			<input class="checkbox"
				id="<?php echo esc_attr( $this->get_field_id( 'tags' ) ); ?>"
				name="<?php echo esc_attr( $this->get_field_name( 'tags' ) ); ?>"
				type="checkbox" <?php checked( $lupwidget_tags ); ?>
			/>
			<?php echo esc_html__( 'Tags', 'LUPWidget' ); ?>
		</label>
		<br />
		<label class="lupwidget__label"
			for="<?php echo esc_attr( $this->get_field_id( 'author' ) ); ?>">
			<input class="checkbox"
				id="<?php echo esc_attr( $this->get_field_id( 'author' ) ); ?>"
				name="<?php echo esc_attr( $this->get_field_name( 'author' ) ); ?>"
				type="checkbox" <?php checked( $lupwidget_author ); ?>
			/>
			<?php echo esc_html__( 'Author', 'LUPWidget' ); ?>
		</label>
		<br />
		<label class="lupwidget__label"
			for="<?php echo esc_attr( $this->get_field_id( 'publication_date' ) ); ?>">
			<input class="checkbox"
				id="<?php echo esc_attr( $this->get_field_id( 'publication_date' ) ); ?>"
				name="<?php echo esc_attr( $this->get_field_name( 'publication_date' ) ); ?>"
				type="checkbox" <?php checked( $lupwidget_publication_date ); ?>
			/>
			<?php echo esc_html__( 'Publication date', 'LUPWidget' ); ?>
		</label>
		<br />
		<label class="lupwidget__label"
			for="<?php echo esc_attr( $this->get_field_id( 'update_date' ) ); ?>">
			<input class="checkbox"
				id="<?php echo esc_attr( $this->get_field_id( 'update_date' ) ); ?>"
				name="<?php echo esc_attr( $this->get_field_name( 'update_date' ) ); ?>"
				type="checkbox" <?php checked( $lupwidget_update_date ); ?>
			/>
			<?php echo esc_html__( 'Update date', 'LUPWidget' ); ?>
		</label>
		<br />
		<label class="lupwidget__label"
			for="<?php echo esc_attr( $this->get_field_id( 'comments_number' ) ); ?>">
			<input class="checkbox"
				id="<?php echo esc_attr( $this->get_field_id( 'comments_number' ) ); ?>"
				name="<?php echo esc_attr( $this->get_field_name( 'comments_number' ) ); ?>"
				type="checkbox" <?php checked( $lupwidget_comments_number ); ?>
			/>
			<?php echo esc_html__( 'Comments number', 'LUPWidget' ); ?>
		</label>
		<br />
		<label class="lupwidget__label"
			for="<?php echo esc_attr( $this->get_field_id( 'excerpt' ) ); ?>">
			<input class="checkbox"
				id="<?php echo esc_attr( $this->get_field_id( 'excerpt' ) ); ?>"
				name="<?php echo esc_attr( $this->get_field_name( 'excerpt' ) ); ?>"
				type="checkbox" <?php checked( $lupwidget_excerpt ); ?>
			/>
			<?php echo esc_html__( 'Excerpt', 'LUPWidget' ); ?>
		</label>
	</fieldset>
</p>
