<?php
/*
 * The main template file
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file 
 *
 * Please see /external/starkers-utilities.php for info on get_template_parts()
 *
 
 */
?>
<?php get_template_parts( array( 'parts/shared/html-header', 'parts/shared/header' ) ); ?>


			<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
			
					<article>
						
						<?php the_content(); ?>
					</article>
				
			<?php endwhile; ?>
		
			<?php else: ?>
				
			<h2>No posts to display</h2>
			<?php endif; ?>	
			
				<p>index.php</p>
				
		</div><!--/content-->


<?php get_template_parts( array( 'parts/shared/footer','parts/shared/html-footer') ); ?>