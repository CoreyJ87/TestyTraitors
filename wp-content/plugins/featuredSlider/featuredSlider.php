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


add_filter('plugin_action_links_' . plugin_basename(__FILE__), 'synfeat_action_links');


function synfeat_action_links($links)
{
    $links[] = '<a href="' . get_admin_url(null, 'options-general.php?page=featured-settings') . '">Settings</a>';
    return $links;
}


function init_featured_admin_option_page()
{
    // Check that the user is allowed to update options
    if (!current_user_can('manage_options')) {
        wp_die('You do not have sufficient permissions to access this page.');
    }
    if ($_POST['element-max-id'] == "" && get_option('max_id') == "")
        $max_id = 1;
    else if ($_POST['element-max-id'] != "")
        $max_id = $_POST['element-max-id'];
    else
        $max_id = get_option('max_id');

    echo "post:" . $_POST['element-max-id'] . "get option:" . get_option('max_id');

    if (isset($_POST["values_changed"]) && $_POST["values_changed"] == 'Y') {
        $front_page_elements = array();


        echo '<script>console.log(' . json_encode($_POST) . ')</script>';


        for ($i = 1; $i <= $max_id; $i++) {
            $field_name = "synfeat_user_" . $i;
            $field_name2 = "synfeat_vidID_" . $i;

            if (isset($_POST[$field_name])) {
                $front_page_elements[$i][0] = esc_attr($_POST[$field_name]);
            }
            if (isset($_POST[$field_name2])) {
                $front_page_elements[$i][1] = esc_attr($_POST[$field_name2]);
            }
        }
        update_option("max_id", $max_id);
        update_option("synfeat_featured", $front_page_elements);
    }
    $options = get_option('synfeat_featured');
    var_dump($max_id);
    var_dump($options);
    ?>
    <div style="width: 80%; padding: 10px; margin: 10px;">
        <h1>Featured Slider-Admin Settings</h1>
        <!-- Start Options Form -->
        <form action="" method="post" id="pwa-settings-form-admin">

            <div id="pwa-tab-menu"><a id="pwa-general" class="pwa-tab-links active">General</a></div>

            <div class="pwa-setting">
                <!-- General Setting -->
                <div class="first pwa-tab" id="div-pwa-general">
                    <h2>General Settings</h2>
                    <?php
                    echo "<input type='hidden' name='values_changed' value='Y'><input type='hidden' name='element-max-id' id='element-max-id' value=" . $max_id . ">";
                    for ($x = 1; $x <= $max_id; $x++) {
                        echo "<div class='video_option_container'>";
                        echo sprintf('<p><label>User:</label><input type="text" id="synfeat_user_%s" name="synfeat_user_%s" value="' . esc_attr($options[$x][0]) . '" placeholder="User"></p>
', $x, $x);
                        echo sprintf('<p><label>Video ID:</label><input type="text" id="synfeat_vidID_%s" name="synfeat_vidID_%s" value="' . esc_attr($options[$x][1]) . '" placeholder="Video ID"></p></div>
', $x, $x);
                    }
                    ?>
                    <input type="button" id="add-new-video" value="Add new Video"/>
                </div>
            </div>
            <span
                class="submit-btn"><?php echo get_submit_button('Save Settings', 'button-primary', 'submit', '', ''); ?></span>
            <?php do_settings_sections('synfeat_setting_options');
            settings_fields('synfeat_setting_options'); ?>
        </form>
    </div>
<?php
}

add_action('admin_footer', 'init_synfeat_admin_scripts');
function init_synfeat_admin_scripts()
{
    wp_register_style('synfeat_admin_style', plugins_url('css/pwa-admin-min.css', __FILE__));
    wp_enqueue_style('synfeat_admin_style');
    wp_enqueue_script('mainFeatured', path_join(WP_PLUGIN_URL, basename(dirname(__FILE__)) . '/main.js', array(), '1.0.0', true));
}

?>
