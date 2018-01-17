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
 * Template Name: Fotoalbum algemeen overzicht
 */


$args = array('depth' => 2,'title_li'=> '','echo'=> 0,'sort_column'  => 'menu_order, post_title');
$args['child_of'] = '470';
$children_activiteiten = wp_list_pages($args);
$args['child_of'] = '3157';
$children_bivak = wp_list_pages($args);
$args['child_of'] = '467';
$children_oudedoos = wp_list_pages($args);	

get_header(); ?>

	<section class="container padding">
			<?php while ( have_posts() ) : the_post(); ?>
				<div class="summary">	
					<h2>Foto archief</h2>
					
					<div class="row">
						<div class="activities col-md-4">
							<h3>Activiteiten</h3>
							<?php echo $children_activiteiten; ?>
						</div>
						
						<div class="bivak col-md-4">
							<h3>Bivak</h3>
							<?php echo $children_bivak; ?>
						</div>
						 
						<div class="oudedoos col-md-4">
							<h3>Uit de oude doos</h3>
							<?php echo $children_oudedoos; ?>
						</div>
					</div>
				</div>
				
			<?php endwhile; // End of the loop. ?>
	</section>

<?php get_footer(); ?>
