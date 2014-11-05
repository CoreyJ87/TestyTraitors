<?php
/**
 * Created by PhpStorm.
 * User: Corey
 * Date: 11/4/2014
 * Time: 6:12 PM
 */


function randomBanner()
{
    $num = rand(1, 4);
    echo sprintf("<style> body>.multibg>.multibg {
background-image:url('/wp-content/themes/awake/images/Banner%s.png') !important;
} </style>", $num);
}


function createSlider()
{
    ?>
    <div id="main_slider_container">
        <div id="slider1_container">
            <div id="loading"><img src="/dev/img/ajax-loader.gif"></div>
            <div u="slides" id="slides_container">
                <?php
                $option = get_option('synfeat_featured');
                foreach ($option as $single => $value) {
                    echo sprintf('<div>
                        <div u="player" style="width: 640px; height: 360px;" class="single_player">
                            <iframe pHandler="ytiframe" pHideControls="0" width="640" height="360" style="z-index: 0;"
                                    url="http://www.youtube.com/embed/%s?enablejsapi=1&version=3&playerapiid=ytplayer&fs=1&wmode=transparent"
                                    frameborder="0" scrolling="no"></iframe>
                        </div>
                        <div u="thumb">
                            <img class="i" src="//i.ytimg.com/vi/%s/mqdefault.jpg" class="user_content preview_image">"/>
                            <div class="t">%s</div>
                            <div class="c">%s</div>
                        </div>
                    </div>
                ', $value[1], $value[1], $value[0], $value[2]);
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
<?php
}
