<?php get_header(); ?>
<div id="main-container" class="container">
    	
	<div id="itvContent"> 
                      
			<?php if(have_posts()) : while(have_posts()) : the_post(); ?>
			<div class="itv-item">
                            <h2><?php the_title(); ?></h2>
                            <?php if(catch_that_image()!='') echo "<img src='". catch_that_image()."' />" ?>
                                <p class="meta"> Published on <?php the_date(); ?> </p>				
				<?php //the_content('read more...'); ?>
				<?php $content = get_the_content();
                                    $postOutput = preg_replace('/<img[^>]+./','', $content);
                                    $chapo=extract_unit($postOutput, '<blockquote>', '</blockquote>');
                                    $postOutput=ereg_replace('\<blockquote\>.*\<\/blockquote\>','',$postOutput);
                                    echo "<p class='chapo'>".$chapo."</p>";
                                    if(count_words($post->post_content)<200){
                                        echo "<p>".$postOutput."</p>";
                                    }else{
                                        echo "<p class='col'>".$postOutput."</p>";
                                    }
                                ?>
                                <div id="morePrev">
                                    <a href="<?php echo bloginfo('url') . '/'  ?>">Back...</a>
                                </div>
			</div> <!-- end post-item-->

			<?php endwhile; endif; ?>
			
		
	</div><!-- end primary-->
	

    <?php get_sidebar(); ?>
   </div><!-- main container -->
   <div class="container">
        <img src="<?php echo bloginfo('template_directory') . '/images/paymethods.gif'; ?> " alt="payment"/>
    </div>

<?php get_footer(); ?>