<?php
/**
 * Comments template.
 *
 * @package Innovare
 */

if ( post_password_required() ) {
	return;
}
?>

<div id="comments" class="innovare-comments">
	<?php if ( have_comments() ) : ?>
		<h2 class="innovare-comments-title">
			<?php
			$count = (int) get_comments_number();
			printf(
				/* translators: 1: number of comments */
				esc_html( _n( '%1$s comment', '%1$s comments', $count, 'innovare' ) ),
				esc_html( number_format_i18n( $count ) )
			);
			?>
		</h2>

		<ol class="innovare-comment-list comment-list">
			<?php
			wp_list_comments(
				array(
					'style'       => 'ol',
					'short_ping'  => true,
					'avatar_size' => 48,
					'callback'    => 'innovare_comment_callback',
				)
			);
			?>
		</ol>

		<?php
		the_comments_navigation(
			array(
				'prev_text' => esc_html__( 'Older comments', 'innovare' ),
				'next_text' => esc_html__( 'Newer comments', 'innovare' ),
			)
		);
		?>
	<?php endif; ?>

	<?php if ( ! comments_open() && get_comments_number() && post_type_supports( get_post_type(), 'comments' ) ) : ?>
		<p class="innovare-comments-closed"><?php esc_html_e( 'Comments are closed.', 'innovare' ); ?></p>
	<?php endif; ?>

	<div class="innovare-comment-form-card">
		<?php comment_form(); ?>
	</div>
</div>
