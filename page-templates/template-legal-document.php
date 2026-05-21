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
	innovare_page_header(
		__( 'Legal', 'innovare' ),
		get_the_title(),
		''
	);
	?>
	<section class="innovare-section innovare-legal-page">
		<div class="container">
			<div class="row justify-content-center">
				<div class="col-lg-9 col-xl-8 innovare-legal-content entry-content">
					<?php the_content(); ?>
				</div>
			</div>
		</div>
	</section>
	<?php
endwhile;

get_footer();
