<?php
/**
 * Template part for displaying posts.
 *
 * @package chiro-schelle-15
 */

?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

	<div class="entry-thumb">
		<?php the_post_thumbnail( $size, $attr ); ?>
	</div>
	<div class="entry-wrapper">
		<header class="entry-header">
			<?php the_title( sprintf( '<h1 class="entry-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h1>' ); ?>

			<?php if ( 'post' == get_post_type() ) : ?>
				<div class="entry-meta">
					<?php chiro_schelle_posted_on(); ?>
				</div>
			<?php endif; ?>
		</header>

		<div class="entry-content">
			<?php
				/* translators: %s: Name of current post */
				the_content( sprintf(
					wp_kses( __( 'Continue reading %s <span class="meta-nav">&rarr;</span>', 'chiro-schelle-15' ), array( 'span' => array( 'class' => array() ) ) ),
					the_title( '<span class="screen-reader-text">"', '"</span>', false )
				) );
			?>

			<?php
				wp_link_pages( array(
					'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'chiro-schelle-15' ),
					'after'  => '</div>',
				) );
			?>
		</div>

		<footer class="entry-footer">
			<?php chiro_schelle_entry_footer(); ?>
		</footer>
	</div>
</article>
