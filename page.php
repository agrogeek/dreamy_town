<?php
	// Return post 
if(empty($_POST['ajax']) || $_POST['ajax']===false) :
	get_header();
endif
	// Get post content
	if ( have_posts() ) : the_post();
		get_template_part( 'content', 'post' );

		// If comments are open or we have at least one comment, load up the comment template.
		if ( comments_open() || get_comments_number() ) {
			comments_template();
		}
	endif;
if(empty($_POST['ajax']) || $_POST['ajax']===false) :
	get_footer();
endif;