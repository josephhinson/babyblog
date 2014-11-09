<?php
// [firsts]
function bb_firsts_display($atts) {
		extract(shortcode_atts(array(
			"number" => "-1"
        ), $atts));
		$return = '';
		$args = array(
			'posts_per_page' => '-1',
		   'post_type' => 'post',
		   'meta_key' => 'firsts',
		   'orderby' => 'date',
		   'order' => 'DESC'
	   );
		$firsts = get_posts($args);
		if ($firsts) {
			$return .= '<ul class="firsts-list">';
			foreach ($firsts as $first) {
				if (get_post_meta($first->ID, 'firsts', true)) {				
					$return .= '<li class="first-link">'.get_the_time( 'l, F jS, Y', $first->ID).' - <a href="'.get_permalink($first->ID).'">'.$first->post_title.'</a><br>
					'. get_post_meta($first->ID, 'firsts', true).'
					</li>';
				}
			}
			$return .='</ul>';
		} // end check for firsts
		return $return;
}
function bb_shortcode_init() {
add_shortcode("firsts", "bb_firsts_display");	
}
// end shortcode

add_action('init', 'bb_shortcode_init');

?>