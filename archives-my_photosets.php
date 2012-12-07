<?php
/*
Template Name: Archive-My_Photosets
 */
?>
<?php get_template_parts( array( 'parts/shared/html-header', 'parts/shared/header' ) ); ?>


<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
	
		<article>
			
			<p>archive-my_photosets.php</p>
			<!-- <h2><a href="<?php esc_url( the_permalink() ); ?>" title="Permalink to <?php the_title(); ?>" rel="bookmark"><?php the_title(); ?></a></h2> -->
			
				<!-- Post Thumbnail -->
				<?php if ( has_post_thumbnail()) : // Check if Thumbnail exists ?>
					<a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>">
						<?php the_post_thumbnail(array(150, 150)); // Declare pixel size you need inside the array ?>
						<?php echo do_shortcode("[gallery]"); ?>
					</a>
				<?php endif; ?>
				<!-- /Post Thumbnail -->
			
			<?php the_content(); ?>
				
		</article>
	
<?php endwhile; ?>
</ol>
<?php else: ?>
<h2>No wishbone paintings to display</h2>	
<?php endif; ?>
</div><!--/content-->

	<script type="text/javascript" charset="utf-8">
		Shadowbox.init();
	</script>


<?php get_template_parts( array( 'parts/shared/footer','parts/shared/html-footer' ) ); ?>