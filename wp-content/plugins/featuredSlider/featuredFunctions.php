<?php
/**
 * Created by PhpStorm.
 * User: cjones
 * Date: 11/6/2014
 * Time: 11:05 AM
 * TODO: Sanitize all post parameters
 */
require_once('/home/ttraiters/public_html/wp-blog-header.php');

//Check to see if they can edit theme options
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
    $sliderFrames = array();

    for ($i = 1; $i <= $max_id; $i++) {
        $field_name = "synfeat_user_" . $i;
        $field_name2 = "synfeat_vidID_" . $i;
        $field_name3 = "synfeat_desc_" . $i;

        if (isset($_POST[$field_name])) {
            $sliderFrames[$i][0] = esc_attr($_POST[$field_name]);
        }
        if (isset($_POST[$field_name2])) {
            $sliderFrames[$i][1] = esc_attr($_POST[$field_name2]);
        }
        if (isset($_POST[$field_name3])) {
            $sliderFrames[$i][2] = esc_attr($_POST[$field_name3]);
        }
    }
    update_option("max_id", $max_id);
    update_option("synfeat_featured", $sliderFrames);
}
//header('Location: /dev/wp-admin/themes.php?page=featured-settings');