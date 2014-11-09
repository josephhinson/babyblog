<?
// This is a widget for Babybook Milestones

// initializes the widget on WordPress Load
add_action('widgets_init', 'bb_milestones_init_widget');

// Should be called above from "add_action"
function bb_milestones_init_widget() {
	register_widget( 'BB_Milestones' );
}

// new class to extend WP_Widget function
class BB_Milestones extends WP_Widget {
	/** Widget setup.  */
	function BB_Milestones() {
		/* Widget settings. */
		$widget_ops = array(
			'classname' => 'bb_milestones_widget',
			'description' => __('Babybook Milestones', 'bb_milestones_widget') );

		/* Widget control settings. */
		$control_ops = array( 'width' => 300, 'height' => 350, 'id_base' => 'bb_milestones_widget' );

		/* Create the widget. */
		$this->WP_Widget( 'bb_milestones_widget', __('Babybook Milestones Widget', 'Options'), $widget_ops, $control_ops );
	}
	/**
	* How to display the widget on the screen. */
	function widget( $args, $instance ) {
		extract( $args );

		/* Before widget (defined by themes). */
		echo $before_widget;
		echo '<h3 class="widgettitle">Milestones</h3>';
		/* Display name from widget settings if one was input. */
		
		// Settings from the widget
		
		get_meta_posts('milestone', '10');
		
		/* After widget (defined by themes). */
		echo $after_widget;
	}


/**
 * Displays the widget settings controls on the widget panel.
 * Make use of the get_field_id() and get_field_name() function
 * when creating your form elements. This handles the confusing stuff.
*/
	function form() { ?>
		<!-- Widget Title: Text Input -->
		<p>This widget pulls the latest milestones into your sidebar and links to the corresponding posts.</p>
	<?php
	}
} // END BB_Milestones

//===========
// This is a widget for Babybook Firsts

// initializes the widget on WordPress Load
add_action('widgets_init', 'bb_firsts_init_widget');

// Should be called above from "add_action"
function bb_firsts_init_widget() {
	register_widget( 'BB_Firsts' );
}

// new class to extend WP_Widget function
class BB_Firsts extends WP_Widget {
	/** Widget setup.  */
	function BB_Firsts() {
		/* Widget settings. */
		$widget_ops = array(
			'classname' => 'bb_firsts_widget',
			'description' => __('Babybook Firsts', 'bb_firsts_widget') );

		/* Widget control settings. */
		$control_ops = array( 'width' => 300, 'height' => 350, 'id_base' => 'bb_firsts_widget' );

		/* Create the widget. */
		$this->WP_Widget( 'bb_firsts_widget', __('Babybook Firsts Widget', 'bb_firsts_widget'), $widget_ops, $control_ops );
	}
	/**
	* How to display the widget on the screen. */
	function widget( $args, $instance ) {
		extract( $args );

		/* Before widget (defined by themes). */
		echo $before_widget;
		echo '<h3 class="widgettitle">Firsts</h3>';
		/* Display name from widget settings if one was input. */
		
		// Settings from the widget
		// @NEEDFIX -- make the number customizable, as well as the title and link to see all posts.
		get_meta_posts('firsts', '10');
		
		/* After widget (defined by themes). */
		echo $after_widget;
	}


/**
 * Displays the widget settings controls on the widget panel.
 * Make use of the get_field_id() and get_field_name() function
 * when creating your form elements. This handles the confusing stuff.
*/
	function form() { ?>
		<!-- Widget Title: Text Input -->
		<p>This widget displays a list of posts that are marked as "firsts".</p>
		<?php
	}
} // END BB_Firsts

// This is a widget for Babybook Photos

// initializes the widget on WordPress Load
add_action('widgets_init', 'bb_photos_init_widget');

// Should be called above from "add_action"
function bb_photos_init_widget() {
	register_widget( 'BB_Photos' );
}

