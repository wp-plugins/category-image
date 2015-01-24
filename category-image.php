<?php
/*
Plugin Name: Category Image
Plugin URI: http://pankajanupam.in/wordpress-plugin/category-image
Description: The Category Image Plugin allow you to add image with category.
Author: PANKAJ ANUPAM
Version: 1.5
Author URI: http://pankajanupam.in/
*/
?>
<?php
global $texonomy_slug;
$texonomy_slug='category'; // texonomy slug

add_action($texonomy_slug.'_add_form_fields','categoryimage');
function categoryimage($taxonomy){ ?>
    <div class="form-field">
	<label for="tag-image">Image</label>
	<input type="text" name="tag-image" id="tag-image" value="" />	
</div>

<?php script_css(); }


add_action($texonomy_slug.'_edit_form_fields','categoryimageedit');
function categoryimageedit($taxonomy){ ?>
<tr class="form-field">
	<th scope="row" valign="top"><label for="tag-image">Image</label></th>
	<td><input type="text" name="tag-image" id="tag-image" value="<?php echo get_option('_category_image'.$taxonomy->term_id); ?>" /><br /></td>
</tr>              
<?php script_css(); }

function script_css(){ ?>
                
<script type="text/javascript" src="<?php echo plugins_url(); ?>/category-image/thickbox.js"></script>
<link rel='stylesheet' id='thickbox-css'  href='<?php echo includes_url(); ?>js/thickbox/thickbox.css' type='text/css' media='all' />
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
<?php }
//edit_$taxonomy
add_action('edit_term','categoryimagesave');
add_action('create_term','categoryimagesave');
function categoryimagesave($term_id){
    if(isset($_POST['tag-image'])){
        if(isset($_POST['tag-image']))
            update_option('_category_image'.$term_id,$_POST['tag-image'] );
    }
}


function print_image_function(){
    $texonomy_slug='category';
    $_terms = wp_get_post_terms(get_the_ID(),$texonomy_slug); 
    $_termsidlist=array();  
    $result = '';
    foreach($_terms as $val){    
        $result .= '<div style="float:left; margin-right:2px;"><a href="'.get_term_link($val).'"><img height="22px" title="'.$val->name.'" alt="'.$val->name.'" src="'.get_option('_category_image'.$val->term_id).'" /></a></div>';    
    }
    return $result;
}

add_shortcode('print-image','print_image_function');

?>