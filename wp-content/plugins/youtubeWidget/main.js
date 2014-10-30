/**
 * Created by cjones on 10/22/2014.
 */
var processing;
jQuery(document).ready(function () {


    jQuery('#sort_order').selectmenu({
        width: 150,
        change: function (event, data) {
            var newURL = modifyQueryParam('order', '', location.href);
            newURL = modifyQueryParam('order', data.item.value, newURL);
            location.href = newURL;
        }
    });
    jQuery('#video_type').selectmenu({
        width: 150,
        change: function (event, data) {
            var newURL = modifyQueryParam('type', '', location.href);
            newURL = modifyQueryParam('type', data.item.value, newURL);
            location.href = newURL;
        }
    });
    jQuery('#search_type').selectmenu({
        width: 250,
        change: function (event, data) {
            var newURL = modifyQueryParam('pageKey', '', location.href)
            newURL = modifyQueryParam('query', '', newURL);
            newURL = modifyQueryParam('query', data.item.label, newURL);
            location.href = newURL;
        }
    });
    jQuery('#result_limit').selectmenu({
        width: 100,
        change: function (event, data) {
            var newURL = modifyQueryParam('limit', '', location.href);
            newURL = modifyQueryParam('limit', data.item.value, newURL);
            location.href = newURL;
        }
    });
    jQuery('#th_level').selectmenu({
        width: 150,
        change: function (event, data) {
            if (data.item.value != "NotSelected") {
                var newURL = modifyQueryParam('townhall', '', location.href);
                newURL = modifyQueryParam('townhall', data.item.value, newURL);
                location.href = newURL;
            }
            else {
                location.href = modifyQueryParam('townhall', '', location.href);
            }
        }
    });

    var QP = queryParameters();
    if (QP.order != undefined)
        jQuery('#sort_order').val(QP.order).selectmenu('refresh');
    if (QP.type != undefined)
        jQuery('#video_type').val(QP.type).selectmenu('refresh');
    if (QP.query != undefined)
        jQuery('#search_type').val(decodeURIComponent(QP.query)).selectmenu('refresh');
    if (QP.limit != undefined)
        jQuery('#result_limit').val(QP.limit).selectmenu('refresh');
    else
        jQuery('#result_limit').val(20).selectmenu('refresh');
    if (QP.townhall != undefined)
        jQuery('#th_level').val(QP.townhall).selectmenu('refresh');


    jQuery('.sort_direction')
        .button()
        .click(function (event) {
            event.preventDefault();
            var QP = queryParameters();
            var button = jQuery(this).attr('id');

            if (QP.sort == undefined && button == "asc")
                location.href = modifyQueryParam('sort', 'asc', location.href);

            else if (QP.sort == "asc" && button == "desc")
                location.href = modifyQueryParam('sort', '', location.href);
        });

    jQuery('.page_control')
        .button()
        .click(function (event) {
            event.preventDefault();
            var button = jQuery(this).attr('id');
            if (button == "next_page" || button == "next_page_bottom") {
                var id = jQuery('#next_page_id').attr('the_id');
                newURL = modifyQueryParam('pageKey', '', location.href);
                location.href = modifyQueryParam('pageKey', id, newURL);
            }
            else {
                var id = jQuery('#prev_page_id').attr('the_id');
                newURL = modifyQueryParam('pageKey', '', location.href);
                location.href = modifyQueryParam('pageKey', id, newURL);
            }
        });


    if (jQuery('#next_page_id').attr('the_id') == "")
        jQuery('.next-page').button('option', "disabled", true);
    else
        jQuery('.next-page').button('option', "disabled", false);

    if (jQuery('#prev_page_id').attr('the_id') == "")
        jQuery('.prev-page').button('option', "disabled", true);
    else
        jQuery('.prev-page').button('option', "disabled", false);

    if (QP.sort == "asc") {
        jQuery("#asc").button("option", "disabled", true);
        jQuery('#desc').button("option", "disabled", false);
    }
    else {
        jQuery("#asc").button("option", "disabled", false);
        jQuery('#desc').button("option", "disabled", true);
    }

    jQuery('.single_video').click(function (event) {
        if (!jQuery(this).hasClass('channel') && event.target.text != 'Open video in new window') {
            jQuery("#player_container").html('<iframe type="text/html" frameborder="0" allowfullscreen src="http://youtube.com/embed/' +
            jQuery(this).attr("id") + '"></iframe>');
            jQuery("#player_container").attr('title', jQuery(this).attr('channel'));
            jQuery('#player_container').dialog({
                height: "460",
                width: "720",
                modal: true,
                close: function () {
                    jQuery('#player_container').dialog("destroy");
                }
            });
            jQuery('.ui-widget-overlay').bind('click', function () {
                jQuery(this).siblings('.ui-dialog').find('.ui-dialog-content').dialog('close');
            });
        }
    });

    /* jQuery(document).scroll(function(e){
     if (processing)
     return false;
     if (jQuery(window).scrollTop() >= (jQuery(document).height() - jQuery(window).height())*0.7){
     processing = true;
     //response = search()
     }
     });*/

});

function queryParameters() {
    var result = {};
    var params = window.location.search.split(/\?|\&/);
    params.forEach(function (it) {
        if (it) {
            var param = it.split("=");
            result[param[0]] = param[1];
        }
    });
    return result;
}

function modifyQueryParam(key, value, sourceURL) {
    var rtn = sourceURL.split("?")[0],
        param,
        params_arr = [],
        queryString = (sourceURL.indexOf("?") !== -1) ? sourceURL.split("?")[1] : "";
    if (key != '' && value != '') {
        params_arr = queryString.split("&");
        params_arr.push(key + '=' + value);
    }
    else if (key != '' && value == '') {
        params_arr = queryString.split("&");
        for (var i = params_arr.length - 1; i >= 0; i -= 1) {
            param = params_arr[i].split("=")[0];
            if (param === key) {
                params_arr.splice(i, 1);
            }
        }
    }
    else {
        return sourceURL;
    }
    rtn = rtn + "?" + params_arr.join("&");
    return rtn;
}
