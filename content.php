<?php
/**
 * The default template for displaying content
 *
 * Used for both single and index/archive/search.
 *
 * @package Disueños
 * @subpackage Dreamy_Town
 * @since esArroyo.es 2014
 */
?>
<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<h1><?php the_title();	?></h1>
	<?php dreamy_town_post_thumbnail(); ?>

	<div class="entry-meta">
		<?php

			edit_post_link( __( 'Edit', 'dreamy_town' ), '<span class="edit-link">', '</span>' );
		?>
	</div><!-- .entry-meta -->

	<div class="entry-content">
		<?php
			the_content( __( 'Continue reading <span class="meta-nav">&rarr;</span>', 'dreamy_town' ) );
			wp_link_pages( array(
				'before'      => '<div class="page-links"><span class="page-links-title">' . __( 'Pages:', 'dreamy_town' ) . '</span>',
				'after'       => '</div>',
				'link_before' => '<span>',
				'link_after'  => '</span>',
			) );
		?>
	</div><!-- .entry-content -->

	<?php the_tags( '<footer class="entry-meta"><span class="tag-links">', '', '</span></footer>' ); ?>
</article><!-- #post-## -->
