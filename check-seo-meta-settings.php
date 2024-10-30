<?php
require_once('check-seo-meta-details.php');

settings_fields( 'csmd_meta_settings_group' ); 
?>
<table class="wp-list-table widefat fixed bookmarks">
    <thead>
        <tr>
            <th><strong>Settings</strong></th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td>
		
		        <strong>Home Page Meta</strong>
		        <form method="post">
                    <input placeholder="Home Page Title" type="text" id="hometitle" name="hometitle" style="width: 50%" value="<?php echo get_post_meta(get_option('page_on_front'), 'csmd_page_title', true); ?>" />
				    <div class="t-length"></div>
            
                    <input placeholder="Home Meta Description" type="text" id="homemetadescription" name="homemetadescription" style="width: 50%" value="<?php echo get_post_meta(get_option('page_on_front'), 'csmd_meta_desc', true); ?>" />
				    <div class="des-length"></div>
           
                    <input placeholder="Home Meta Keywords" type="text" id="homemetakeywords" name="homemetakeywords" style="width: 50%" value="<?php echo get_post_meta(get_option('page_on_front'), 'csmd_meta_key', true); ?>" />
   
                    <p class="submit">
                    <input type="submit" name="submit_settings" class="button-primary" value="<?php _e('Save Changes') ?>" />
                    </p>
                </form>            
            </td>
        </tr>
    </tbody>
</table>
<?php

if(isset($_POST['submit_settings'])) {
		
	    $pageID = get_option('page_on_front');
	
		    global $post;
			
			$home = sanitize_meta('home_title', isset($_POST['hometitle']) ? $_POST['hometitle'] : '', '');
			$home_desc = sanitize_meta('home_desc', isset($_POST['homemetadescription']) ? $_POST['homemetadescription'] : '', '');
			$home_key = sanitize_meta('home_key', isset($_POST['homemetakeywords']) ? $_POST['homemetakeywords'] : '', '');
			
			update_post_meta(get_option('page_on_front'), 'csmd_page_title', $home);
			update_post_meta(get_option('page_on_front'), 'csmd_meta_desc', $home_desc);
			update_post_meta(get_option('page_on_front'), 'csmd_meta_key', $home_key);
		
}