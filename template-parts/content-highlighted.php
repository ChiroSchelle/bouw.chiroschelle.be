<?php
/**
 * Template part for displaying posts.
 *
 * @package gidsen-sint-jan
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
					<?php gidsen_sint_jan_posted_on(); ?>
				</div>
			<?php endif; ?>
		</header>

		<div class="entry-content">
			<?php
				/* translators: %s: Name of current post */
				the_content( sprintf(
					wp_kses( __( 'Continue reading %s <span class="meta-nav">&rarr;</span>', 'gidsen-sint-jan' ), array( 'span' => array( 'class' => array() ) ) ),
					the_title( '<span class="screen-reader-text">"', '"</span>', false )
				) );
			?>

			<?php
				wp_link_pages( array(
					'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'gidsen-sint-jan' ),
					'after'  => '</div>',
				) );
			?>
		</div>

		<footer class="entry-footer">
			<?php gidsen_sint_jan_entry_footer(); ?>
		</footer>
	</div>
</article>
