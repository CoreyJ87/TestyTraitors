<?php
/**
 * Page Template
 *
 * @package Mysitemyway
 * @subpackage Template
 */
global $mysite;
get_header(); ?>

<?php if (isset($mysite->is_blog)) : ?>

    <?php get_template_part('loop', 'index'); ?>

<?php else : ?>

    <?php if (have_posts()) while (have_posts()) : the_post(); ?>

        <div id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

            <?php mysite_before_entry(); ?>

            <?php

            if (get_the_id() == "285") {
                $option = get_option('synfeat_featured');
                var_dump($option);
                ?>

                <script type="text/javascript" src="../js/jssor.js"></script>
                <script type="text/javascript" src="../js/jssor.slider.js"></script>
                <!-- use jssor.slider.player.ytiframe.min.js for release -->
                <script type="text/javascript" src="../js/jssor.player.ytiframe.js"></script>
                <script type="text/javascript" src="../js/slider_custom.js"></script>
                <div id="main_slider_container">
                    <div id="slider1_container">
                        <div u="slides" id="slides_container">
                            <?php
                            foreach ($option as $single => $value) {
                                echo sprintf('<div>
                        <div u="player" style="width: 480px; height: 300px;" class="single_player">
                            <iframe pHandler="ytiframe" pHideControls="0" width="480" height="300" style="z-index: 0;"
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
                             style="position: absolute; width: 200px; height: 200px; left:480px; top:7px;">
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
            <?php } ?>


            <div class="entry">
                <?php the_content(); ?>

                <div class="clearboth"></div>

                <?php wp_link_pages(array('before' => '<div class="page_link">' . __('Pages:', MYSITE_TEXTDOMAIN), 'after' => '</div>')); ?>
                <?php edit_post_link(__('Edit', MYSITE_TEXTDOMAIN), '<div class="edit_link">', '</div>'); ?>

            </div>
            <!-- .entry -->

            <?php mysite_after_entry(); ?>

        </div><!-- #post-## -->

        <?php if (!mysite_get_setting('disable_page_comments')) comments_template('', true); ?>

    <?php endwhile; ?>

<?php endif; ?>

<?php mysite_after_page_content(); ?>

    <div class="clearboth"></div>
    </div><!-- #main_inner -->
    </div><!-- #main -->

<?php get_footer(); ?>