// new class to extend WP_Widget function
class BB_Photos extends WP_Widget {
	/** Widget setup.  */
	function BB_Photos() {
		/* Widget settings. */
		$widget_ops = array(
			'classname' => 'bb_photos_widget',
			'description' => __('Babybook Photos', 'bb_photos_widget') );

		/* Widget control settings. */
		$control_ops = array( 'width' => 300, 'height' => 350, 'id_base' => 'bb_photos_widget' );

		/* Create the widget. */
		$this->WP_Widget( 'bb_photos_widget', __('Babybook Photos Widget', 'Options'), $widget_ops, $control_ops );
	}
	/**
	* How to display the widget on the screen. */
	function widget( $args, $instance ) {
		extract( $args );

		/* Before widget (defined by themes). */
		echo $before_widget;
		echo '<h3 class="widgettitle">Photos</h3>';
		/* Display name from widget settings if one was input. */

				$bboptions = get_option('bb-settings');
				$photocat = $bboptions['bb_photos'];
				$photoargs = array(
					'cat' => $photocat,
					'posts_per_page' => '12'
				);
					$pPosts = get_posts($photoargs);

					if (!empty($pPosts)) : ?>
					<style type="text/css" media="screen">
						.sb_photos {
							min-width: 190px;
						}
						.sb_photos li {
							background:none;
							margin-right: 9px;
							float: left;
							margin-bottom: 9px;
							padding: 0;
							list-style:none;
						}
						.sb_photos li img {
							border:1px solid #A5D1FE;
							padding:1px;
							width:50px;
						}
					</style>
					<ul class="sb_photos">
						<?php foreach ($pPosts as $pPost):
							
							// Begin Photo Thumbnails
							$sb_photos = get_children( 'numberposts=3&post_type=attachment&post_mime_type=image&post_parent='.$pPost->ID );
							if (!empty($sb_photos)) : ?>
							<?php foreach($sb_photos as $sb_photo) : ?>
							<li>
								<a href="<?php echo get_permalink($pPost->ID); ?>" title="Link to <?php echo get_the_title($pPost->ID); ?>">
									<?php echo wp_get_attachment_image($sb_photo->ID, array(50,50)); ?>
								</a>
							</li>
							<?php
							endforeach; 
						endif; // END Photo thumbnails ?>
					<?php endforeach ?>
						<li style="clear:both;float:none;"></li><!--clearfix li-->
				<?php endif; // end check and loop ?>
				
				<li class="seeall"><a href="<?php echo get_category_link($photocat); ?>">See All Photos</a></li>
				<li style="clear:both;float:none;"></li>
				</ul>
		<?php
		
		/* After widget (defined by themes). */
		echo $after_widget;
	}


/**
 * Displays the widget settings controls on the widget panel.
 * Make use of the get_field_id() and get_field_name() function
 * when creating your form elements. This handles the confusing stuff.
*/
	function form() { ?>
		<!-- Widget Title: Text Input -->
		<p>This widget displays photos in a very cool format on the sidebar -- it pulls all photos attached to posts.</p>
	<?php
	}
} // END BB_Photos

// This is a widget for Babybook Baby Age

// initializes the widget on WordPress Load
add_action('widgets_init', 'bb_baby_age_init_widget');

// Should be called above from "add_action"
function bb_baby_age_init_widget() {
	register_widget( 'BB_Baby_Age' );
}

// new class to extend WP_Widget function
class BB_Baby_Age extends WP_Widget {
	/** Widget setup.  */
	function BB_Baby_Age() {
		/* Widget settings. */
		$widget_ops = array(
			'classname' => 'bb_baby_age_widget',
			'description' => __('Babybook Baby Age', 'bb_baby_age_widget') );

		/* Widget control settings. */
		$control_ops = array( 'width' => 300, 'height' => 350, 'id_base' => 'bb_baby_age_widget' );

		/* Create the widget. */
		$this->WP_Widget( 'bb_baby_age_widget', __('Babybook Baby Age Widget', 'Options'), $widget_ops, $control_ops );
	}
	/**
	* How to display the widget on the screen. */
	function widget( $args, $instance ) {
		extract( $args );
		$title = apply_filters('widget_title', $instance['title'] );

		/* Before widget (defined by themes). */
		echo $before_widget;
		if ( $title )
			echo $before_title . $title . $after_title;
		
		/* Display name from widget settings if one was input. */
		
		// Settings from the widget
		$bbsettings = get_option('bb-settings');
		$birthdate = date('Y-m-d', strtotime($bbsettings['bb_birthday']));
		$child = $bbsettings['bb_name'];		
		$today = strtotime('today');
		$today = date('Y-m-d', $today);
		$age = dateDiff($today, $birthdate);
		echo '<p class="age">'. $child.' is '.$age.' old today!</p>';
		/* After widget (defined by themes). */
		echo $after_widget;
	}

	/**
	 * Update the widget settings.
	 */
	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;

		/* Strip tags for title and name to remove HTML (important for text inputs). */
		$instance['title'] = strip_tags( $new_instance['title'] );

		return $instance;
	}
	
/**
 * Displays the widget settings controls on the widget panel.
 * Make use of the get_field_id() and get_field_name() function
 * when creating your form elements. This handles the confusing stuff.
*/
function form($instance) {
	$defaults = array( 'title' => __('Baby\'s Age', 'bb_baby_age_widget'));
	$instance = wp_parse_args( (array) $instance, $defaults ); ?>
	<!-- Widget Title: Text Input -->
	<p>
		<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e('Title:', 'bb_baby_age_widget'); ?></label><br>
		<input type="text" class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php echo $instance['title']; ?>">
	</p>
	<?php
	}
} // END BB_Baby_Age