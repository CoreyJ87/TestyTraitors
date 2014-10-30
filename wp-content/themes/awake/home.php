<?php
/**
 * Home Template
 *
 * @package Mysitemyway
 * @subpackage Template
 */

get_header(); 

$post_obj = $wp_query->get_queried_object();
$sliderData = array(
    'query'=>'Clash of Clans',
    'limit'=>'8',
    'order'=>'date',
    'type'=>'video'
);
//$response = youTubeCall($attrs,0);
?>
<h1 style="text-align:center;">News and Information</h1>
<br><br>
<?php if ( ( mysite_get_setting( 'frontpage_blog' ) ) || ( !empty( $post_obj->ID ) && get_option('page_for_posts') == $post_obj->ID ) ) : ?>
	<?php get_template_part( 'loop', 'index' ); ?>
	
<?php endif; ?>

<?php mysite_after_page_content(); ?>

		<div class="clearboth"></div>
	</div><!-- #main_inner -->
</div><!-- #main -->

<?php get_footer(); ?>