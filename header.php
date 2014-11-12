<?php
/**
 * The Header for our theme
 *
 * Displays all of the <head> section and everything up till <div id="main">
 *
 * @package Disueños
 * @subpackage Dreamy_Town
 * @since esArroyo.es 2014
 */

	$options = get_option( 'dreamy_town_options' );


?><!DOCTYPE html>
<!--[if IE 7]>
<html class="ie ie7" <?php language_attributes(); ?>>
<![endif]-->
<!--[if IE 8]>
<html class="ie ie8" <?php language_attributes(); ?>>
<![endif]-->
<!--[if !(IE 7) | !(IE 8) ]><!-->
<html <?php language_attributes(); ?>>
<!--<![endif]-->
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width">
	<meta name="mobile-web-app-capable" content="yes">
	<link rel="icon" type="image/vnd.microsoft.icon" href="<?php echo get_template_directory_uri(); ?>/images/favicon.ico"/>
	
	<title>
		<?php bloginfo('title'); ?>
	</title>
	<link rel="profile" href="http://gmpg.org/xfn/11">
	<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">
	<!--[if lt IE 9]>
	<script src="<?php echo get_template_directory_uri(); ?>/js/html5.js"></script>
	<![endif]-->
	<?php wp_head(); ?>
</head>

<body <?php body_class(); error_log(var_export($options, true));?> data-lat="<?php echo $options['lat_textbox']; ?>" data-lng="<?php echo $options['lng_textbox']; ?>" data-zoom="<?php echo $options['zoom_textbox']; ?>">
	<div id="googlemaps"></div>
	<?php get_sidebar(); ?>
