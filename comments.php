<?php
/**
 * Comments template — minimal, Bootstrap-styled.
 *
 * @package Innovare
 */

if ( post_password_required() ) {
	return;
}
?>
<div id="comments" class="andromeda-comments">

	<?php if ( have_comments() ) : ?>
		<h2 class="comments-title h4">
			<?php
			$count = get_comments_number();
			if ( '1' === $count ) {
				esc_html_e( '1 comment', 'innovare' );
			} else {
				printf( esc_html__( '%s comments', 'innovare' ), esc_html( number_format_i18n( $count ) ) );
			}
			?>
		</h2>

		<ol class="comment-list list-unstyled">
			<?php
			wp_list_comments( array(
				'style'       => 'ol',
				'short_ping'  => true,
				'avatar_size' => 48,
			) );
			?>
		</ol>

		<?php the_comments_pagination( array(
			'prev_text' => '<i class="bi bi-arrow-left" aria-hidden="true"></i>',
			'next_text' => '<i class="bi bi-arrow-right" aria-hidden="true"></i>',
		) ); ?>
	<?php endif; ?>

	<?php
	comment_form( array(
		'class_form'         => 'andromeda-comment-form needs-validation',
		'title_reply_before' => '<h2 class="comment-reply-title h4">',
		'title_reply_after'  => '</h2>',
		'submit_button'      => '<button name="%1$s" type="submit" id="%2$s" class="btn btn-primary %3$s">%4$s</button>',
	) );
	?>
</div>
