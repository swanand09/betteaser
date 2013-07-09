<?php
$post = $wp_query->post;
if ( in_category('News') ) {
include(TEMPLATEPATH . '/single_news.php');
}elseif( in_category('Blog') ) {
include(TEMPLATEPATH . '/single_blog.php');
}
else {
include(TEMPLATEPATH . '/single_itv.php');
}
?>