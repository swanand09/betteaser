<?php

// functions
if(function_exists('register_sidebar'))
{
	register_sidebar();
}

function count_words($str){
     $words = 0;
     $str = eregi_replace(" +", " ", $str);
     $array = explode(" ", $str);
     for($i=0;$i < count($array);$i++)
 	 {
         if (eregi("[0-9A-Za-zÀ-ÖØ-öø-ÿ]", $array[$i])) 
             $words++;
     }
     return $words;
 }
 
 function catch_that_image() {
  global $post, $posts;
  $first_img = '';
  ob_start();
  ob_end_clean();
  $output = preg_match_all('/<img.+src=[\'"]([^\'"]+)[\'"].*>/i', $post->post_content, $matches);
  $first_img = $matches [1] [0];

  if(empty($first_img)){ //Defines a default image
    //$first_img = "/images/default.jpg";
  }else{
      $imgExp=explode('.jpg',$first_img);
      $imgExp[0]=$imgExp[0].'_full.jpg';
      $first_img=implode($imgExp);
  }
  
  
  return $first_img;
}

function strip_images($content){
   return preg_replace('/<img[^>]+./','',$content);
}


function extract_unit($string, $start, $end)
{
$pos = stripos($string, $start);

$str = substr($string, $pos);

$str_two = substr($str, strlen($start));

$second_pos = stripos($str_two, $end);

$str_three = substr($str_two, 0, $second_pos);

$unit = trim($str_three); // remove whitespaces

return $unit;
}

function the_breadcrumb() {
		echo '<ul id="crumbs">';
	if (!is_home()) {
		echo '<li><a href="';
		echo get_option('home');
		echo '">';
		echo 'Home';
		echo "</a></li>";
		if (is_category() || is_single()) {
			echo '<li>';
			the_category(' </li><li> ');
			if (is_single()) {
				echo "</li><li>";
				the_title();
				echo '</li>';
			}
		} elseif (is_page()) {
			echo '<li>';
			echo the_title();
			echo '</li>';
		}
	}
	elseif (is_tag()) {single_tag_title();}
	elseif (is_day()) {echo"<li>Archive for "; the_time('F jS, Y'); echo'</li>';}
	elseif (is_month()) {echo"<li>Archive for "; the_time('F, Y'); echo'</li>';}
	elseif (is_year()) {echo"<li>Archive for "; the_time('Y'); echo'</li>';}
	elseif (is_author()) {echo"<li>Author Archive"; echo'</li>';}
	elseif (isset($_GET['paged']) && !empty($_GET['paged'])) {echo "<li>Blog Archives"; echo'</li>';}
	elseif (is_search()) {echo"<li>Search Results"; echo'</li>';}
	echo '</ul>';
}


?>