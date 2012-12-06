
<div id="topblack" class="shadow" >

<!-- Took off wrap -->
<!-- <div class="wrap"> --> 

<header>
    	<div id="logo">
           <h1><a href="<?php echo home_url( '/' ); ?>"><?php bloginfo( 'name' ); ?></a></h1>
       </div><!--/logo-->

       <div id="paintings-top"><a href="<?php echo home_url( '/' ); ?>"><?php bloginfo( 'description' ); ?></a></div>
		
		
	
		
		
       <div id="top-menu">
              <ul>
                  <?php wp_nav_menu( array( 'theme_location' => 'top_menu' ) ); ?>
              </ul>
      </div><!--/top-menu-->   
    </header><!--/header-->

</div><!--/topblack-->

<div class="main">
	
	<?php get_sidebar('left'); ?>
	
	<div class="content">
		
			<div id="loading"></div>
		
