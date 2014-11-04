<?php
/**
 * Header Template
 *
 * @package Mysitemyway
 * @subpackage Template
 */
?><!DOCTYPE html>
<!--[if lt IE 7]>
<html class="ie ie6 lte9 lte8 lte7" <?php language_attributes(); ?>> <![endif]-->
<!--[if IE 7]>
<html class="ie ie7 lte9 lte8 lte7" <?php language_attributes(); ?>> <![endif]-->
<!--[if IE 8]>
<html class="ie ie8 lte9 lte8" <?php language_attributes(); ?>> <![endif]-->
<!--[if IE 9]>
<html class="ie ie9 lte9" <?php language_attributes(); ?>> <![endif]-->
<!--[if gt IE 9]>
<html> <![endif]-->
<!--[if !IE]><!-->
<html <?php language_attributes(); ?>> <!--<![endif]-->
<head>
    <meta charset="<?php bloginfo('charset'); ?>"/>
    <title><?php mysite_document_title(); ?></title>
    <link rel="profile" href="http://gmpg.org/xfn/11"/>
    <link rel="pingback" href="<?php bloginfo('pingback_url'); ?>"/>
    <?php mysite_head(); ?>
    <?php wp_head(); ?>
   <!-- <script src="/wp-content/themes/awake/lib/scripts/jquery-2.1.1.min.js"></script>-->
    <script src="/wp-content/themes/awake/lib/scripts/jquery-ui.min.js"></script>
    <link rel="stylesheet" href="/wp-content/themes/awake/lib/scripts/jquery-ui.min.css">
    <script type="text/javascript" src="../js/jssor.js"></script>
    <script type="text/javascript" src="../js/jssor.slider.js"></script>
    <!-- use jssor.slider.player.ytiframe.min.js for release -->
    <script type="text/javascript" src="../js/jssor.player.ytiframe.js"></script>
    <script type="text/javascript" src="/dev/js/slider_custom.js"></script>
</head>

<body class="<?php mysite_body_class(); ?>">
<?php
$num = rand(1, 4);
echo sprintf("<style> body>.multibg>.multibg {
background-image:url('/wp-content/themes/awake/images/Banner%s.png') !important;
} </style>", $num);
?>
<div class="multibg">
    <div class="multibg"></div>
</div>
<div id="body_inner">

    <?php mysite_before_header();

    ?>
    <div id="header">
        <div id="header_inner">

            <?php mysite_header();

            ?></div>
        <!-- #header_inner -->
    </div>
    <!-- #header -->

    <?php mysite_after_header();

    ?>
    <div id="content">
        <div id="content_inner">

            <?php  if(is_front_page()){?>
            <div id="main_slider_container">
                <div id="slider1_container">
                    <div u="slides" id="slides_container">
                        <?php
                        $option = get_option('synfeat_featured');
                        foreach ($option as $single => $value) {
                            echo sprintf('<div>
                        <div u="player" style="width: 640px; height: 360px;" class="single_player">
                            <iframe pHandler="ytiframe" pHideControls="0" width="640" height="360" style="z-index: 0;"
                                    url="http://www.youtube.com/embed/%s?enablejsapi=1&version=3&playerapiid=ytplayer&fs=1&wmode=transparent"
                                    frameborder="0" scrolling="no"></iframe>
                           <div u="close" class="closeButton" style="position: absolute; top: 0px; right: 1px;width: 30px; height: 30px; background-color: #000; cursor: pointer; display: none; z-index: 2;">
                            </div>
                        </div>
                        <div u="thumb">
                            <img class="i" src="//i.ytimg.com/vi/%s/mqdefault.jpg" class="user_content preview_image">"/>
                            <div class="t">%s</div>
                            <div class="c">The desciption</div>
                        </div>
                    </div>
                ', $value[1], $value[1], $value[0]);
                        }
                        ?>
                    </div>


                    <div u="thumbnavigator" class="jssort11"
                         style="position: absolute;width: 200px;height: 200px;left: 640px;top: 80px;">
                        <!-- Thumbnail Item Skin Begin -->
                        <div u="slides" style="cursor: pointer;">
                            <div u="prototype" class="p"
                                 style="position: absolute; width: 200px; height: 69px; top: 0; left: 0;">
                                <thumbnailtemplate
                                    style=" width: 100%; height: 100%; border: none;position:absolute; top: 0; left: 0;"></thumbnailtemplate>
                            </div>
                        </div>
                    </div>


                </div>
            </div>

            <?php  } mysite_before_main();

            ?>
            <div id="main">
                <div id="main_inner">
<?php mysite_before_page_content(); ?>