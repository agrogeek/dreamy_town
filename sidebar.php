<?php
/**
 * The Sidebar containing the main widget area
 *
 * @package Disueños
 * @subpackage Dreamy_Town
 * @since esArroyo.es 2014
 */
?>
<div id="sidebar">
<h1>
	<a href="<?php echo home_url();?>" data-type_link="category" data-category="all">
		<img src="<?php bloginfo('template_url');?>/images/logo.png">
	</a>
</h1>
	<!-- <nav id="markers">
	<a href="<?php echo home_url(); ?>" data-type_link="category" data-category="all">Todas</a>
		<?php
		$args = array(
			'orderby' => 'name',
			'parent' => 0
			);
		$categories = get_categories( $args );
		foreach ( $categories as $category ) {
			echo '<a href="' . get_category_link( $category->term_id ) . '" data-type_link="category" data-category="' . $category->slug . '">' . $category->name . '</a>';
		}
		?>
	</nav> -->
</div>
