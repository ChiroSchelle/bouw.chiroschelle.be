<?php
/**
 * The template for displaying all pages.
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site will use a
 * different template.
 *
 * @package chiro-schelle-15
 * Template Name: contactpagina
 */

get_header(); ?>

	<section class="container contact">
		<div class="entry">
			<?php while ( have_posts() ) : the_post(); ?>

				<?php get_template_part( 'template-parts/content', 'page' ); ?>

			<?php endwhile; // End of the loop. ?>
		</div>

		<div id="map-canvas"></div>
		
		<?php
	        ## Laat het contactformulier zien ##
	        chirocontact_toon_form();
	 	?>
	
	</section>

<?php get_footer(); ?>