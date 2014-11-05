<?php
/**
 * Plugin Name: SyN Featured Slider
 * Plugin URI:
 * Description: Changes the slider on the home page
 * Author: SyNiK4L
 * Author URI:
 * Version: 1.0
 */

function init_featured_admin_option_page()
{
    if (!current_user_can('edit_theme_options')) {
        wp_die('You do not have sufficient permissions to access this page.');
    }
    if ($_POST['element-max-id'] == "" && get_option('max_id') == "")
        $max_id = 1;
    else if ($_POST['element-max-id'] != "")
        $max_id = $_POST['element-max-id'];
    else
        $max_id = get_option('max_id');

    if (isset($_POST["values_changed"]) && $_POST["values_changed"] == 'Y') {
        $front_page_elements = array();

        for ($i = 1; $i <= $max_id; $i++) {
            $field_name = "synfeat_user_" . $i;
            $field_name2 = "synfeat_vidID_" . $i;
            $field_name3 = "synfeat_desc_" . $i;

            if (isset($_POST[$field_name])) {
                $front_page_elements[$i][0] = esc_attr($_POST[$field_name]);
            }
            if (isset($_POST[$field_name2])) {
                $front_page_elements[$i][1] = esc_attr($_POST[$field_name2]);
            }
            if (isset($_POST[$field_name3])) {
                $front_page_elements[$i][2] = esc_attr($_POST[$field_name3]);
            }
        }
        update_option("max_id", $max_id);
        update_option("synfeat_featured", $front_page_elements);
    }
    $options = get_option('synfeat_featured');
    ?>
    <div style="width: 95%; padding: 10px; margin: 10px;">
        <h1>Homepage Featured Slider Settings</h1>

        <div>Below you can enter the clan members name, youtube video id, and description.<br>
            Sort order is exactly as you see it here. All items are sortable. #1 here is number one in the slider, and on down.<br>
            Also will update this to pull the image from here instead of the beginning of the video.
            Although it can be set on the youtube side by setting the preview image to a different image than the
            default
        </div>
        <h2>Current Featured Videos:</h2>

        <form action="" method="post" id="pwa-settings-form-admin">
            <input type='hidden' name='values_changed' value='Y'>
            <input type='hidden' name='element-max-id' id='element-max-id' value='<?= $max_id ?>'>

            <div id="form_input_fields">
                <?php
                $video_count=1;
                for ($x = 1; $x <= $max_id; $x++) {
                    echo sprintf('<div class="video_option_container" id="container_%s">
                    Video #: <span class="video_number">%s</span> |
                    <label>User:</label><input type="text" id="synfeat_user_%s" name="synfeat_user_%s" value="' . esc_attr($options[$x][0]) . '" placeholder="User">
                    <label>Video ID:</label><input type="text" id="synfeat_vidID_%s" name="synfeat_vidID_%s" value="' . esc_attr($options[$x][1]) . '" placeholder="Video ID">
                    <label>Description:</label><input style="width:350px;" type="text" id="synfeat_desc_%s" name="synfeat_desc_%s" value="' . esc_attr($options[$x][2]) . '" placeholder="Description">
                    <a class="button button-primary remove_button" id="remove_button_' . $x . '">Remove</a></div>
', $x,$video_count, $x, $x, $x, $x, $x, $x);
                    $video_count++;
                }
                ?>
            </div>
            <br><br><input class="button button-primary" type="button" id="add-new-video" value="Add new Video"/>
            <span class="submit-btn"><?php echo get_submit_button('Save Settings', 'button-primary', 'submit', '', ''); ?></span><br><br>
            <a class="button button-primary" href="themes.php?page=featured-settings" type="button" id="cancel_changes">Cancel Changes</a>
            <?php do_settings_sections('synfeat_setting_options');
            settings_fields('synfeat_setting_options'); ?>
        </form>
    </div>
<?php
}
add_action('admin_menu', 'init_synfeat_admin_menu');
add_action('admin_footer', 'init_synfeat_admin_scripts');
add_filter('plugin_action_links_' . plugin_basename(__FILE__), 'synfeat_action_links');
function init_synfeat_admin_scripts()
{
    wp_register_style('synfeat_admin_style', plugins_url('featuredSliderAdmin.css', __FILE__));
    wp_enqueue_style('synfeat_admin_style');

    wp_register_style('jquery-ui-css', plugins_url('jquery-ui.min.css', __FILE__));
    wp_enqueue_style('jquery-ui-css');

    wp_enqueue_script('mainFeatured', path_join(WP_PLUGIN_URL, basename(dirname(__FILE__)) . '/main.js'), array(), '1.0.0', true);
    wp_enqueue_script('jQueryUI', path_join(WP_PLUGIN_URL, basename(dirname(__FILE__)) . '/jquery-ui.min.js'), array(), '1.0.0', true);
}
function init_synfeat_admin_menu()
{
    add_theme_page('Featured Slider', 'Homepage Video Slider', 'edit_theme_options', 'featured-settings', 'init_featured_admin_option_page');
}
function synfeat_action_links($links)
{
    $links[] = '<a href="' . get_admin_url(null, 'themes.php?page=featured-settings') . '">Settings</a>';
    return $links;
}

?>
