<?php
/**
 * The template for displaying all single posts.
 *
 * @package chiro-schelle-15
 */

get_header(); ?>

	<section class="highlighted">
		<div class="container">
			<div class="col-md-10">

				<?php while ( have_posts() ) : the_post(); ?>

					<?php get_template_part( 'template-parts/content', 'single' ); ?>


				<?php endwhile; // End of the loop. ?>

			</div>
		</div>

	</section>


	<div class="comments-wrapper">
		<?php

			// NOOIT COMMENTS TOELATEN BIJ EEN GEWONE PAGINA!

			// If comments are open or we have at least one comment, load up the comment template.
			if ( comments_open() || get_comments_number() ) :
				comments_template();
			endif;

		?>
	</div>

<?php get_footer(); ?>
