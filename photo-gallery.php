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
 * Template Name: Foto-album
 */

$args = array(
   'post_type' => 'attachment',
   'numberposts' => -1,
   'post_status' => null,
   'post_parent' => $post->ID
);

$media = get_posts( $args );

get_header(); ?>
	
	<section class="highlighted">
		<section class="container padding">
			<?php the_title( sprintf( '<h1 class="entry-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h1>' ); ?>
			<?php the_content(); ?>
		</section>
	</section>

	<section class="container padding">

			<?php while ( have_posts() ) : the_post(); ?>

				<?php  
					$current = $post->ID;
					$parent = $post->post_parent;
					$grandparent_get = get_post($parent);
					$grandparent = $grandparent_get->post_parent;
					$grandparent_title = get_the_title($grandparent);
					$parent_title = get_the_title($post->post_parent);
 					/*
					if ($root_parent = $grandparent_title !== $root_parent = get_the_title($current)) {
						echo $grandparent_title;
					}else {
						echo get_the_title($parent);
					}
					*/
                   	switch ($grandparent_title) {
                        case 'Activiteiten': ?>
                            <!-- <a href="http://www.chiroschelle.be/fotos/activiteiten"><img class="zonderkader" src="http://www.chiroschelle.be/wp-content/themes/chiro/images/activiteiten.jpg" /></a> -->
                            <?php
                            break;
                        case 'Bivak':?>
                            <!-- <a href="http://www.chiroschelle.be/fotos/bivak"><img class="zonderkader" src="http://www.chiroschelle.be/wp-content/themes/chiro/images/bivak.jpg" /> -->
                            <?php
                            break;
                        case 'Uit de oude doos':?>
                            <!-- <a href="http://www.chiroschelle.be/fotos/uit-de-oude-doos"><img class="zonderkader" src="http://www.chiroschelle.be/wp-content/themes/chiro/images/oudedoos.jpg" /> -->
                            <?php
                        break;
                }?>
			<?php endwhile; // End of the loop. ?>

			<div class="images">
				<ul class="photo-gallery row">
					<?php foreach($media as $m) : $image = wp_get_attachment_image_src( $m->ID, 'large'); $thumb = wp_get_attachment_image_src( $m->ID, array(150,150));?>
						<li class="col-xs-6 col-sm-3 col-md-2 image-wrapper">
							<a class="example-image-link" href="<?php echo $image[0]; ?>" data-lightbox="example-1"><img class="image" src="<?php echo $thumb[0]; ?>" alt=""></a>
						</li>
					<?php endforeach; ?>
				</ul>
			</div>
	</section>

<?php get_footer(); ?>
