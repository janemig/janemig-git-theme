<?php
/*
 * The Template for displaying all single posts
 
 */
?>
<?php get_template_parts( array( 'parts/shared/html-header', 'parts/shared/header' ) ); ?>


			<?php if ( have_posts() ) while ( have_posts() ) : the_post(); ?>

				<h2><?php the_title(); ?></h2>
				
				<!-- Post Thumbnail -->
				<?php if ( has_post_thumbnail()) : // Check if Thumbnail exists ?>
				
						<?php the_post_thumbnail( 'large' ); // Declare pixel size you need inside the array ?>				
				<?php endif; ?>
				<!-- /Post Thumbnail -->
				
				<?php the_content(); ?>			

			<?php endwhile; ?>
			
			<p>single-my_wishbones.php</p>
		</div><!--/content-->

		<script type="text/javascript" charset="utf-8">
			Shadowbox.init();
		</script>
		
<?php get_template_parts( array( 'parts/shared/footer','parts/shared/html-footer' ) ); ?>