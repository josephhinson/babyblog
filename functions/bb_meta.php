<?php
/* Define the custom box */

// WP 3.0+
add_action('add_meta_boxes', 'bb_meta_box');

// backwards compatible
add_action('admin_init', 'bb_meta_box', 1);

/* Do something with the data entered */
add_action('save_post', 'bb_save_postdata');

/* Adds a box to the main column on the Post and Page edit screens */
function bb_meta_box() {
    add_meta_box( 'bb_sectionid', __( 'Significant Happenings', 'bb_textdomain' ), 'bb_inner_custom_box','post', 'normal');
}

/* Prints the box content */
function bb_inner_custom_box() {

  // Use nonce for verification
  wp_nonce_field( plugin_basename(__FILE__), 'bb_noncename' );

	global $post;
  $milestone = get_post_meta($post->ID,'milestone',true);
  $firsts = get_post_meta($post->ID,'firsts',true);
  $challenge = get_post_meta($post->ID,'challenge',true);

  // The actual fields for data entry ?>
  <style type="text/css" media="screen">
    #poststuff .happenings h2 {
      margin-bottom:0px;
    }
  </style>
<table class="happenings" border="0" cellspacing="5" cellpadding="5" width="100%">
	<tr>
	<td><h2>Firsts:</h2>
		<?php
		 wp_editor( $content = $firsts, $editor_id = 'firsts', $settings = array(
			'textarea_name' => 'firsts',
			'textarea_rows' => '2',
      'media_buttons' => false
		)); ?>
  </td>
	</tr>
    <tr>
  <td><h2>Milestone:</h2>
    <?php
     wp_editor( $content = $milestone, $editor_id = 'milestone', $settings = array(
      'textarea_name' => 'milestone',
      'textarea_rows' => '2',
      'media_buttons' => false      
    )); ?>
  </td>
  </tr>
    <tr>
  <td><h2>Challenges:</h2>
    <?php
     wp_editor( $content = $challenge, $editor_id = 'challenge', $settings = array(
      'textarea_name' => 'challenge',
      'textarea_rows' => '2',
      'media_buttons' => false      
    )); ?>
  </td>
  </tr>
</table>
  
	
<?php
}

/* When the post is saved, saves our custom data */
function bb_save_postdata( $post_id ) {

  // verify this came from the our screen and with proper authorization,
  // because save_post can be triggered at other times

  if ( !wp_verify_nonce( $_POST['bb_noncename'], plugin_basename(__FILE__) ) )
      return $post_id;
  // verify if this is an auto save routine. 
  // If it is our form has not been submitted, so we dont want to do anything
  if ( defined('DOING_AUTOSAVE') && DOING_AUTOSAVE ) 
      return $post_id;

  
  // Check permissions
  if ( 'post' == $_POST['post_type'] ) 
  {
    if ( !current_user_can( 'edit_page', $post_id ) )
        return $post_id;
  }
  else
  {
    if ( !current_user_can( 'edit_post', $post_id ) )
        return $post_id;
  }

  // OK, we're authenticated: we need to find and save the data

  	$firsts = $_POST['firsts'];
    $milestone  = $_POST['milestone'];
    $challenge = $_POST['challenge']; 

  // update the data
		update_post_meta($post_id, 'firsts', $firsts);
    update_post_meta($post_id, 'milestone', $milestone);
    update_post_meta($post_id, 'challenge', $challenge);
}
?>