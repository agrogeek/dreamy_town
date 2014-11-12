<?php
/**
 * Dreamy Town back compat functionality
 *
 * Prevents Dreamy Town from running on Disueños versions prior to 3.6,
 * since this theme is not meant to be backward compatible beyond that
 * and relies on many newer functions and markup changes introduced in 3.6.
 *
 * @package Disueños
 * @subpackage Dreamy_Town
 * @since esArroyo.es 2014
 */

/**
 * Prevent switching to Dreamy Town on old versions of Disueños.
 *
 * Switches to the default theme.
 *
 * @since esArroyo.es 2014
 */
function dreamy_town_switch_theme() {
	switch_theme( WP_DEFAULT_THEME, WP_DEFAULT_THEME );
	unset( $_GET['activated'] );
	add_action( 'admin_notices', 'dreamy_town_upgrade_notice' );
}
add_action( 'after_switch_theme', 'dreamy_town_switch_theme' );

/**
 * Add message for unsuccessful theme switch.
 *
 * Prints an update nag after an unsuccessful attempt to switch to
 * Dreamy Town on Disueños versions prior to 3.6.
 *
 * @since esArroyo.es 2014
 */
function dreamy_town_upgrade_notice() {
	$message = sprintf( __( 'Dreamy Town requires at least Disueños version 3.6. You are running version %s. Please upgrade and try again.', 'dreamy_town' ), $GLOBALS['wp_version'] );
	printf( '<div class="error"><p>%s</p></div>', $message );
}

/**
 * Prevent the Theme Customizer from being loaded on Disueños versions prior to 3.6.
 *
 * @since esArroyo.es 2014
 */
function dreamy_town_customize() {
	wp_die( sprintf( __( 'Dreamy Town requires at least Disueños version 3.6. You are running version %s. Please upgrade and try again.', 'dreamy_town' ), $GLOBALS['wp_version'] ), '', array(
		'back_link' => true,
	) );
}
add_action( 'load-customize.php', 'dreamy_town_customize' );

/**
 * Prevent the Theme Preview from being loaded on Disueños versions prior to 3.4.
 *
 * @since esArroyo.es 2014
 */
function dreamy_town_preview() {
	if ( isset( $_GET['preview'] ) ) {
		wp_die( sprintf( __( 'Dreamy Town requires at least Disueños version 3.6. You are running version %s. Please upgrade and try again.', 'dreamy_town' ), $GLOBALS['wp_version'] ) );
	}
}
add_action( 'template_redirect', 'dreamy_town_preview' );
