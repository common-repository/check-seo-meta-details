<?php
/*
Plugin Name: Check SEO Meta Details
Description: The best solution to your page/post/product meta data and allows you to change settings.
Version: 1.0
Author: Check SEO
Author URI: http://www.checkseo.in/
License: GPL2
*/

remove_action( 'wp_head', '_wp_render_title_tag', 1 );

add_action('admin_enqueue_scripts', 'csmd_script');
function csmd_script($hook) {
    
    wp_enqueue_script('check_seo_script', plugin_dir_url(__FILE__) . '/js/checkseo.js');
}

//Check SEO Settings - Menu
add_action('admin_menu', 'csmd_create_menu');
function csmd_create_menu() {
	$page = add_menu_page( 'Check SEO', 'Check SEO', 'manage_options', 'csmd_meta_settings', 'csmd_meta_settings', '');
	add_action('admin_init', 'csmd_settings_group');
	
}

function csmd_settings_group() {
	register_setting('csmd_meta_settings_group', 'meta_show_label');
} 

function csmd_meta_settings() {	
	global $optionValues;
	$meta_show_label 						= $optionValues['meta_show_label'];
	include('check-seo-meta-settings.php');	
}

                                 
if (!class_exists("checkseo_meta_details")) {
	
	class checkseo_meta_details{
	
		function __construct() {
            add_action("save_post", array(&$this, 'csmd_save_meta_details'));
    		add_action("wp_head", array(&$this, 'csmd_meta_form_display'),0);
    		add_action('admin_init', array(&$this, 'csmd_meta_settings'));
    		add_action('add_meta_boxes', array(&$this, 'add_csmd_meta_fields'));
        
		}

		function csmd_save_meta_details($post_id = null) {
            global $post;
			
			$wptitle = sanitize_meta('meta_title', isset($_POST['metatitle']) ? $_POST['metatitle'] : '', 'post');
            $wpDesc = sanitize_meta('meta_desc', isset($_POST['wpmetadescription']) ? $_POST['wpmetadescription'] : '', 'post');
            $wpmKey = sanitize_meta('meta_keyword', isset($_POST['wpmetakeywords']) ? $_POST['wpmetakeywords'] : '', 'post');
            $wpogtitle = sanitize_meta('og_title', isset($_POST['ogtitle']) ? $_POST['ogtitle'] : $post->post_title, 'post');

			$wpogdesc = sanitize_meta('og_desc', isset($_POST['ogdescription']) ? $_POST['ogdescription'] : $_POST['wpmetadescription'], 'post');

			$wpogimg = sanitize_meta('og_img', isset($_POST['ogimg']) ? $_POST['ogimg'] : '', 'post');

			$wptdesc = sanitize_meta('twitter_desc', isset($_POST['twitterdescription']) ? $_POST['twitterdescription'] : $_POST['wpmetadescription'], 'post');

			$wpturl = sanitize_meta('twitter_url', isset($_POST['twitterurl']) ? $_POST['twitterurl'] : '', 'post');

			$wptimg = sanitize_meta('twitter_img', isset($_POST['twitterimg']) ? $_POST['twitterimg'] : '', 'post');

			$wpfbdesc = sanitize_meta('fb_desc', isset($_POST['fbdescription']) ? $_POST['fbdescription'] : $_POST['wpmetadescription'], 'post');

			$wpfburl = sanitize_meta('fb_url', isset($_POST['fburl']) ? $_POST['fburl'] : '', 'post');

			$wpfbimg = sanitize_meta('fb_img', isset($_POST['fbimg']) ? $_POST['fbimg'] : '', 'post');

			update_post_meta($post_id, 'csmd_page_title', $wptitle);
			update_post_meta($post_id, 'csmd_meta_desc', $wpDesc);
			update_post_meta($post_id, 'csmd_meta_key', $wpmKey);
			update_post_meta($post_id, 'csmd_og_title', $wpogtitle);
			update_post_meta($post_id, 'csmd_og_desc', $wpogdesc);
			update_post_meta($post_id, 'csmd_og_img', $wpogimg);
			update_post_meta($post_id, 'csmd_twitter_desc', $wptdesc);
			update_post_meta($post_id, 'csmd_twitter_url', $wpturl);
			update_post_meta($post_id, 'csmd_twitter_img', $wptimg);
			update_post_meta($post_id, 'csmd_fb_desc', $wpfbdesc);
			update_post_meta($post_id, 'csmd_fb_url', $wpfburl);
			update_post_meta($post_id, 'csmd_fb_img', $wpfbimg);
		}

		function csmd_meta_form_display(){
			global $post;
				if(is_page() || is_home() || is_single()){
					
				    $isImplemeted = true;
					
				    if(is_home()) { 
						$default = get_bloginfo(); 
						$postId = get_option('page_on_front');
					} 
					else { 
						$default = $post->post_title .' - '. get_bloginfo();
						$postId = $post->ID;
					}
						
					$meta_title = (get_post_meta($postId, 'csmd_page_title', true) != '') ? get_post_meta($postId, 'csmd_page_title', true) : $default;
						
					$meta_description = (get_post_meta($postId, 'csmd_meta_desc', true) != '') ? get_post_meta($postId, 'csmd_meta_desc', true) : $default;						
						
					$meta_keywords = (get_post_meta($postId, 'csmd_meta_key', true) != '') ? get_post_meta($postId, 'csmd_meta_key', true) : $default;
					
				//Open graph	
					$og_title = (get_post_meta($postId, 'csmd_og_title', true) != '') ? get_post_meta($postId, 'csmd_og_title', true) : get_post_meta($postId, 'csmd_page_title', true);
					
					$og_desc = (get_post_meta($postId, 'csmd_og_desc', true) != '') ? get_post_meta($postId, 'csmd_og_desc', true) : get_post_meta($postId, 'csmd_meta_desc', true);
					
					$og_img = (get_post_meta($postId, 'csmd_og_img', true) != '') ? get_post_meta($postId, 'csmd_og_img', true) : get_option('page_meta_keywords');
					
				//twitter
					$twitter_desc = (get_post_meta($postId, 'csmd_twitter_desc', true) != '') ? get_post_meta($postId, 'csmd_twitter_desc', true) : get_post_meta($postId, 'csmd_meta_desc', true);
					
				    $twitter_url = (get_post_meta($postId, 'csmd_twitter_url', true) != '') ? get_post_meta($postId, 'csmd_twitter_url', true) : get_option('page_meta_keywords');
					
					$twitter_img = (get_post_meta($postId, 'csmd_twitter_img', true) != '') ? get_post_meta($postId, 'csmd_twitter_img', true) : get_option('page_meta_keywords');
					
				//Facebook
				
					$fb_desc = (get_post_meta($postId, 'csmd_fb_desc', true) != '') ? get_post_meta($postId, 'csmd_fb_desc', true) : get_post_meta($postId, 'csmd_meta_desc', true);
					
					$fb_url = (get_post_meta($postId, 'csmd_fb_url', true) != '') ? get_post_meta($postId, 'csmd_fb_url', true) : get_option('page_meta_keywords');
					
					$fb_img = (get_post_meta($postId, 'csmd_fb_img', true) != '') ? get_post_meta($postId, 'csmd_fb_img', true) : get_option('page_meta_keywords');
												
					$meta_og_type = $post->post_type;
					$meta_og_url = get_permalink();
										
								
				    $attachments = get_posts( array(
                        'post_type' => 'attachment',
                        'posts_per_page' => -1,
                        'post_parent' => $postId,             
                    ) );

                    if ( $attachments ) {
						
                        foreach ( $attachments as $attachment ) {
							
                            $thumbimg = wp_get_attachment_link( $attachment->ID, 'thumbnail-size', true );
                            $img =  $attachment->guid;
                        }

                    }

	            }

				if($isImplemeted){
					
					echo '<title>' . esc_attr($this->returnFormat($meta_title)) . '</title>'. "\n";
					echo '<meta name="description" content="'. esc_attr($this->returnFormat($meta_description)) .'" />' . "\n";
					echo '<meta name="keywords" id="mkeyword" content="'. esc_attr($this->returnFormat($meta_keywords)) .'" />' . "\n";
					echo '<meta name="robots" content="index, follow"/>' . "\n";
					echo '<meta name="viewport"  content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no" />' . "\n"; 
                    echo '<meta http-equiv="X-UA-Compatible" content="IE=edge">' . "\n";
				//open graph	
					echo '<meta property="og:title" content="'. esc_attr($this->returnFormat($og_title)) .'"/>' . "\n";
                    echo '<meta property="og:type" content="'. esc_attr($this->returnFormat($meta_og_type)) .'"/>' . "\n";
					echo '<meta property="og:description" content="'. esc_attr($this->returnFormat($og_desc)) .'" />' . "\n";  
                    echo '<meta property="og:url" content="'. esc_attr($this->returnFormat($meta_og_url)) .'"/>' . "\n";
                    echo '<meta property="og:site_name" content="'. get_bloginfo() .'"/>' . "\n";
                    echo '<meta property="og:image" content="'. $img .'"/>' . "\n";
				    echo '<meta property="og:locale" content="en_US" />' . "\n";
				    echo '<meta property="author" content="'. get_bloginfo() .'" />' . "\n";
				//twitter
				    echo '<meta name="twitter:card" content="summary" />' . "\n";
                    echo '<meta property="twitter:description" content="'. esc_attr($this->returnFormat($twitter_desc)) .'" />' . "\n";  
                    echo '<meta property="twitter:url" content="'. esc_attr($this->returnFormat($twitter_url)) .'"/>' . "\n";
                    echo '<meta property="twitter:image" content="'. $twitter_img .'"/>' . "\n";
				//facebook
				        echo '<meta property="fb:description" content="'. esc_attr($this->returnFormat($fb_desc)) .'" />' . "\n";  
                    echo '<meta property="fb:url" content="'. esc_attr($this->returnFormat($fb_url)) .'"/>' . "\n";
                    echo '<meta property="fb:image" content="'. $fb_img .'"/>' . "\n";
				    
				}
				
		}

        function returnFormat($text){
            return htmlentities(stripslashes($text), ENT_COMPAT, "UTF-8");
        }

        function csmd_create_meta_form(){
    		global $post;
    		?>
    		<input type="hidden" id="wpsbmt" name="wpsbmt" value="1" />

            <p>
                <input placeholder="Page Title" type="text" id="metatitle" name="metatitle" style="width: 100%" value="<?php echo get_post_meta($post->ID, 'csmd_page_title', true); ?>" />
				<div class="t-length"></div>
            </p>
            <p>
                <input placeholder="Meta Description" type="text" id="wpmetadescription" name="wpmetadescription" style="width: 100%" value="<?php echo get_post_meta($post->ID, 'csmd_meta_desc', true); ?>" />
				<div class="des-length"></div>
            </p>
            <p>
                <input placeholder="Meta Keywords" type="text" id="wpmetakeywords" name="wpmetakeywords" style="width: 100%" value="<?php echo get_post_meta($post->ID, 'csmd_meta_key', true); ?>" />
            </p>
			
			<h3>Open Graph</h3>
			<p>
                 <input placeholder="Title" type="text" id="ogtitle" name="ogtitle" style="width: 100%" value="<?php echo get_post_meta($post->ID, 'csmd_og_title', true); ?>" />
            </p>

            <p>
                <input placeholder="Description" type="text" id="ogdescription" name="ogdescription" style="width: 100%" value="<?php echo get_post_meta($post->ID, 'csmd_og_desc', true); ?>" />
            </p>
			
			<p>
                <input placeholder="Image" type="text" id="ogimg" name="ogimg" style="width: 100%" value="<?php echo get_post_meta($post->ID, 'csmd_og_img', true); ?>" />
            </p>
			
			<h3>Twitter</h3>
			
            <p>
               <input placeholder="Description" type="text" id="twitterdescription" name="twitterdescription" style="width: 100%" value="<?php echo get_post_meta($post->ID, 'csmd_twitter_desc', true); ?>" />
            </p>
			
			<p>
                <input placeholder="Url" type="text" id="twitterurl" name="twitterurl" style="width: 100%" value="<?php echo get_post_meta($post->ID, 'csmd_twitter_url', true); ?>" />
            </p>

            <p>
                <input placeholder="Image" type="text" id="twitterimg" name="twitterimg" style="width: 100%" value="<?php echo get_post_meta($post->ID, 'csmd_twitter_img', true); ?>" />
            </p>
			
			<h3>Facebook</h3>
			
            <p>
               <input placeholder="Description" type="text" id="fbdescription" name="fbdescription" style="width: 100%" value="<?php echo get_post_meta($post->ID, 'csmd_fb_desc', true); ?>" />
            </p>
			
			<p>
                <input placeholder="Url" type="text" id="fburl" name="fburl" style="width: 100%" value="<?php echo get_post_meta($post->ID, 'csmd_fb_url', true); ?>" />
            </p>

            <p>
                <input placeholder="Image" type="text" id="fbimg" name="fbimg" style="width: 100%" value="<?php echo get_post_meta($post->ID, 'csmd_fb_img', true); ?>" />
            </p>


    		<?php
    	}

		function add_csmd_meta_fields() {
			
			$title = '<a href="http://www.checkseo.in/" title="Check SEO"><h1>Check SEO Meta Details</h1></a>';
			
			add_meta_box( 'CheckSMetaDetails', $title, array(&$this, 'csmd_create_meta_form'), 'page', 'advanced', 'high' );
			add_meta_box( 'CheckSMetaDetails', $title, array(&$this, 'csmd_create_meta_form'), 'post', 'advanced', 'high' );
			add_meta_box( 'CheckSMetaDetails', $title, array(&$this, 'csmd_create_meta_form'), 'product', 'advanced', 'high' );
			
		}

    	
    	function csmd_meta_settings() 	{
			
    		register_setting( 'meta-tag-settings', 'page_meta_keywords' );
    		register_setting( 'meta-tag-settings', 'page_meta_description' );
    		register_setting( 'meta-tag-settings', 'page_og_title' );
    		
    		register_setting( 'meta-tag-settings', 'post_meta_keywords' );
    		register_setting( 'meta-tag-settings', 'post_meta_description' );
    		register_setting( 'meta-tag-settings', 'post_og_title' );

    		register_setting( 'meta-tag-settings', 'use_pages_meta_data' );
    		register_setting( 'meta-tag-settings', 'use_posts_meta_data' );


			if(get_option('meta_description') != ''){
    			update_option('page_meta_description', get_option('meta_description'));
    			update_option('post_meta_description', get_option('meta_description'));
    			update_option('meta_description', '');
    		}
    		if(get_option('meta_keywords') != ''){
    			update_option('page_meta_keywords', get_option('meta_keywords'));
    			update_option('post_meta_keywords', get_option('meta_keywords'));
    			update_option('meta_keywords', '');
    		}
			if(get_option('og_title') != ''){
    			update_option('page_og_title', get_option('og_title'));
    			update_option('post_og_title', get_option('og_title'));
    			update_option('og_title', '');
    		}
    	}

	}

	//initialize the class to a variable
	$wp_meta_var = new checkseo_meta_details();

}
?>