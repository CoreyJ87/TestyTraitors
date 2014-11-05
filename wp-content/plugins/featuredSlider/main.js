/**
 * Created by cjones on 10/30/2014.
 */
jQuery(document).ready(function () {
    jQuery("#add-new-video").click(function () {
        var count = eval(jQuery("#element-max-id").attr('value'));
        var newVal = count + 1;
        jQuery('#div-pwa-general').append(
            "<div class='video_option_container' id='container_"+newVal+"'>" +
            "<p>Video #: <span class='video_number'>"+newVal+"</span> | <label>User:</label><input type='text' id='synfeat_user_" + newVal + "' name='synfeat_user_" + newVal + "' value='' placeholder='User'>" +
            "<label>Video ID:</label><input type='text' id='synfeat_vidID_" + newVal + "' name='synfeat_vidID_" + newVal + "' value='' placeholder='Video ID'>" +
            "<label>Description:</label><input style='width:350px;' type='text' id='synfeat_desc_" + newVal + "' name='synfeat_desc_" + newVal + "' value='' placeholder='Description'>" +
            "<a class='button button-primary remove_button' id='remove_button_" + newVal + "'>Remove</a></p>"
        );
        jQuery('#element-max-id').attr('value', newVal);

    });

    jQuery('.remove_button').live('click',function () {
        var count = eval(jQuery("#element-max-id").attr('value'));
        var newVal = count - 1;
        jQuery('#element-max-id').attr('value',newVal);
        jQuery(this).parents('.video_option_container').remove();
        fixNumbers();
    });
});


function fixNumbers(){
    var count=1;
    jQuery('#form_input_fields').children('div').each(function(){
        jQuery(this).children('p').children('span').text(count);
        jQuery(this).attr('id','container_'+count);
        jQuery(this).children('input[placeholder="User"]').attr('id','synfeat_user_'+count)
            .attr('name','synfeat_user_'+count);
        jQuery(this).children('input[placeholder="Video ID"]').attr('id','synfeat_vidID_'+count)
            .attr('name','synfeat_vidID_'+count);
        jQuery(this).children('input[placeholder="Description"]').attr('id','synfeat_desc_'+count)
            .attr('name','synfeat_desc_'+count);

        jQuery(this).children('a').attr('id','remove_button_'+count);
        count++;
    });
}