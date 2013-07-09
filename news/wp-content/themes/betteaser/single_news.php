<?php get_header(); ?>
<div id="main-container" class="container">
    	
	<div id="newsContent">    	
            <?php //echo 'Word count: '.count_words($post->post_content); ?>
            
			<?php if(have_posts()) : while(have_posts()) : the_post(); ?>
			<div class="news-item">
                           
                            <h2><?php the_title(); ?></h2>
                             <?php echo "<img src='". catch_that_image()."' />" ?>
                                <p class="meta"> Published on <?php the_date(); ?> </p>				
				<?php //the_content('read more...'); ?>
				<?php $content = get_the_content();
                                    $postOutput = preg_replace('/<img[^>]+./','', $content);
                                    $chapo=extract_unit($postOutput, '<blockquote>', '</blockquote>');
                                    $postOutput=ereg_replace('\<blockquote\>.*\<\/blockquote\>','',$postOutput);
                                    echo "<p class='chapo'>".$chapo."</p>";
                                    echo "<p class='col'>".$postOutput."</p>";
                                ?>

                                <div id="morePrev">
                                    <a href="<?php echo bloginfo('url') . '/'  ?>">Back...</a>
                                </div>
			</div> <!-- end post-item-->

			<?php endwhile; endif; ?>
			
		
	</div><!-- end primary-->
	

    <?php get_sidebar('news'); ?>
   </div><!-- main container -->
   <div class="container">
        <img src="<?php echo bloginfo('template_directory') . '/images/paymethods.gif'; ?> " alt="payment"/>
    </div>

<?php get_footer(); ?>