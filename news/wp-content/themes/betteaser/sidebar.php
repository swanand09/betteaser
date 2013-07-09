<div id="sidebar">
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
                <span id="press">PRESS & MEDIA</span>
                <a href="http://www.mauritiusturfclub.com/" target="_blank"><img alt="Official Website" src="<?php echo bloginfo('template_directory') . '/images/news/tclub.jpg'; ?> " /></a><br/><br/>
                <a href="http://webtv.defimedia.info/sport/" target="_blank"><img src="<?php echo bloginfo('template_directory') . '/images/news/tplus.jpg'; ?> " /></a><br/><br/>
                <a href="http://mbc.intnet.mu/mbc/prod_sport" target="_blank"><img src="<?php echo bloginfo('template_directory') . '/images/news/ttime.jpg'; ?> " /></a><br/><br/>        
                <a href="http://sport.defimedia.info/hippisme/turf-infos/" target="_blank"><img src="<?php echo bloginfo('template_directory') . '/images/news/tinfo.jpg'; ?> " /></a><br/><br/>
                <a href="http://www.lemauricien-ltd.com/" target="_blank"><img src="<?php echo bloginfo('template_directory') . '/images/news/tmag.jpg'; ?> " /></a><br/><br/>        
                <a href="http://www.lematinal.com/turf/" target="_blank"><img src="<?php echo bloginfo('template_directory') . '/images/news/lm.jpg'; ?> " /></a>        

</div><!-- end sidebar -->