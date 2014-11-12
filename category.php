<?php

$cat = get_category(get_query_var("cat"));
global $category_slug;
$category_slug = $cat->slug;


// HTML + JS in HTTP request
	get_header(); ?>
	<div id="container"></div>
	<?php get_footer();