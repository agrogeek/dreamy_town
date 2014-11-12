<?php
	get_header();
	if ( have_posts() ) : the_post();
		get_template_part( 'content', get_post_format() );

		// If comments are open or we have at least one comment, load up the comment template.
		if ( comments_open() || get_comments_number() ) {
			comments_template();
		}
	endif;
	get_footer();