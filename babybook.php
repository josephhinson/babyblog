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
include 'functions/widgets.php';
include 'functions/bb_functions.php';
include 'functions/filters.php';
include 'functions/shortcodes.php';
include 'functions/bb_meta.php';
$interface = "Babybook";  
add_action('admin_menu', 'add_welcome_interface');
add_action('admin_init', 'imprint_head');

function add_welcome_interface() {
  add_menu_page($interface . 'Babybook Options', 'Babybook Options', '8', 'functions', 'editoptions');
  }

// Content on Options Page
function editoptions() {  ?>
	<div class='wrap'>
		<h2 class="imprint-title">Babybook Options</h2>
		<?php if($_GET['settings-updated'] == 'true') : ?>
			<div id="message" class="updated">
				<p>Settings updated!</p>
			</div>
		<?php endif; ?>
		<form method="post" action="options.php">
		<?php wp_nonce_field('update-options') ?>
		<div class="options book-info">
			<h3>Child Settings</h3>
			<div>
				<p>Use the settings below to customize how your blog will display everything in the world.</p>
			</div>
			<div class="col first">
				<p>Child's Birthday <small>(ex: 06/24/2010)</small></p>
				<p><input type="text" name="bb_birthday" id="bb_birthday" value="<?php echo get_option('bb_birthday'); ?>"></p>
				<p><strong>Firsts Page</strong></p>
				<?php
					$arr = array(
						'option_none_value' => 0,
						'show_option_none' => 'Please Choose your Firsts Page',
						'name' => 'io_blog_page'
					); 
				if (get_option('io_blog_page') != '0') {
					$arr['selected'] = get_option('io_blog_page');
				} else {
					echo '<p class="notify">You must set this option for this theme to work properly.</p>';
				} ?>
				<p><?php wp_dropdown_pages($arr); ?></p>
				
				<p><strong>About Page</strong></p>
				<?php
					$arg = array(
						'option_none_value' => 0,
						'show_option_none' => 'Please Choose your Photos Category',
						'name' => 'io_about_page'
					); 
				if (get_option('io_about_page') != '0') {
					$arg['selected'] = get_option('io_about_page');
				} else {
					echo '<p class="notify">You must set this option for this theme to work properly.</p>';
				} ?>
				<p><?php wp_dropdown_pages($arg); ?></p>

				<p><strong>Featured Book</strong><br><small>Please Select the book you would like to feature on the home page</small></p>
				<?php
				// get all the books
				$books = get_posts('numberposts=-1&orderby=menu_order&order=ASC&post_type=book&post_status=publish');
				// if the featured book hasn't been assigned
				$fbook = get_option('io_featured_book');
				if ($fbook == '0') {
					// and if there are no books
					if(empty($books)) {
						echo '<p class="notify">You must first add books in order to set this option.</p>';
					} else {
					// otherwise, just tell the person to set the book
					echo '<p class="notify">You must set this option for this theme to work properly.</p>';
					}
				}?>
				<p>
					<select name="io_featured_book" id="io_featured_book">
					<?php
					// creating drop down for books
					// if no books are present, it only says "p lease choose your featured book" ?>
					<option value="0"<? if($fbook == '0') { echo ' selected="selected"'; } ?>>Please choose your featured book</option>
					<?
					foreach ($books as $book) { ?>
						<option class="level-0" <? if($fbook == $book->ID) { echo 'selected="selected" '; } ?> value="<? echo $book->ID; ?>"><? echo $book->post_title; ?></option>
					<? } // end loop through books
					?>
					</select>
				<?php //wp_dropdown_pages($args); ?></p>
			</div>
			<div class="col third">
				<p>Social Media</p>
				<p><label for="io_facebook_url">Facebook URL</label><input type="text" name="io_facebook_url" value="<?php echo get_option('io_facebook_url'); ?>" id="io_facebook_url" /></p>
			</div>
			<div class="clr"></div>
		</div>
		<p><input class="imprint_submit" type="submit" name="Submit" value="Update Options" /></p>
		<input type="hidden" name="action" value="update" />
		<input type="hidden" name="page_options" value="
		bb_birthday,
		bb_firsts_page,
		bb_milestones_page,
		bb_photos_category" />
		
		</form>
		<div style="clear:both;height:1px;margin-bottom:100px;"></div>
	</div>
<?php }

	function imprint_head() {
		$file_dir=get_bloginfo('url').'/wp-content/plugins/babybook';
		wp_enqueue_style("functions", $file_dir."/functions/themeoptions.css", false, "1.0", "all");
}
?>