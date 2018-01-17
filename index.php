<?php
/**
 * The main template file.
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
 * Learn more: http://codex.wordpress.org/Template_Hierarchy
 *
 * @package chiro-schelle-15
 */

get_header(); ?>
		<?php if ( have_posts() ) : ?>

			<?php /* Start the Loop */ ?>
			<?php $i = 0; ?>
			<?php while ( have_posts() ) : the_post(); ?>

				<?php
					if($i === 0) { ?>
						<section class="highlighted">
							<section class="container">
								<?php get_template_part( 'template-parts/content', get_post_format() ); ?>
							</section>
						</section>
					<?php }
					else {

						?> <section class="container"> <?php
						/*
						 * Include the Post-Format-specific template for the content.
						 * If you want to override this in a child theme, then include a file
						 * called content-___.php (where ___ is the Post Format name) and that will be used instead.
						 */
						get_template_part( 'template-parts/content', get_post_format() );

						?> </section> <?php
					}
					$i++;

				?>

			<?php endwhile; ?>

			<section class="container">
				<div class="pagination">
					<?php previous_posts_link( 'Nieuwe berichten' ); ?>
					<?php next_posts_link( 'Oudere berichten' ); ?>
				</div>
			</section>

		<?php else : ?>
			<section class="container">
				<?php get_template_part( 'template-parts/content', 'none' ); ?>
			</section>
		<?php endif; ?>




<?php //get_sidebar(); ?>
<?php get_footer(); ?>
