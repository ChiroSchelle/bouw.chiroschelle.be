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
 * Template Name: Foto-sub
 */

$args = array(
	'depth' => 1,
	'title_li'     => '',        
	'echo'         => 0,
	'sort_column'  => 'menu_order, post_title'
);

	
$args['child_of'] = $post->ID;
$children = wp_list_pages($args);
if ($children == ""){
	$args['child_of'] = $post->post_parent;
	$children = wp_list_pages($args);
}
get_header(); ?>

<section class="container padding">

			<?php while ( have_posts() ) : the_post(); ?>
				<div class="summary">	
					<h2><?php the_title(); ?></h2>
					
					<ul>
						<?php echo $children; ?>
					</ul>
				</div>
				
			<?php endwhile; // End of the loop. ?>
	</section>

<?php get_footer(); ?>