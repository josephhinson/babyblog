<?php
// This code removes "Protected and Private" from titles for prettier viewing when logged in as an admin.
function the_title_trim($title)
{
  $pattern[0] = '/Protected: /';
  $pattern[1] = '/Private: /';
  $replacement[0] = ''; // Enter some text to put in place of Protected:
  $replacement[1] = ''; // Enter some text to put in place of Private:

  return preg_replace($pattern, $replacement, $title);
}
add_filter('the_title', 'the_title_trim');

// [showthumbs]
function showthumbs_func($atts, $content = null) { ?>
		<style type="text/css" media="screen">
			ul.photo-thumbs {
				margin: 0;
				padding: 0;
			}
			li.thumb {
				list-style: none;
				margin: 0;
				padding: 0;
				float: left;
				line-height: 0;
				margin-right: 10px;
				margin-bottom: 10px;
			}
			li.thumb.clr {
				clear: both;
				float: none;
				margin: 0;
			}
		</style>
		<?php
        extract(shortcode_atts(array(
                "showthumbs" => ''
        ), $atts));
        global $post;
        $pics = get_children( 'numberposts=-1&post_type=attachment&post_mime_type=image&post_parent='.$post->ID );
        $return='<ul class="photo-thumbs">';
        foreach($pics as $pic) :
		$image = wp_get_attachment_image_src($pic->ID, 'large'); 
             $return.='<li class="thumb"><a class="colorbox" title="' . $pic->post_title .'" rel="slideshow" href="'. $image[0].'">'.wp_get_attachment_image($pic->ID, array(75,75)).'</a></li>';
        endforeach;
        $return.='<li class="thumb clr"></li></ul>';
        return $return;
}
add_shortcode("showthumbs", "showthumbs_func");


// Shortcode to show all pictures attached to the post, used by calling the shortcode below
// [showpics order="ASC/DESC" orderby="menu_order / modified"]
// if any contentt is given to the title that is different than the original filename, that text will be used as a caption,
// if a description is given, that text will be used as a caption.
function showpics_func($atts, $content = null) { ?>
		<?php
        extract(shortcode_atts(array(
                "showpics" => '',
				"order" => 'ASC',
				"orderby" => 'menu_order'
        ), $atts));
        global $post;
        $lrgpics = get_children('numberposts=-1&order='.$order.'&orderby='.$orderby.'&post_type=attachment&post_mime_type=image&post_parent='.$post->ID);
		$return='';
        foreach($lrgpics as $lrgpic) :
			if (strtoupper($lrgpic->post_name) != strtoupper($lrgpic->post_title)) { // If the picture hasn't been given a new name, it won't show up.
			$image = wp_get_attachment_image_src($lrgpic->ID, 'full'); 
			$lrgimage = wp_get_attachment_image_src($lrgpic->ID, 'large');
			$imgwidth = $lrgimage[1] + 10;
			$theimage = wp_get_attachment_image($lrgpic->ID, 'large');
	             $return.='<div style="width:'.$imgwidth.'px;" id="attachment_'.$lrgpic->ID.'" class="wp-caption alignnone"><a href="'. $image[0].'">'.$theimage.'</a>';
				if($lrgpic->post_content) {
					$return.='<p class="wp-caption-text"><small>'.$lrgpic->post_content.'</small></p></div>';
				} else {
					$return.='<p class="wp-caption-text">'.$lrgpic->post_title.'</p></div>';
				}
			// if title has been given, show title, if description has been given, show description
			// if no title has been given, just show the image
        	} else { 
			$image = wp_get_attachment_image_src($lrgpic->ID, 'full'); 
			$theimage = wp_get_attachment_image($lrgpic->ID, 'large');
	             $return.='<p class="imgcontainer"><a href="'. $image[0].'">'.$theimage.'</a></p>';
			} // end check to see if title has been given
		endforeach;
        return $return;
}
add_shortcode("showpics", "showpics_func");

// Relative Time Feature:

// Set timezone
date_default_timezone_set("UTC");

// Time format is UNIX timestamp or
// PHP strtotime compatible strings
function dateDiff($time1, $time2, $precision = 3) {
  // If not numeric then convert texts to unix timestamps
  if (!is_int($time1)) {
    $time1 = strtotime($time1);
  }
  if (!is_int($time2)) {
    $time2 = strtotime($time2);
  }

  // If time1 is bigger than time2
  // Then swap time1 and time2
  if ($time1 > $time2) {
    $ttime = $time1;
    $time1 = $time2;
    $time2 = $ttime;
  }

  // Set up intervals and diffs arrays
  $intervals = array('year','month','day','hour','minute','second');
  $diffs = array();

  // Loop thru all intervals
  foreach ($intervals as $interval) {
    // Set default diff to 0
    $diffs[$interval] = 0;
    // Create temp time from time1 and interval
    $ttime = strtotime("+1 " . $interval, $time1);
    // Loop until temp time is smaller than time2
    while ($time2 >= $ttime) {
	$time1 = $ttime;
	$diffs[$interval]++;
	// Create new temp time from time1 and interval
	$ttime = strtotime("+1 " . $interval, $time1);
    }
  }

  $count = 0;
  $times = array();
  // Loop thru all diffs
  foreach ($diffs as $interval => $value) {
    // Break if we have needed precission
    if ($count >= $precision) {
	break;
    }
    // Add value and interval 
    // if value is bigger than 0
    if ($value > 0) {
	// Add s if value is not 1
	if ($value != 1) {
	  $interval .= "s";
	}
	// Add value and interval to times array
	$times[] = $value . " " . $interval;
	$count++;
    }
  }

  // Return string with times
  return implode(", ", $times);
}

// displays all milestones
function get_meta_posts($metakey, $num) { ?>
	<ul>
		<?php 
		$key = array(
			'meta_key' => $metakey,
			'posts_per_page' => $num,
		); 
		$theposts = get_posts($key);
		foreach ($theposts as $thepost) {
			$metacontent = get_post_meta($thepost->ID, $metakey, true);?>
			<?php if (!empty($metacontent)) : ?>
				<li><a href="<?php echo get_permalink($thepost->ID); ?>" title="Link to <?php echo get_the_title($thepost->ID); ?>"><?php echo get_the_time('F j, Y'); ?></a> <br/>
					<?php echo $metacontent; ?>
				</li>
			<?php endif;
		} ?>
		</ul>
		<span class="seeall"><a href="<?php bloginfo('url'); ?>/<?php echo $metakey; ?>">See All <?php echo ucfirst($metakey); ?></a></span>
	<?php
}