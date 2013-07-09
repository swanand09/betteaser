<div id="sidebar">
    <?php
    if (!function_exists('dynamic_sidebar')
            || !dynamic_sidebar()) :
        ?>
        <p> You're not using a dynamic sidebar, silly! </p>

    <?php endif; ?>	
    
</div><!-- end sidebar -->