<?php

namespace SourceFramework\PostType;

/**
 * If this file is called directly, abort.
 */
if ( !defined( 'ABSPATH' ) ) {
  die( 'Direct access is forbidden.' );
}

/**
 * Testimonial Post Type
 *
 * @package        PostType
 * @since          1.0.0
 * @author         Javier Prieto <jprieton@gmail.com>
 */
class Testimonial {

  /**
   * Class constructor
   *
   * @since 1.0.0
   */
  public function __construct() {
    add_action( 'init', [ $this, 'post_type' ] );
    add_action( 'init', [ $this, 'category' ] );
    add_action( 'init', [ $this, 'tag' ] );
  }

  /**
   * Register Testimonial Post Type.
   *
   * @since 1.0.0
   */
  public function post_type() {

    $labels  = array(
        'name'                  => __( 'Testimonials', \SourceFramework\TEXTDOMAIN ),
        'singular_name'         => __( 'Testimonial', \SourceFramework\TEXTDOMAIN ),
        'menu_name'             => __( 'Testimonials', \SourceFramework\TEXTDOMAIN ),
        'name_admin_bar'        => __( 'Testimonial', \SourceFramework\TEXTDOMAIN ),
        'archives'              => __( 'Item Archives', \SourceFramework\TEXTDOMAIN ),
        'all_items'             => __( 'All Testimonials', \SourceFramework\TEXTDOMAIN ),
        'add_new_item'          => __( 'Add New Testimonial', \SourceFramework\TEXTDOMAIN ),
        'add_new'               => __( 'New Testimonial', \SourceFramework\TEXTDOMAIN ),
        'new_item'              => __( 'New Item', \SourceFramework\TEXTDOMAIN ),
        'edit_item'             => __( 'Edit Testimonial', \SourceFramework\TEXTDOMAIN ),
        'update_item'           => __( 'Update Testimonial', \SourceFramework\TEXTDOMAIN ),
        'view_item'             => __( 'View Testimonial', \SourceFramework\TEXTDOMAIN ),
        'search_items'          => __( 'Search testimonial', \SourceFramework\TEXTDOMAIN ),
        'not_found'             => __( 'No testimonial found', \SourceFramework\TEXTDOMAIN ),
        'not_found_in_trash'    => __( 'No testimonial found in Trash', \SourceFramework\TEXTDOMAIN ),
        'insert_into_item'      => __( 'Insert into item', \SourceFramework\TEXTDOMAIN ),
        'uploaded_to_this_item' => __( 'Uploaded to this item', \SourceFramework\TEXTDOMAIN ),
        'items_list'            => __( 'Items list', \SourceFramework\TEXTDOMAIN ),
        'items_list_navigation' => __( 'Items list navigation', \SourceFramework\TEXTDOMAIN ),
        'filter_items_list'     => __( 'Filter items list', \SourceFramework\TEXTDOMAIN ),
    );
    $rewrite = array(
        'slug'       => _x( 'testimonial', 'post_type slug', \SourceFramework\TEXTDOMAIN ),
        'with_front' => true,
        'pages'      => true,
        'feeds'      => true,
    );
    $args    = array(
        'label'               => __( 'Testimonial', \SourceFramework\TEXTDOMAIN ),
        'labels'              => $labels,
        'supports'            => array( 'title', 'editor', 'excerpt', 'thumbnail', ),
        'taxonomies'          => array( 'testimonial_cat', 'testimonial_tag' ),
        'hierarchical'        => false,
        'public'              => true,
        'show_ui'             => true,
        'show_in_menu'        => true,
        'menu_position'       => 20,
        'menu_icon'           => 'dashicons-star-filled',
        'show_in_admin_bar'   => true,
        'show_in_nav_menus'   => true,
        'can_export'          => true,
        'has_archive'         => _x( 'testimonial', 'post_type archive_slug', \SourceFramework\TEXTDOMAIN ),
        'exclude_from_search' => false,
        'publicly_queryable'  => true,
        'rewrite'             => $rewrite,
        'capability_type'     => 'post',
    );
    register_post_type( 'testimonial', $args );
  }

