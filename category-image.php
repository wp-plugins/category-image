<?php
/*
Plugin Name: Category Image
Plugin URI: http://pankajanupam.in/wordpress-plugin/category-image
Description: The Category Image Plugin allow you to add image with category.
Author: PANKAJ ANUPAM
Version: 1.0
Author URI: http://pankajanupam.in/
*/

$texonomy_slug='category'; // texonomy slug

add_action($texonomy_slug.'_add_form_fields','categoryimage');
function categoryimage($taxonomy){ ?>
    <div class="form-field">
	<label for="tag-image">Image</label>
	<input type="text" name="tag-image" id="tag-image" value="" />	
</div>
<?php require_script(); }


add_action($texonomy_slug.'_edit_form_fields','categoryimageedit');
function categoryimageedit($taxonomy){ ?>
<tr class="form-field">
			<th scope="row" valign="top"><label for="tag-image">Image</label></th>
			<td><input type="text" name="tag-image" id="tag-image" value="<?php echo get_option('category_image'.$tag->ID); ?>" /><br /></td>
		</tr>
<?php  require_script(); }

//edit_$taxonomy
add_action('edit_term','categoryimagesave');
add_action('create_term','categoryimagesave');
function categoryimagesave($term_id){
    if(isset($_POST['tag-image'])){
        if(isset($_POST['tag-image']))
            update_option('category_image'.$term_id,$_POST['tag-image'] );
    }
}

function require_script(){ ?>
<script type="text/javascript" src="<?php echo plugin_url(); ?>/category-image/thickbox.js"></script>
<link rel='stylesheet' id='thickbox-css'  href='<?php echo includes_url(); ?>/wp-includes/js/thickbox/thickbox.css' type='text/css' media='all' />

<script type="text/javascript">  
    
    jQuery(document).ready(function() {
	var fileInput = ''; 
	jQuery('#tag-image').live('click',
	function() {
		fileInput = jQuery('#tag-image');
		tb_show('', 'media-upload.php?type=image&amp;TB_iframe=true');
		return false;
	}); 
        window.original_send_to_editor = window.send_to_editor;
	window.send_to_editor = function(html) {
		if (fileInput) {
			fileurl = jQuery('img', html).attr('src');
			if (!fileurl) {
				fileurl = jQuery(html).attr('src');
			}
			jQuery(fileInput).val(fileurl);

			tb_remove();
		} else {
			window.original_send_to_editor(html);
		}
	};
    });
   
</script>
<?php } ?>