<form method="get" id="searchform" action="<?php bloginfo('url'); ?>">
	<input type="text" name="s" id="s" value="<?php the_search_query(); ?>" placeholder="Search an article..." />
	<input type="submit" value="Search" id="searchsubmit" style="width: 80px; margin-top: 5px;" />
</form>	