  /**
   * Register Testimonial Category Taxonomy.
   *
   * @since 1.0.0
   */
  public function category() {
    $labels  = array(
        'name'                       => __( 'Testimonial Categories', \SourceFramework\TEXTDOMAIN ),
        'singular_name'              => __( 'Testimonial Category', \SourceFramework\TEXTDOMAIN ),
        'menu_name'                  => __( 'Categories', \SourceFramework\TEXTDOMAIN ),
        'all_items'                  => __( 'All Testimonial Categories', \SourceFramework\TEXTDOMAIN ),
        'parent_item'                => __( 'Parent Testimonial Categories', \SourceFramework\TEXTDOMAIN ),
        'parent_item_colon'          => __( 'Parent Testimonial Categories:', \SourceFramework\TEXTDOMAIN ),
        'new_item_name'              => __( 'New Testimonial Categories Name', \SourceFramework\TEXTDOMAIN ),
        'add_new_item'               => __( 'Add New Item', \SourceFramework\TEXTDOMAIN ),
        'edit_item'                  => __( 'Edit Testimonial Categories', \SourceFramework\TEXTDOMAIN ),
        'update_item'                => __( 'Update Testimonial Categories', \SourceFramework\TEXTDOMAIN ),
        'view_item'                  => __( 'View Item', \SourceFramework\TEXTDOMAIN ),
        'separate_items_with_commas' => __( 'Separate items with commas', \SourceFramework\TEXTDOMAIN ),
        'add_or_remove_items'        => __( 'Add or remove items', \SourceFramework\TEXTDOMAIN ),
        'choose_from_most_used'      => __( 'Choose from the most used', \SourceFramework\TEXTDOMAIN ),
        'popular_items'              => __( 'Popular Items', \SourceFramework\TEXTDOMAIN ),
        'search_items'               => __( 'Search Testimonial Categories', \SourceFramework\TEXTDOMAIN ),
        'not_found'                  => __( 'Not Found', \SourceFramework\TEXTDOMAIN ),
        'no_terms'                   => __( 'No items', \SourceFramework\TEXTDOMAIN ),
        'items_list'                 => __( 'Items list', \SourceFramework\TEXTDOMAIN ),
        'items_list_navigation'      => __( 'Items list navigation', \SourceFramework\TEXTDOMAIN ),
    );
    $rewrite = array(
        'slug'         => _x( 'testimonial-category', 'taxonomy slug', \SourceFramework\TEXTDOMAIN ),
        'with_front'   => false,
        'hierarchical' => true,
    );
    $args    = array(
        'labels'            => $labels,
        'hierarchical'      => true,
        'public'            => true,
        'show_ui'           => true,
        'show_admin_column' => true,
        'show_in_nav_menus' => true,
        'show_tagcloud'     => true,
        'rewrite'           => $rewrite,
    );
    register_taxonomy( 'testimonial_cat', array( 'testimonial' ), $args );
  }

  /**
   * Register Testimonial Tag Taxonomy.
   *
   * @since 1.0.0
   */
  public function tag() {
    $labels  = array(
        'name'                       => __( 'Testimonial Tags', \SourceFramework\TEXTDOMAIN ),
        'singular_name'              => __( 'Testimonial Tag', \SourceFramework\TEXTDOMAIN ),
        'menu_name'                  => __( 'Tags', \SourceFramework\TEXTDOMAIN ),
        'all_items'                  => __( 'All Testimonial Tags', \SourceFramework\TEXTDOMAIN ),
        'parent_item'                => __( 'Parent Testimonial Tags', \SourceFramework\TEXTDOMAIN ),
        'parent_item_colon'          => __( 'Parent Testimonial Tags:', \SourceFramework\TEXTDOMAIN ),
        'new_item_name'              => __( 'New Testimonial Tags Name', \SourceFramework\TEXTDOMAIN ),
        'add_new_item'               => __( 'Add New Item', \SourceFramework\TEXTDOMAIN ),
        'edit_item'                  => __( 'Edit Testimonial Tags', \SourceFramework\TEXTDOMAIN ),
        'update_item'                => __( 'Update Testimonial Tags', \SourceFramework\TEXTDOMAIN ),
        'view_item'                  => __( 'View Item', \SourceFramework\TEXTDOMAIN ),
        'separate_items_with_commas' => __( 'Separate items with commas', \SourceFramework\TEXTDOMAIN ),
        'add_or_remove_items'        => __( 'Add or remove items', \SourceFramework\TEXTDOMAIN ),
        'choose_from_most_used'      => __( 'Choose from the most used', \SourceFramework\TEXTDOMAIN ),
        'popular_items'              => __( 'Popular Items', \SourceFramework\TEXTDOMAIN ),
        'search_items'               => __( 'Search Testimonial Tags', \SourceFramework\TEXTDOMAIN ),
        'not_found'                  => __( 'Not Found', \SourceFramework\TEXTDOMAIN ),
        'no_terms'                   => __( 'No items', \SourceFramework\TEXTDOMAIN ),
        'items_list'                 => __( 'Items list', \SourceFramework\TEXTDOMAIN ),
        'items_list_navigation'      => __( 'Items list navigation', \SourceFramework\TEXTDOMAIN ),
    );
    $rewrite = array(
        'slug'         => _x( 'testimonial-tag', 'taxonomy slug', \SourceFramework\TEXTDOMAIN ),
        'with_front'   => false,
        'hierarchical' => true,
    );
    $args    = array(
        'labels'            => $labels,
        'hierarchical'      => false,
        'public'            => true,
        'show_ui'           => true,
        'show_admin_column' => true,
        'show_in_nav_menus' => true,
        'show_tagcloud'     => true,
        'rewrite'           => $rewrite,
    );
    register_taxonomy( 'testimonial_tag', array( 'testimonial' ), $args );
  }

}
