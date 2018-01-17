<?php
/**
 * Template part for displaying posts.
 *
 * @package chiro_schelle
 */

?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

	<div class="entry-thumb">
		<?php
			if(has_post_thumbnail()) {
				the_post_thumbnail(array(150));
			}
			else {
				echo chiroschelle_show_default_thumb();
			}
		?>
	</div>
	<div class="entry-wrapper">
		<header class="entry-header">
			<?php the_title( sprintf( '<h2 class="entry-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h2>' ); ?>

			<?php if ( 'post' == get_post_type() ) : ?>
				<div class="entry-meta">
					<?php chiro_schelle_posted_on(); ?>
				</div>
			<?php endif; ?>
		</header>

		<div class="entry-content">
			<?php
				/* translators: %s: Name of current post */
				the_content( '<p>Lees meer &raquo;</p>' );
			?>

			<?php
				wp_link_pages( array(
					'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'chiro_schelle' ),
					'after'  => '</div>',
				) );
			?>
		</div>

		<footer class="entry-footer">
			<?php chiro_schelle_entry_footer(); ?>
		</footer>
	</div>
</article>
