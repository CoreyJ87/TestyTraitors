<?php
/**
Plugin Name: SyN Featured Slider
Plugin URI: 
Description: Changes the slider on the home page
Author: SyNiK4L
Author URI: 
Version: 1.0
*/
add_action('admin_menu','init_synfeat_admin_menu');

function init_synfeat_admin_menu(){
	add_options_page('Featured Slider','Featured videos of the week','manage_options','featured-settings','init_featured_admin_option_page');
}

/** Define Action to register "Protect WP-Admin" Options */
add_action('admin_init','init_synfeat_options_fields');
/** Register "Protect WP-Admin" options */
function init_synfeat_options_fields(){
	register_setting('synfeat_setting_options','synfeat_active');
	register_setting('synfeat_setting_options','synfeat_user');
	register_setting('synfeat_setting_options','synfeat_videoid');
} 


/** Add settings link to plugin list page in admin */
add_filter( 'plugin_action_links_' . plugin_basename(__FILE__), 'synfeat_action_links' );
function synfeat_action_links( $links ) {
   $links[] = '<a href="'. get_admin_url(null, 'options-general.php?page=featured-settings') .'">Settings</a>';
   return $links;
}

/** Options Form HTML for "Protect WP-Admin" plugin */
function init_featured_admin_option_page(){ ?>
	<div style="width: 80%; padding: 10px; margin: 10px;"> 
	<h1>Featured Slider-Admin Settings</h1>
  <!-- Start Options Form -->
	<form action="options.php" method="post" id="pwa-settings-form-admin">
		
	<div id="pwa-tab-menu"><a id="pwa-general" class="pwa-tab-links active" >General</a> </div>

	<div class="pwa-setting">
	<!-- General Setting -->	
	<div class="first pwa-tab" id="div-pwa-general">
	<h2>General Settings</h2>
	<p><label>Enable:</label><input type="checkbox" id="synfeat_active" name="synfeat_active" value='1' <?php if(get_option('synfeat_active')!=''){ echo ' checked="checked"'; }?>/></p>
	<p><label>User:</label><input type="text" id="synfeat_user" name="synfeat_user" value="<?php echo esc_attr(get_option('synfeat_user')); ?>"  placeholder="wp-admin"></p>
	<p><label>Video ID:</label><input type="text" id="synfeat_videoid" name="synfeat_videoid" value="<?php echo esc_attr(get_option('synfeat_videoid')); ?>"  placeholder="wp-admin"></p>
	
	</div>

	</div>
	<span class="submit-btn"><?php echo get_submit_button('Save Settings','button-primary','submit','','');?></span>
		
    <?php settings_fields('synfeat_setting_options'); ?>
	
	</form>

<!-- End Options Form -->
	</div>

<?php
}

/** add js into admin footer */
add_action('admin_footer','init_synfeat_admin_scripts');
function init_synfeat_admin_scripts()
{
wp_register_style( 'synfeat_admin_style', plugins_url( 'css/pwa-admin-min.css',__FILE__ ) );
wp_enqueue_style( 'synfeat_admin_style' );

echo $script='<script type="text/javascript">
	/* Protect WP-Admin js for admin */
	jQuery(document).ready(function(){
		jQuery(".pwa-tab").hide();
		jQuery("#div-pwa-general").show();
	    jQuery(".pwa-tab-links").click(function(){
		var divid=jQuery(this).attr("id");
		jQuery(".pwa-tab-links").removeClass("active");
		jQuery(".pwa-tab").hide();
		jQuery("#"+divid).addClass("active");
		jQuery("#div-"+divid).fadeIn();
		})
		})
	</script>';

	}


/** register_install_hook */
if( function_exists('register_install_hook') ){
register_uninstall_hook(__FILE__,'init_install_synfeat_plugins');
}
//flush the rewrite
function init_install_synfeat_plugins(){
	  flush_rewrite_rules();
} 
/** register_uninstall_hook */
/** Delete exits options during disable the plugins */
if( function_exists('register_uninstall_hook') ){
   register_uninstall_hook(__FILE__,'init_uninstall_synfeat_plugins');
}

//Delete all options after uninstall the plugin
function init_uninstall_synfeat_plugins(){
	delete_option('synfeat_active');
	delete_option('synfeat_user');
	delete_option('synfeat_videoid');
}
require dirname(__FILE__).'/pwa-class.php';

?>
