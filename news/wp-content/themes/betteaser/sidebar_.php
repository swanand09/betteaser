<div id="sidebar">
    <img src="<?php echo bloginfo('template_directory') . '/images/news/tplus.jpg'; ?> " />
    <?php $i=0; if (have_posts()) : while (have_posts()) : the_post(); ?>
                    <?php if ( in_category('Blog') ) { ?>
                    <?php $category = get_the_category(); if($i==0){ $i++; echo "<span class='blockTitle' >".$category[0]->cat_name."</span>"; } ?> 
                    <div class="post-blog">
                        <?php userphoto_the_author_photo() ?>
                        <h2><a href="<?php the_permalink() ?>" ><?php the_title(); ?></a></h2>
                        by <?php the_author() ?>
                    </div> <!-- end post-item-->
                     <?php } ?>
                <?php endwhile; ?>

            <?php else : ?>
                </p>I'm not sure what you're looking for. 
            <?php endif; ?>
                
    <div class="secondaryBox" id="search">
        <h3>Search Article</h3>
        <?php include TEMPLATEPATH . '/searchform.php' ?>

    </div><!--end secondaryBox -->

    <?php
    if (!function_exists('dynamic_sidebar')
            || !dynamic_sidebar()) :
        ?>
        <p> You're not using a dynamic sidebar, silly! </p>

<?php endif; ?>	


    

</div><!-- end sidebar -->