<?php
/**
 * Template Name: Innovare — Legal document
 *
 * Use for Privacy Policy and Terms of Use pages. Body copy comes from the editor.
 *
 * @package Innovare
 */

get_header();

while ( have_posts() ) :
	the_post();
	andromeda_page_header(
		__( 'Legal', 'innovare' ),
		get_the_title(),
		''
	);
	?>
	<section class="andromeda-section andromeda-legal-page">
		<div class="container">
			<div class="row justify-content-center">
				<div class="col-lg-9 col-xl-8 andromeda-legal-content entry-content">
					<?php the_content(); ?>
				</div>
			</div>
		</div>
	</section>
	<?php
endwhile;

get_footer();
