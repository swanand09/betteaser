<?php get_header(); ?>
<div id="main-container" class="container">
    	<div id="blogContent">    			
			<?php if(have_posts()) : while(have_posts()) : the_post(); ?>
			<div class="post-item">
                                <?php userphoto_the_author_photo() ?>
                                <h2><?php the_title(); ?></h2><p id="auth">by <?php the_author() ?></p>
                                <p class="meta"> Published on <?php the_date(); ?> </p>	
                                <?php the_content('read more...'); ?>
                                <div id="morePrev">
                                    <a href="<?php echo bloginfo('url') . '/'  ?>">Back...</a>
                                </div>
			</div> <!-- end post-item-->

			<?php endwhile; endif; ?>
			
		
	</div><!-- end primary-->
	

    <?php get_sidebar('blog'); ?>
   </div><!-- main container -->
   <div class="container">
        <img src="<?php echo bloginfo('template_directory') . '/images/paymethods.gif'; ?> " alt="payment"/>
    </div>

<?php get_footer(); ?>