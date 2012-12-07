<!-- Template: Home  -->
<?php
/**
 * The template for displaying home page.
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

	<?php get_the_post_thumbnail(); ?>
		
					<p>front-page.php</p>
					
		</div><!--/content-->

<?php get_template_parts( array( 'parts/shared/footer','parts/shared/html-footer') ); ?>