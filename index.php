<?php 

/*
Plugin Name: ST Members List 
Plugin URI: http://softtech-it.com 
Author: sujan 
Author URI: http:/mtmsujan.com 
Description: Very Simple Members List PLugin to show to members as a slider.. it's shortocde supported 
Version: 1.0 

*/


// Register Custom Post Type
function members_list_include() {

	$labels = array(
		'name'                  => _x( '', 'Post Type General Name', 'text_domain' ),
		'singular_name'         => _x( 'Members', 'Post Type Singular Name', 'text_domain' ),
		'menu_name'             => __( 'Members', 'text_domain' ),
		'name_admin_bar'        => __( 'Members', 'text_domain' ),
		'archives'              => __( 'Member Archives', 'text_domain' ),
		'parent_item_colon'     => __( 'Parent Member:', 'text_domain' ),
		'all_items'             => __( 'All Members', 'text_domain' ),
		'add_new_item'          => __( 'Add New Member', 'text_domain' ),
		'add_new'               => __( 'Add New Member', 'text_domain' ),
		'new_item'              => __( 'New Member', 'text_domain' ),
		'edit_item'             => __( 'Edit Member', 'text_domain' ),
		'update_item'           => __( 'Update Member', 'text_domain' ),
		'view_item'             => __( 'View Member', 'text_domain' ),
		'search_items'          => __( 'Search Member', 'text_domain' ),
		'not_found'             => __( 'No Members found', 'text_domain' ),
		'not_found_in_trash'    => __( 'No members found in Trash', 'text_domain' ),
		'featured_image'        => __( 'Featured Image', 'text_domain' ),
		'set_featured_image'    => __( 'Set featured image', 'text_domain' ),
		'remove_featured_image' => __( 'Remove featured image', 'text_domain' ),
		'use_featured_image'    => __( 'Use as featured image', 'text_domain' ),
		'insert_into_item'      => __( 'Insert into Member', 'text_domain' ),
		'uploaded_to_this_item' => __( 'Uploaded to this Member', 'text_domain' ),
		'items_list'            => __( 'Member list', 'text_domain' ),
		'items_list_navigation' => __( 'Member list navigation', 'text_domain' ),
		'filter_items_list'     => __( 'Filter Member list', 'text_domain' ),
	);
	$rewrite = array(
		'slug'                  => 'members',
		'with_front'            => true,
		'pages'                 => true,
		'feeds'                 => true,
	);
	$args = array(
		'label'                 => __( 'Members', 'text_domain' ),
		'labels'                => $labels,
		'supports'              => array( 'title', 'editor', 'thumbnail', 'revisions', ),
		'hierarchical'          => false,
		'public'                => true,
		'show_ui'               => true,
		'show_in_menu'          => true,
		'menu_position'         => 55,
		'menu_icon' 			=> 'dashicons-edit',
		'show_in_admin_bar'     => true,
		'show_in_nav_menus'     => true,
		'can_export'            => true,
		'has_archive'           => true,		
		'exclude_from_search'   => true,
		'publicly_queryable'    => true,
		'rewrite'               => $rewrite,
		'capability_type'       => 'post',
	);
	register_post_type( 'members_list', $args );


}
add_action( 'init', 'members_list_include', 0 );



add_shortcode('members', 'members_show_korabo');

function members_show_korabo($attr, $content){
	ob_start(); 

	$members_attr = shortcode_atts(array(
		'count' => 6
	), $attr);

	extract($members_attr);


?>

	<div class="members-slider"> 
		<?php 

		$members = new WP_Query(array(
			'post_type' => 'members_list',
			'posts_per_page' => $count
		));

		while($members->have_posts()) : $members->the_post(); ?>
		<div class="single-member">
			<div class="member-image">
				<?php the_post_thumbnail(); ?>
			</div>
			<div class="member-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></div>
			<div class="member-description"><?php echo get_post_meta(get_the_id(), 'short-description', true); ?></div>
			<div class="member-social-profiles">
				<ul>
					<li><a href="<?php echo get_post_meta(get_the_id(), 'facebook', true); ?>"><i class="fa fa-facebook"></i></a></li>
					<li><a href="<?php echo get_post_meta(get_the_id(), 'twitter', true); ?>"><i class="fa fa-twitter"></i></a></li>
				</ul>
			</div>
		</div>

		<?php endwhile; wp_reset_postdata(); ?>


	</div>

	<?php return ob_get_clean();
}



add_action('wp_enqueue_scripts', 'members_external_scripts');

function members_external_scripts(){

	wp_enqueue_style('carousel', plugins_url('css/owl.carousel.css', __FILE__));
	wp_enqueue_style('theme', plugins_url('css/owl.theme.css', __FILE__));
	wp_enqueue_style('transitions', plugins_url('css/owl.transitions.css', __FILE__));
	wp_enqueue_style('font-awesome', plugins_url('css/font-awesome.min.css', __FILE__));
	wp_enqueue_style('sliderstyle', plugins_url('style.css', __FILE__));

	wp_enqueue_script('carousel', plugins_url('css/owl.carousel.min.js', __FILE__), array('jquery'));
	wp_enqueue_script('custom', plugins_url('css/custom.js', __FILE__), array('carousel'));



}



add_filter('single_template', 'members_single_post');

function members_single_post($single){

	global $post;

	if($post->post_type == 'members_list'){
		$single = dirname(__FILE__).'/single-member.php';
	}


	return $single;

}


register_activation_hook(__FILE__, 'permalink_update_hobe');

function permalink_update_hobe(){
	flush_rewrite_rules();
}




require_once(dirname(__FILE__).'/metabox/init.php');
require_once(dirname(__FILE__).'/metabox/custom.php');





