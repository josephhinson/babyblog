<?
// [firsts]
function bb_firsts_display($atts) {
		extract(shortcode_atts(array(
			"number" => '-1'
        ), $atts));
		$return = '';
		$firsts = get_posts('numberposts='.$number.'&meta_key=firsts&post_type=post&post_status=publish');
		if ($firsts) {
			$return .= '<ul class="firsts-list">';
			foreach ($firsts as $first) {
				$return .= '<li class="first-link">'.get_the_time( 'l, F jS, Y', $first->ID).' - <a href="'.get_permalink($first->ID).'">'.$first->post_title.'</a><br>
				'. get_post_meta($first->ID, 'firsts', true).'
				</li>';
			}
			$return .='</ul>';
		} // end check for firsts
		return $return;
}
add_shortcode("firsts", "bb_firsts_display");
// end shortcode
?>