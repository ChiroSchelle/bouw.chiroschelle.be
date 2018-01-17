<?php
/**
 * The template for displaying comments.
 *
 * The area of the page that contains both current comments
 * and the comment form.
 *
 * @package chiro_schelle
 */

/*
 * If the current post is protected by a password and
 * the visitor has not yet entered the password we will
 * return early without loading the comments.
 */
if ( post_password_required() ) {
	return;
}
?>

<div id="comments" class="comments-area">
	<?php // You can start editing here -- including this comment! ?>

	<?php if ( have_comments() ) : ?>
		<h3 class="comments-title">
			<?php
				printf( // WPCS: XSS OK.
					esc_html( _nx( 'Één reactie op &ldquo;%2$s&rdquo;', '%1$s reacties op &ldquo;%2$s&rdquo;', get_comments_number(), 'comments title', 'chiro_schelle' ) ),
					number_format_i18n( get_comments_number() ),
					'<span>' . get_the_title() . '</span>'
				);
			?>
		</h3>

		<?php if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) : // Are there comments to navigate through? ?>
		<nav id="comment-nav-above" class="navigation comment-navigation" role="navigation">
			<h4 class="screen-reader-text"><?php esc_html_e( 'Comment navigation', 'chiro_schelle' ); ?></h4>
			<div class="nav-links">

				<div class="nav-previous"><?php previous_comments_link( esc_html__( 'Older Comments', 'chiro_schelle' ) ); ?></div>
				<div class="nav-next"><?php next_comments_link( esc_html__( 'Newer Comments', 'chiro_schelle' ) ); ?></div>

			</div><!-- .nav-links -->
		</nav><!-- #comment-nav-above -->
		<?php endif; // Check for comment navigation. ?>

		<ol class="comment-list">
			<?php
				wp_list_comments('callback=mytheme_comment');
			?>
		</ol><!-- .comment-list -->

		<?php if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) : // Are there comments to navigate through? ?>
		<nav id="comment-nav-below" class="navigation comment-navigation" role="navigation">
			<h2 class="screen-reader-text"><?php esc_html_e( 'Comment navigation', 'chiro_schelle' ); ?></h2>
			<div class="nav-links">

				<div class="nav-previous"><?php previous_comments_link( esc_html__( 'Older Comments', 'chiro_schelle' ) ); ?></div>
				<div class="nav-next"><?php next_comments_link( esc_html__( 'Newer Comments', 'chiro_schelle' ) ); ?></div>

			</div><!-- .nav-links -->
		</nav><!-- #comment-nav-below -->
		<?php endif; // Check for comment navigation. ?>

	<?php endif; // Check for have_comments(). ?>

	<?php

		$fields =  array(

		  'author' =>
		    '<input id="author" name="author" type="text" placeholder="Je naam" value="' . esc_attr( $commenter['comment_author'] ) .
		    '" size="30"' . $aria_req . ' />',

		  'email' =>
		    '<input id="email" name="email" type="text" placeholder="Je email adres" value="' . esc_attr(  $commenter['comment_author_email'] ) .
		    '" size="30"' . $aria_req . ' />',
		);


		$args = array(
		  'id_form'           => 'commentform',
		  'id_submit'         => 'submit',
		  'class_submit'      => 'submit',
		  'name_submit'       => 'submit',
		  'title_reply'       => __( 'Plaats een reactie' ),
		  'title_reply_to'    => __( 'Leave a Reply to %s' ),
		  'cancel_reply_link' => __( 'Cancel reactie' ),
		  'label_submit'      => __( 'Plaats reactie' ),
		  'format'            => 'html5',

		  'comment_field' =>  '<textarea name="comment" aria-required="true" placeholder="Schrijf hier je toffe reactie!"></textarea>',

		  'comment_notes_before' => '<p class="comment-notes">' .
		    __( 'Your email address will not be published.' ) . ( $req ? $required_text : '' ) .
		    '</p>',

		  'comment_notes_after' => '',

		  'fields' => apply_filters( 'comment_form_default_fields', $fields ),
		);


		comment_form($args); ?>

</div><!-- #comments -->
