<?php get_header(); ?>
<div id="main-container" class="container">
    <div id="primary">
        <div id="page_content">
            <h3>Search Results</h3>
            <ul>
                <?php if(have_posts()) : while(have_posts()) : the_post(); ?>
                <li> <a href="<?php the_permalink() ?>"> <?php the_title(); ?></a><span class="pdate">posted on <?php the_date(); ?></span></li>
                <?php endwhile; ?>
            </ul>
        </div> <!-- end result_content-->


        <div id="morePrev">
            <?php next_posts_link('More...'); ?>
            <?php previous_posts_link('Back...'); ?>
        </div>



        <?php else : ?>
            </p>I'm not sure what you're looking for. 
        <?php endif; ?>					

    </div><!-- end primary -->

    <?php get_sidebar(); ?>
    <img src="<?php echo bloginfo('template_directory').'/images/paymethods.gif'; ?> " alt="payment"/>
</div><!-- main container -->
<?php get_footer(); ?>