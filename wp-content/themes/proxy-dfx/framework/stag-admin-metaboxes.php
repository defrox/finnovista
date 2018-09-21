<?php
function stag_add_meta_box($meta_box){
  if(!is_array($meta_box)) return false;

  $call_func = create_function('$post, $meta_box', 'stag_create_meta_box($post, $meta_box["args"]);');
  add_meta_box($meta_box['id'], $meta_box['title'], $call_func, $meta_box['page'], $meta_box['context'], $meta_box['priority'], $meta_box);
}


function stag_create_meta_box($post, $meta_box){
  if(!is_array($meta_box)) return false;

  if(isset($meta_box['description']) && $meta_box['description'] != '' ){
    echo '<p>'.$meta_box['description'].'</p>';
  }

  wp_nonce_field(basename(__FILE__), 'stag_meta_box_nonce');
  echo '<table class="stag-metabox-table">';

  foreach($meta_box['fields'] as $field){
    $meta = get_post_meta($post->ID, $field['id'], true);
    echo '<tr>
            <th>
              <label for="'.$field['id'].'"><strong>'.$field['name'].'</strong><span>'.$field['desc'].'</span></label>
            </th>';

    switch($field['type']){
      case 'text':
      echo '<td class="stag-box-'.$field['type'].'"><input type="text" name="stag_meta['.$field['id'].']" id="'.$field['id'].'" value="'.($meta ? $meta : $field['std']).'" size="30" /></td>';
      break;

      case 'textarea':
      echo '<td class="stag-box-'.$field['type'].'"><textarea name="stag_meta['.$field['id'].']" id="'.$field['id'].'"  rows="8" cols="5">'.($meta ? $meta : $field['std']).'</textarea></td>';
      break;

      case 'file':
      echo '<td class="stag-box-'.$field['type'].'">
      <input type="text" name="stag_meta['.$field['id'].']" id="'.$field['id'].'" value="'.($meta ? $meta : $field['std']).'" size="30" class="file" />
      <input data-choose="Choose an imagy" data-update="Save it bro" type="button" class="button" name="'.$field['id'].'_button" id="'.$field['id'].'_button" value="Browse" /></td>';
      break;

      case 'images':
      echo '<td><input type="button" class="button" name="' . $field['id'] . '" id="stag_images_upload" value="' . $field['std'] .'" /></td>';
      break;

      case 'select':
      echo'<td class="stag-box-'.$field['type'].'"><select name="stag_meta['. $field['id'] .']" id="'. $field['id'] .'">';
      foreach( $field['options'] as $option ){
        echo'<option';
        if( $meta ){
          if( $meta == $option ) echo ' selected="selected"';
        } else {
          if( $field['std'] == $option ) echo ' selected="selected"';
        }
        echo'>'. $option .'</option>';
      }
      echo'</select></td>';
      break;

      case 'radio':
      echo '<td class="stag-box-'.$field['type'].'">';
      foreach( $field['options'] as $option ){
        echo '<label class="radio-label"><input type="radio" name="stag_meta['. $field['id'] .']" value="'. $option .'" class="radio"';
        if( $meta ){
          if( $meta == $option ) echo ' checked="yes"';
        } else {
          if( $field['std'] == $option ) echo ' checked="yes"';
        }
        echo ' /> '. $option .'</label> ';
      }
      echo '</td>';
      break;

      case 'color':
      if( array_key_exists('val', $field) ) $val = ' value="' . $field['val'] . '"';
      if( $meta ) $val = ' value="' . $meta . '"';
      echo '<td class="stag-box-'.$field['type'].'">';
        echo '<div class="colorpicker-wrapper">';
        echo '<input type="text" id="'. $field['id'] .'_cp" name="stag_meta[' . $field['id'] .']"' . $val . ' />';
        echo '<div id="' . $field['id'] . '" class="colorpicker"></div>';
        echo '</div>';
        echo '</td>';
      break;

      case 'checkbox':
      echo '<td class="stag-box-'.$field['type'].'">';
      $val = '';
      if( $meta ) {
          if( $meta == 'on' ) $val = ' checked="yes"';
      } else {
          if( $field['std'] == 'on' ) $val = ' checked="yes"';
      }

      echo '<input type="hidden" name="stag_meta['. $field['id'] .']" value="off" />
      <input type="checkbox" id="'. $field['id'] .'" name="stag_meta['. $field['id'] .']" value="on"'. $val .' /> ';
      echo '</td>';
      break;
    }
    echo '</tr>';
  }
  echo '</table>';
}

function stag_save_meta_box($post_id){
  if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE )
    return;

  if(!isset($_POST['stag_meta']) || !isset($_POST['stag_meta_box_nonce']) || !wp_verify_nonce($_POST['stag_meta_box_nonce'], basename(__FILE__)) )
    return;

  if('page' == $_POST['post_type']){
    if(!current_user_can('edit_page', $post_id)) return;
  }else{
    if(!current_user_can('edit_post', $post_id)) return;
  }

  foreach($_POST['stag_meta'] as $key => $val){
    update_post_meta($post_id, $key, stripslashes(htmlspecialchars($val)));
  }
}
add_action('save_post', 'stag_save_meta_box');


function stag_metabox_scripts(){
  wp_register_script('stag-upload', STAG_URL .'/js/upload-button.js', array('jquery'));
  wp_enqueue_script('stag-upload');
}
add_action('admin_enqueue_scripts', 'stag_metabox_scripts');

?>