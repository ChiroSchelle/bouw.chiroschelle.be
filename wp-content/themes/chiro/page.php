<?php
/**
 * @package WordPress
 * @subpackage Default_Theme
 */

get_header(); ?>


<?php if (have_posts()) : while (have_posts()) : the_post(); ?>

<div id="kijkerbackground">
      <div id="kijker">   
       	  <div id="pijlgezicht"></div>                               
        <div>
                    <div id="kijkerfiguur">
                    	<?php the_post_thumbnail( array(100,100) ); ?>
                    </div>
                    <div id="kijkertekst">
                        <h1><?php the_title(); ?><?php edit_post_link('Bewerk', ' - ', ''); ?></h1>   
                    </div>
        </div>  
                <div class="cleaner"></div>    
            </div>
  
    </div>
    
    <div id="main1">
    	<div id="main2">    
            <div id="right"></div>
            <div id="middle">   
            	<div id="pijl"></div> 
                
                <div class="post">
                    <div class="inhoudfiguur">
                        &nbsp;
                    </div>
                
                    <div id="inhoudtekst">
        	                <?php the_content('<p class="serif">Read the rest of this page &raquo;</p>'); ?>
							<?php wp_link_pages(array('before' => '<p><strong>Pages:</strong> ', 'after' => '</p>', 'next_or_number' => 'number')); ?>
                    </div>  
                     <div class="cleaner"></div> 
                </div>            
                
                
                <?php endwhile; endif; ?>
					
	
					<?php comments_template(); ?>
                
                  <div class="cleaner"></div>       
            </div>
		</div>
    </div>
	
	</div>

<?php get_footer(); ?>