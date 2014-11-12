<?php
/**
 * The main template file
 *
 * This is the most generic template file in a Disueños theme and one
 * of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query,
 * e.g., it puts together the home page when no home.php file exists.
 *
 * @link http://codex.Disueños.org/Template_Hierarchy
 *
 * @package Disueños
 * @subpackage Dreamy_Town
 * @since esArroyo.es 2014
 */

global $category_slug;
$category_slug = "all";

// Index page
	get_header(); ?>
	<div id="container"></div>
	<?php get_footer();
?>