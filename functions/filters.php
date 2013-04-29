<?
add_filter( 'the_content', 'bb_happenings', 20 );
/**
 * @uses is_single()
 */
function bb_happenings( $content ) {
	if (get_post_type() == 'post') {
		$this_post_time = get_the_time('Y-m-d', get_the_ID());
		$birthdate = date('Y-m-d', strtotime(get_option('bb_birthday')));
		$age = dateDiff($this_post_time, $birthdate);
		$child = 'Liam';
		$newcontent = $content; // starting to build the content variable with whatever content is in the wysiwyg. 
		$newcontent .= '<p class="age">At the time of this writing, '. $child.' was '.$age.' old.</p>';
			if (is_single()) {
				$milestone = get_post_meta(get_the_id(),'milestone',true);
				$firsts = get_post_meta(get_the_id(),'firsts',true);
				$challenge = get_post_meta(get_the_id(),'challenge',true);
				if (!empty($milestone) or !empty($firsts) or !empty($challenge)) : 
					$newcontent .= '
					<div class="happenings">';
				
					if (!empty($milestone)) :
					$newcontent .='
						<div class="milestone metacont">
							<h4>Milestone:</h4> 
							<p>'. $milestone .'</p>
						</div>';
					endif;
					if (!empty($firsts)) :
					$newcontent .='
						<div class="first metacont">
							<h4>First!</h4>
							<p>'. $firsts.'</p>
						</div>';
					endif;
					if (!empty($challenge)) :
					$newcontent .='
						<div class="challenge metacont">
							<h4>Challenges</h4>
							<p>'. $challenge.'</p>
					</div>';
					endif;
					$newcontent .='</div><!--END happenings-->';
				endif;

		    // Returns the content.
		} // end check for single
		return $newcontent;
	} else {
		return $newcontent;
	} // end check for post type
}
?>