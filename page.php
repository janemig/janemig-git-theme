
<?php
/**
 * The template for displaying all pages.
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site will use a
 * different template.
 *
 * Please see /external/starkers-utilities.php for info on get_template_parts()
 *
 * @package 	WordPress
 * @subpackage 	Starkers
 * @since 		Starkers 4.0
 */
?>
<?php get_template_parts( array( 'parts/shared/html-header', 'parts/shared/header' ) ); ?>

			<?php if ( have_posts() ): ?>
			
			<?php while ( have_posts() ) : the_post(); ?>
				
						<h2><a href="<?php esc_url( the_permalink() ); ?>" title="Permalink to <?php the_title(); ?>" rel="bookmark"><?php the_title(); ?></a></h2>
					
						<?php the_content(); ?>
					
			<?php endwhile; ?>
			
			<?php else: ?>
		
			<h2>No posts to display</h2>
			<?php endif; ?>	
			
					<p>page!.php</p>
					
		</div><!--/content-->

<?php get_template_parts( array( 'parts/shared/footer','parts/shared/html-footer') ); ?>