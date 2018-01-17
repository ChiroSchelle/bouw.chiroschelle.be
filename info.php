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
 * Template Name: info
 */

get_header(); ?>

	<section class="highlighted info-menu">
		<section class="container padding">
			<div class="type-page">
				<?php wp_nav_menu( array( 'theme_location' => 'info', 'menu_id' => 'info-menu' ) ); ?>
			</div>
		</section>
	</section>

	<section class="container padding">

		<?php while ( have_posts() ) : the_post(); ?>

			<?php get_template_part( 'template-parts/content', 'page' ); ?>

		<?php endwhile; // End of the loop. ?>

	</section>

<?php get_footer(); ?>