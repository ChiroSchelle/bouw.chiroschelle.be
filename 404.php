<?php
/**
 * The template for displaying 404 pages (not found).
 *
 * @package chiro-schelle-15
 */

get_header(); ?>

	<section class="container padding">
		<header class="page-header">
			<h1 class="page-title"><?php esc_html_e( 'Oeps, deze pagina bestaat niet!', 'chiro-schelle-15' ); ?></h1>
		</header>

		<div class="page-content">
			<p><?php esc_html_e( 'Naar wat was je op zoek?', 'chiro-schelle-15' ); ?></p>

			<?php get_search_form(); ?>

			<?php the_widget( 'WP_Widget_Recent_Posts' ); ?>

		</div><!-- .page-content -->
	</section>

<?php get_footer(); ?>
