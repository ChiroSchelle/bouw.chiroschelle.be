<?php
/**
 * The template for displaying archive pages.
 *
 * Learn more: http://codex.wordpress.org/Template_Hierarchy
 *
 * @package chiro-schelle-15
 */

$authorDetails = get_userdata($author);

get_header(); ?>

	<section class="highlighted">
		<div class="container padding">
			<div class="row">
				<div class="col-md-4">
					<div class="profile">
						<div class="avatar-wrapper">
							<?php echo get_avatar($authorDetails->ID, 180); ?>
						</div>

						<div class="info-wrapper">
							<h2><?php echo $authorDetails->display_name; ?></h2>
							<div class="street">
								<?php echo $authorDetails->straat . " ". $authorDetails->nr; ?>
							</div>
							<div class="city">
								<?php echo $authorDetails->postcode . " ". $authorDetails->gemeente; ?>
							</div>
							<div class="phone">
								<?php echo $authorDetails->telefoon; ?>
							</div>
							<div class="contact">
								<a href="<?php echo get_bloginfo('url') . '/contact/?uid=' . $authorDetails->ID; ?>">
						        	Contacteer <?php echo $authorDetails->first_name; ?>
						        </a>
							</div>
						</div>

					</div>
				</div>
				<div class="col-md-7 col-md-offset-1 vragenlijst-wrapper">

						<?php get_vragenlijst($authorDetails); ?>

				</div>
			</div>
		</div>

	</section>

	<?php if ( have_posts() ) : ?>
		<section class="container">
			<div class="row">
				<div class="col-md-10">

					<?php /* Start the Loop */ ?>
					<?php while ( have_posts() ) : the_post(); ?>

						<?php

							/*
							 * Include the Post-Format-specific template for the content.
							 * If you want to override this in a child theme, then include a file
							 * called content-___.php (where ___ is the Post Format name) and that will be used instead.
							 */
							get_template_part( 'template-parts/content', get_post_format() );
						?>

					<?php endwhile; ?>

					<?php // the_posts_navigation(); ?>

				</div>
			</div>
		</section>
	<?php else : ?>

		<?php //get_template_part( 'template-parts/content', 'none' ); ?>

	<?php endif; ?>

<?php get_footer(); ?>
