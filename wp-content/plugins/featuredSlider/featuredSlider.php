<?php/** * Plugin Name: SyN Featured Slider * Plugin URI: * Description: Changes the slider on the home page * Author: SyNiK4L * Author URI: * Version: 1.0 */function init_admin_page(){    $form_path = path_join(WP_PLUGIN_URL, basename(dirname(__FILE__)) . "/featuredFunctions.php");    $options = get_option('synfeat_featured');    if (!get_option('max_id'))        $max_id = 1;    else        $max_id = get_option('max_id');    ?>    <div style="width: 95%; padding: 10px; margin: 10px;">        <h1>Homepage Featured Slider Settings</h1>        <div>Below you can enter the clan members name, youtube video id, and description.<br>            Sort order is exactly as you see it here. All items are sortable. #1 here is number one in the slider, and            on down.<br>            Also will update this to pull the image from here instead of the beginning of the video.            Although it can be set on the youtube side by setting the preview image to a different image than the            default        </div>        <h2>Current Featured Videos:</h2>        <form action="<?= $form_path ?>" method="post" id="pwa-settings-form-admin">            <input type='hidden' name='values_changed' value='Y'>            <input type='hidden' name='element-max-id' id='element-max-id' value='<?= $max_id ?>'>            <div id="form_input_fields">                <?php                $video_count = 1;                for ($x = 1; $x <= $max_id; $x++) {                    echo sprintf('<div class="video_option_container" id="container_%s">                    Video #: <span class="video_number">%s</span> |                    <label>User:</label><input type="text" id="synfeat_user_%s" name="synfeat_user_%s" value="' . esc_attr($options[$x][0]) . '" placeholder="User">                    <label>Video ID:</label><input type="text" id="synfeat_vidID_%s" name="synfeat_vidID_%s" value="' . esc_attr($options[$x][1]) . '" placeholder="Video ID">                    <label>Description:</label><input style="width:350px;" type="text" id="synfeat_desc_%s" name="synfeat_desc_%s" value="' . esc_attr($options[$x][2]) . '" placeholder="Description">                    <a class="button button-primary remove_button" id="remove_button_%s">Remove</a></div>', $x, $video_count, $x, $x, $x, $x, $x, $x, $x);                    $video_count++;                }                ?>            </div>            <br><br><input class="button button-primary" type="button" id="add-new-video" value="Add new Video"/>            <span                class="submit-btn">                <?php echo get_submit_button('Save Settings', 'button-primary', 'submit', '', ''); ?></span><br><br>            <a class="button button-primary" href="themes.php?page=featured-settings" type="button" id="cancel_changes">Cancel                Changes</a>            <?php do_settings_sections('synfeat_setting_options');            settings_fields('synfeat_setting_options'); ?>        </form>        <div id="success_tooltip" style="display:none;">Saved!</div>    </div><?php}//Enqueue Scripts and Stylesfunction init_synfeat_admin_scripts($hook){    if('appearance_page_featured-settings' != $hook)        return;    wp_enqueue_style("admin_style", path_join(WP_PLUGIN_URL, basename(dirname(__FILE__)) . '/css/featuredSliderAdmin.css'));    wp_enqueue_style('jquery-ui-css', path_join(WP_PLUGIN_URL, basename(dirname(__FILE__)) . '/css/jquery-ui.min.css'));    wp_enqueue_script('jQuery', path_join(WP_PLUGIN_URL, basename(dirname(__FILE__)) . '/scripts/jquery-2.1.1.min.js'), array(), '1.0.0', true);    wp_enqueue_script('jQueryUI', path_join(WP_PLUGIN_URL, basename(dirname(__FILE__)) . '/scripts//jquery-ui.min.js'), array(), '1.0.0', true);    wp_enqueue_script('mainFeatured', path_join(WP_PLUGIN_URL, basename(dirname(__FILE__)) . '/scripts/main.js'), array(), '1.1.0', true);    wp_enqueue_script('jqueryForm', path_join(WP_PLUGIN_URL, basename(dirname(__FILE__)) . '/scripts/jquery.form.min.js'), array(), '1.0.0', true);}//Add page to admin cp menufunction init_synfeat_admin_menu(){    add_theme_page('Featured Slider', 'Homepage Video Slider', 'edit_theme_options', 'featured-settings', 'init_admin_page');}//Create admin panel linkfunction action_link($link){    $link[] = '<a href="' . get_admin_url(null, 'themes.php?page=featured-settings') . '">Settings</a>';    return $link;}//Initalize Everythingadd_action('admin_menu', 'init_synfeat_admin_menu');add_action('admin_enqueue_scripts', 'init_synfeat_admin_scripts');add_filter('plugin_action_links_' . plugin_basename(__FILE__), 'action_link');?>