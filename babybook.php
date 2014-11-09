<?php
/**
 * @package Babybook_Functionality
 * @version 1.0
 */
/*
Plugin Name: Baby Blog
Plugin URI: http://babybookthemes.com/
Description: This plugin extends the functionality of a normal WordPress blog to that of a Baby Book.
Author: Joseph Hinson
Version: 1.0
Author URI: http://babybookthemes.com/
*/


/*
Section: About the Baby
	- Baby's Birthday
	- Baby's Name

Section: Blog Setup (In order for your widgets to function properly):
	- Firsts category
	- Milestones Category
	- Photos Category
	- Videos Category
*/
// initialize admin menu:
add_action( 'admin_menu', 'bb_admin_menu' );
function bb_admin_menu() {
    add_options_page( 'Babyblog Options', 'BabyBlog Options', 'manage_options', 'babyblog', 'bb_options_page' );
}

add_action( 'admin_init', 'bb_admin_init' );
function bb_admin_init() {
$settings = get_option('bb-settings');
    register_setting( 'bb-settings-group', 'bb-settings' );
    add_settings_section( 'section-one', 'About the Baby', 'section_one_callback', 'babyblog' );
	// adding the "baby's Name Field"
	add_settings_field( 'bb_name', 'Baby\'s Name', 'bb_text_input', 'babyblog', 'section-one', array(
	    'name' => 'bb-settings[bb_name]',
	    'value' => $settings['bb_name'],
	) );
	add_settings_field( 'bb_birthday', 'Baby\'s Birthday', 'bb_text_input', 'babyblog', 'section-one', array(
	    'name' => 'bb-settings[bb_birthday]',
	    'value' => $settings['bb_birthday'],
		'help' => ' <small>(MM/DD/YYYY)</small>'
	) );
	add_settings_section( 'section-two', 'Photos, Milestones, and Firsts', 'section_one_callback', 'babyblog' );

	add_settings_field( 'bb_photos', 'Photos Category', 'bb_cat_dropdown', 'babyblog', 'section-two', array(
	    'name' => 'bb-settings[bb_photos]',
	    'value' => $settings['bb_photos'],
		'help' => ' <small>(This category will be used to pull in the photos if you use the widget)</small>',
		'title' => 'Photos'
	) );
	
}
function section_one_callback() {
}

function bb_text_input( $args ) {
    $name = esc_attr( $args['name'] );
    $value = esc_attr( $args['value'] );
    echo "<input type='text' name='$name' value='$value' />";
	echo $args['help'];
}

function bb_cat_dropdown( $args ) {
    $name = esc_attr( $args['name'] );
	$title = esc_attr( $args['title']);
	$value = esc_attr( $args['value'] );
	$ddargs = array(
		'show_option_none' => 'Select Category for '.$title,
		'hide_empty' => 0,
		'name' => $name,
		'orderby' => 'name'
	);
	if ($value != '0') {
		$ddargs['selected'] = $value;
	}
	wp_dropdown_categories($ddargs);
	echo $args['help'];
}


function bb_options_page() {
    ?>
    <div class="wrap">
        <h2>BabyBlog Options</h2>
        <form action="options.php" method="POST">
            <?php settings_fields( 'bb-settings-group' ); ?>
            <?php do_settings_sections( 'babyblog' ); ?>
            <?php submit_button(); ?>
        </form>
    </div>
    <?php
}

include 'functions/widgets.php';
include 'functions/bb_functions.php';
include 'functions/filters.php';
include 'functions/shortcodes.php';
include 'functions/bb_meta.php';
?>