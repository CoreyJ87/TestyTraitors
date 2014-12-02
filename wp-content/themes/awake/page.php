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

            if (get_the_id() == "569") {
                $userdata = get_userdata(get_current_user_id());
                if($userdata->allcaps['level_8']) {
                    $option = get_option('wmanager_data');
                    $limit = get_option('wmanager_limit');
                    var_dump($option);
                    echo sprintf("<script>var php_obj = %s </script>
                                   <meta id='wmanager_limit' value='%s'  />
                                    ",$option,$limit);
                }
               } ?>


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