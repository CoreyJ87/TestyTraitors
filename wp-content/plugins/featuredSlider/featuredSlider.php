<?php
/**
 * Plugin Name: SyN Featured Slider
 * Plugin URI:
 * Description: Changes the slider on the home page
 * Author: SyNiK4L
 * Author URI:
 * Version: 1.0
 */


add_action('admin_menu', 'init_synfeat_admin_menu');
function init_synfeat_admin_menu()
{
    add_options_page('Featured Slider', 'Featured videos of the week', 'manage_options', 'featured-settings', 'init_featured_admin_option_page');
}
add_action('admin_init', 'init_synfeat_options_fields');
add_filter('plugin_action_links_' . plugin_basename(__FILE__), 'synfeat_action_links');
function synfeat_action_links($links)
{
    $links[] = '<a href="' . get_admin_url(null, 'options-general.php?page=featured-settings') . '">Settings</a>';
    return $links;
}





function init_synfeat_options_fields()
{
    register_setting('synfeat_setting_options', 'synfeat_active');
    register_setting('synfeat_setting_options', 'synfeat_user_1');
    register_setting('synfeat_setting_options', 'synfeat_vidID_1');
    register_setting('synfeat_setting_options', 'featured_slider_elements');
}
# Options form HTML
function init_featured_admin_option_page()
{

    // Check that the user is allowed to update options
    if (!current_user_can('manage_options')) {
        wp_die('You do not have sufficient permissions to access this page.');
    }

    if (isset($_GET["settings-updated"]) && $_GET['settings-updated'] == true) {
        $front_page_elements = array();
        if(!isset($_POST['element-max-id']))
            $max_id = 1;
        else
            $max_id = esc_attr($_POST["element-max-id"]);
        var_dump($_POST);
        for ($i = 1; $i <= $max_id; $i ++) {
            $field_name = "synfeat_user_" . $i;
            $field_name2 = "synfeat_vidID_" . $i;

            if (isset($_POST[$field_name])) {
                echo $_POST[$field_name];
                $front_page_elements[] = esc_attr($_POST[$field_name]);
            }
            if (isset($_POST[$field_name])) {
                $front_page_elements[] = esc_attr($_POST[$field_name2]);
            }
        }

        update_option("featured_slider_elements", $front_page_elements);
    }
    ?>
    <div style="width: 80%; padding: 10px; margin: 10px;">
        <h1>Featured Slider-Admin Settings</h1>
        <!-- Start Options Form -->
        <form action="options.php" method="post" id="pwa-settings-form-admin">

            <div id="pwa-tab-menu"><a id="pwa-general" class="pwa-tab-links active">General</a></div>

            <div class="pwa-setting">
                <!-- General Setting -->
                <div class="first pwa-tab" id="div-pwa-general">
                    <h2>General Settings</h2>
                    <?php
                    if (isset($_GET['element-max-id'])) {
                        echo "<input type='hidden' id='element-max-id' value=".$_GET['element-max-id'].">";
                        for ($x = 0; $x < $_GET['element-max-id'];)
                            echo "<div class='video_option_container'>";
                            echo sprintf('<p><label>User:</label><input type="text" id="synfeat_user_%s" name="synfeat_user_%s" value="' . esc_attr(get_option('synfeat_user_%s')) . '" placeholder="User"></p>
', $x, $x, $x);
                            echo sprintf('<p><label>Video ID:</label><input type="text" id="synfeat_vidID_%s" name="synfeat_vidID_%s" value="' . esc_attr(get_option('synfeat_vidID_%s')) . '" placeholder="Video ID"></p></div>
', $x, $x, $x);
                    } else {
                        $x = 1;
                        echo "<input type='hidden' id='element-max-id' value='1'><div class='video_option_container'>";
                        echo sprintf('<p><label>User:</label><input type="text" id="synfeat_user_%s" name="synfeat_user_%s" value="' . esc_attr(get_option('synfeat_user_%s')) . '" placeholder="User"></p>
', $x, $x, $x);
                        echo sprintf('<p><label>Video ID:</label><input type="text" id="synfeat_vidID_%s" name="synfeat_vidID_%s" value="' . esc_attr(get_option('synfeat_vidID_%s')) . '" placeholder="Video ID"></p></div>
', $x, $x, $x);
                        var_dump(get_option('featured_slider_elements'));
                    }
                    ?>
                    <input type="button" id="add-new-video" value="Add new Video" />
                </div>
            </div>
            <span class="submit-btn"><?php echo get_submit_button('Save Settings', 'button-primary', 'submit', '', ''); ?></span>

            <?php settings_fields('synfeat_setting_options'); ?>

        </form>

        <!-- End Options Form -->
    </div>

<?php
}

/** add js into admin footer */
add_action('admin_footer', 'init_synfeat_admin_scripts');
function init_synfeat_admin_scripts()
{
    wp_register_style('synfeat_admin_style', plugins_url('css/pwa-admin-min.css', __FILE__));
    wp_enqueue_style('synfeat_admin_style');
    wp_enqueue_script('mainFeatured', path_join(WP_PLUGIN_URL, basename(dirname(__FILE__)) . '/main.js', array(), '1.0.0', true));
}


/** register_install_hook */
if (function_exists('register_install_hook')) {
    register_uninstall_hook(__FILE__, 'init_install_synfeat_plugins');
}
//flush the rewrite
function init_install_synfeat_plugins()
{
    flush_rewrite_rules();
}

/** register_uninstall_hook */
/** Delete exits options during disable the plugins */
if (function_exists('register_uninstall_hook')) {
    register_uninstall_hook(__FILE__, 'init_uninstall_synfeat_plugins');
}

//Delete all options after uninstall the plugin
function init_uninstall_synfeat_plugins()
{
    delete_option('synfeat_active');
    delete_option('synfeat_user_1');
    delete_option('synfeat_vidID_1');
}

//require dirname(__FILE__) . '/pwa-class.php';

?>
