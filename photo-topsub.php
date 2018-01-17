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
 * Template Name: Foto-topsub
 */

get_header(); ?>

	<section class="container padding">

			<?php while ( have_posts() ) : the_post(); ?>

				<h1><?php  the_title(); ?></h1>
				<?php
					$args = array('depth' => 2,'title_li'=> '','echo'=> 0,'sort_column'  => 'menu_order, post_title');
					
					$parent_title = get_the_title($post);

					switch ($parent_title) {
						case 'Activiteiten':
							$args['child_of'] = '470';
							$children = wp_list_pages($args);
							break;
						case 'Bivak':
						   $args['child_of'] = '3157';
							$children = wp_list_pages($args);
							break;
						case 'Uit de oude doos':
							$args['child_of'] = '467';
							$children = wp_list_pages($args);
							break;
					}
				?>
							
				<table id="submenu_tbl">
				  <tr>
					<td>
						<ul id="submenu">
						<?php echo $children; ?>
						</ul>
					</td>
					<td>
						<ul id="submenu">
						<?php echo $children_bivak; ?>
						</ul>
					</td>
					<td>
						<ul id="submenu">
						<?php echo $children_oudedoos; ?>
						</ul>
					</td>
				  </tr>
				</table>

			<?php endwhile; // End of the loop. ?>
	</section>

<?php get_footer(); ?>
