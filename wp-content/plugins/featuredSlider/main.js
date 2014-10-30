/**
 * Created by cjones on 10/30/2014.
 */
jQuery(document).ready(function () {
    jQuery("#add-new-video").click(function () {
        var count = eval(jQuery("#element-max-id").attr('value'));
        var newVal = count+1;
        jQuery('#div-pwa-general').append(
            "<div class='video_option_container'>" +
            "<p><label>User:</label><input type='text' id='synfeat_user_"+newVal+"' name='synfeat_user_"+newVal+"' value='' placeholder='User'></p>" +
            "<p><label>Video ID:</label><input type='text' id='synfeat_vidID_"+newVal+"' name='synfeat_vidID_"+newVal+"' value='' placeholder='Video ID'></p>"
        );
        jQuery('#element-max-id').attr('value',newVal);
    });
})