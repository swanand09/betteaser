<?php get_header(); ?>
<div id="main-container" class="container">
    
        <div id="primary">
            <?php $i=0; if (have_posts()) : while (have_posts()) : the_post(); ?>
                    <?php if ( in_category('News') ) {  ?>
                    <div class="post-item">
                        <?php $category = get_the_category(); if($i==0){ $i++; echo "<span class='blockTitle' >".$category[0]->cat_name."</span>"; } ?> 
                        <h2><?php the_title(); ?></h2>
                        <?php the_content('read more...'); ?>

                        <p class="meta"> Published on <?php the_date(); ?> </p>
                    </div> <!-- end post-item-->
                     <?php } ?>
                <?php endwhile; ?>

            <?php else : ?>
                </p>I'm not sure what you're looking for. 
            <?php endif; ?>
        </div><!-- end primary -->

        <div id="middle">
             <?php $i=0; if (have_posts()) : while (have_posts()) : the_post(); ?>
                    <?php if ( in_category('Training') ) {  ?>
                    <div class="middle-blog">
                        <?php $category = get_the_category(); if($i==0){ $i++; echo "<span class='blockTitle' >".$category[0]->cat_name."</span>"; } ?> 
                        <h2><?php the_title(); ?></h2>
                        <?php the_content('read more...'); ?>

                        <p class="meta"> Published on <?php the_date(); ?> </p>
                    </div> <!-- end post-item-->
                     <?php } ?>
                <?php endwhile; ?>

            <?php else : ?>
                </p>I'm not sure what you're looking for. 
            <?php endif; ?>
                
                <?php $i=0; if (have_posts()) : while (have_posts()) : the_post(); ?>
                    <?php if ( in_category('Eye Catchers') ) {  ?>
                    <div class="middle-blog">
                        <?php $category = get_the_category(); if($i==0){ $i++; echo "<span class='blockTitle' >".$category[0]->cat_name."</span>"; } ?> 
                        <h2><?php the_title(); ?></h2>
                        <?php the_content('read more...'); ?>

                        <p class="meta"> Published on <?php the_date(); ?> </p>
                    </div> <!-- end post-item-->
                     <?php } ?>
                <?php endwhile; ?>

            <?php else : ?>
                </p>I'm not sure what you're looking for. 
            <?php endif; ?>
            
           <?php $i=0; if (have_posts()) : while (have_posts()) : the_post(); ?>
                    <?php if ( in_category('Interview') ) {  ?>
                    <div class="middle-blog">
                        <?php $category = get_the_category(); if($i==0){ $i++; echo "<span class='blockTitle' >".$category[0]->cat_name."</span>"; } ?> 
                        <h2><?php the_title(); ?></h2>
                        <?php the_content('read more...'); ?>

                        <p class="meta"> Published on <?php the_date(); ?> </p>
                    </div> <!-- end post-item-->
                     <?php } ?>
                <?php endwhile; ?>

            <?php else : ?>
                </p>I'm not sure what you're looking for. 
            <?php endif; ?>
                
           <?php $i=0; if (have_posts()) : while (have_posts()) : the_post(); ?>
                    <?php if ( in_category('Next Week') ) {  ?>
                    <div class="middle-blog">
                        <?php $category = get_the_category(); if($i==0){ $i++; echo "<span class='blockTitle' >".$category[0]->cat_name."</span>"; } ?> 
                        <h2><?php the_title(); ?></h2>
                        <?php the_content('read more...'); ?>

                        <p class="meta"> Published on <?php the_date(); ?> </p>
                    </div> <!-- end post-item-->
                     <?php } ?>
                <?php endwhile; ?>

            <?php else : ?>
                </p>I'm not sure what you're looking for. 
            <?php endif; ?>
        </div><!-- end middle -->
        
        <?php get_sidebar(); ?>
    
    
</div><!-- main container -->


<div class="container">
<img src="<?php echo bloginfo('template_directory') . '/images/paymethods.gif'; ?> " alt="payment"/>
</div>
<?php get_footer(); ?>