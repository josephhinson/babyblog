<?php
add_action( 'admin_menu', 'bb_admin_menu' );
function bb_admin_menu() {
	add_options_page( 'Babybook Options', 'Babybook Options', 'manage_options', 'bb-options', 'bb_options_page' );
}
// initialize the settings groups
add_action( 'admin_init', 'bb_admin_init' );
function my_admin_init() {
	register_setting( 'my-settings-group', 'my-setting' );
	add_settings_section( 'section-one', 'Section One', 'section_one_callback', 'my-plugin' );
	add_settings_field( 'field-one', 'Field One', 'field_one_callback', 'my-plugin', 'section-one' );
}