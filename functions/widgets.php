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
		?>
				<ul>
				<?php query_posts('meta_key=milestone&showposts=3'); ?>
				<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
					<?php 
					$milestone = get_post_meta($post->ID,'milestone',true);
					?>
					<li><a href="<?php the_permalink() ?>" title="Link to <?php the_title(); ?>"><?php the_time('F j, Y'); ?></a> <br/>
					<?php echo $milestone; ?></li>
				<?php endwhile; endif; wp_reset_query(); ?>
				</ul>
				<span class="seeall"><a href="<?php bloginfo('url'); ?>/milestones">See All Milestones</a></span>
		<?
		
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
		?>
				<ul>
					<?php query_posts('meta_key=firsts&showposts=10'); ?>
					<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
						<?php 
						$firsts = get_post_meta($post->ID,'firsts',true);
						?>
						<li><a href="<?php the_permalink() ?>" title="Link to <?php the_title(); ?>"><?php the_time('F j, Y'); ?></a> <br/>
						<?php echo $firsts ?></li>
					<?php endwhile; endif; wp_reset_query(); ?>
				</ul>
				<span class="seeall"><a href="<?php bloginfo('url'); ?>/firsts">See All Firsts</a></span>
<?
		
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
		
		// Settings from the widget
		// @NEEDFIX -- change 'cat=4' to whatever category users select for the photos category - also possibly change thumbnail
		?>
				<?php 
//				$photocat = get_option('bb_photo_category');
				query_posts('cat=4&posts_per_page=3'); ?>
				<?php if (have_posts()) : ?>
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
						<?php while (have_posts()) : the_post(); ?>
						<?php // Begin Photo Thumbnails
							$sb_photos = get_children( 'numberposts=3&post_type=attachment&post_mime_type=image&post_parent='.$post->ID );
							if (!empty($sb_photos)) : ?>

							<?php foreach($sb_photos as $sb_photo) : ?>
							<li>
								<a href="<?php the_permalink() ?>" title="Link to <?php the_title(); ?>"><?php echo wp_get_attachment_image($sb_photo->ID, array(50,50)); ?></a>
							</li>

		 				<?php endforeach; ?>
						<?php endif; // END Photo thumbnails ?>

					<?php endwhile; ?>
						<li style="clear:both;float:none;"></li><!--clearfix li-->
				<?php endif; wp_reset_query();// end loop ?>
				
				<li class="seeall"><a href="<?php bloginfo('url'); ?>/category/photos/">See All Photos</a></li>
				<li style="clear:both;float:none;"></li>
				</ul>
		<?
		
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
?>