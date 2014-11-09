<?php
function bb_content_filter_init() {
	add_filter( 'the_content', 'bb_happenings', 20 );
}

add_action('init', 'bb_content_filter_init');

function bb_happenings( $content ) {
	$newcontent = $content; // starting to build the content variable with whatever content is in the wysiwyg. 
	if (get_post_type() == 'post') {
		$bbsettings = get_option('bb-settings');
		$this_post_time = get_the_time('Y-m-d', get_the_ID());
		$birthdate = date('Y-m-d', strtotime($bbsettings['bb_birthday']));
		$age = dateDiff($this_post_time, $birthdate);
		$child = $bbsettings['bb_name'];
//		echo strtotime($bbsettings['bb_birthday']) . ' - ' . strtotime(get_the_time('Y-m-d'));
		if (strtotime($bbsettings['bb_birthday']) > strtotime(get_the_time('Y-m-d'))) {
			$newcontent .= '<p class="age">This was written '.$age.' before you were born.';
		} else {
			$newcontent .= '<p class="age">At the time of this writing, '. $child.' was '.$age.' old.</p>';			
		}
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