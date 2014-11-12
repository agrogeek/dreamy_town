<?php
	// Return post 
if(empty($_POST['ajax']) || $_POST['ajax']!="true") :
	get_header();
?> <div id="container"> <?php
endif;

// Get post content
if ( have_posts() ) : the_post();
?><span id="main-hide"></span>
<div id="main"><?php
get_template_part( 'content', 'post' );

		// If comments are open or we have at least one comment, load up the comment template.
/*
Disable comments
if ( comments_open() || get_comments_number() ) {
	comments_template();
}*/
?></div><?php
endif;

if(empty($_POST['ajax']) || $_POST['ajax']!="true") :
	?> </div> <?php
global $category_slug, $is_single;
$category = get_the_category();
$category_slug = $category[0]->slug;
$is_single = true;
get_footer();
endif;