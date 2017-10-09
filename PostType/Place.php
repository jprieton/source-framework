<?php

namespace SourceFramework\PostType;

/**
 * If this file is called directly, abort.
 */
if ( !defined( 'ABSPATH' ) ) {
  die( 'Direct access is forbidden.' );
}

/**
 * Place Post Type
 *
 * @package        PostType
 * @since          1.0.0
 * @author         Javier Prieto <jprieton@gmail.com>
 */
class Place {

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
   * Register Place Post Type.
   *
   * @since 1.0.0
   */
  public function post_type() {

    $labels  = array(
        'name'                  => __( 'Places', \SourceFramework\TEXTDOMAIN ),
        'singular_name'         => __( 'Place', \SourceFramework\TEXTDOMAIN ),
        'menu_name'             => __( 'Places', \SourceFramework\TEXTDOMAIN ),
        'name_admin_bar'        => __( 'Place', \SourceFramework\TEXTDOMAIN ),
        'archives'              => __( 'Item Archives', \SourceFramework\TEXTDOMAIN ),
        'all_items'             => __( 'All Places', \SourceFramework\TEXTDOMAIN ),
        'add_new_item'          => __( 'Add New Place', \SourceFramework\TEXTDOMAIN ),
        'add_new'               => __( 'New Place', \SourceFramework\TEXTDOMAIN ),
        'new_item'              => __( 'New Item', \SourceFramework\TEXTDOMAIN ),
        'edit_item'             => __( 'Edit Place', \SourceFramework\TEXTDOMAIN ),
        'update_item'           => __( 'Update Place', \SourceFramework\TEXTDOMAIN ),
        'view_item'             => __( 'View Place', \SourceFramework\TEXTDOMAIN ),
        'search_items'          => __( 'Search place', \SourceFramework\TEXTDOMAIN ),
        'not_found'             => __( 'No place found', \SourceFramework\TEXTDOMAIN ),
        'not_found_in_trash'    => __( 'No place found in Trash', \SourceFramework\TEXTDOMAIN ),
        'insert_into_item'      => __( 'Insert into item', \SourceFramework\TEXTDOMAIN ),
        'uploaded_to_this_item' => __( 'Uploaded to this item', \SourceFramework\TEXTDOMAIN ),
        'items_list'            => __( 'Items list', \SourceFramework\TEXTDOMAIN ),
        'items_list_navigation' => __( 'Items list navigation', \SourceFramework\TEXTDOMAIN ),
        'filter_items_list'     => __( 'Filter items list', \SourceFramework\TEXTDOMAIN ),
    );
    $rewrite = array(
        'slug'       => _x( 'place', 'post_type slug', \SourceFramework\TEXTDOMAIN ),
        'with_front' => true,
        'pages'      => true,
        'feeds'      => true,
    );
    $args    = array(
        'label'               => __( 'Place', \SourceFramework\TEXTDOMAIN ),
        'labels'              => $labels,
        'supports'            => array( 'title', 'editor', 'excerpt', 'thumbnail', ),
        'taxonomies'          => array( 'place_cat', 'place_tag' ),
        'hierarchical'        => false,
        'public'              => true,
        'show_ui'             => true,
        'show_in_menu'        => true,
        'menu_position'       => 20,
        'menu_icon'           => 'dashicons-location-alt',
        'show_in_admin_bar'   => true,
        'show_in_nav_menus'   => true,
        'can_export'          => true,
        'has_archive'         => _x( 'place', 'post_type archive_slug', \SourceFramework\TEXTDOMAIN ),
        'exclude_from_search' => false,
        'publicly_queryable'  => true,
        'rewrite'             => $rewrite,
        'capability_type'     => 'post',
    );
    register_post_type( 'place', $args );
  }

  /**
   * Register Place Category Taxonomy.
   *
   * @since 1.0.0
   */
  public function category() {
    $labels  = array(
        'name'                       => __( 'Place Categories', \SourceFramework\TEXTDOMAIN ),
        'singular_name'              => __( 'Place Category', \SourceFramework\TEXTDOMAIN ),
        'menu_name'                  => __( 'Categories', \SourceFramework\TEXTDOMAIN ),
        'parent_item'                => __( 'Parent Place Categories', \SourceFramework\TEXTDOMAIN ),
        'parent_item_colon'          => __( 'Parent Place Categories:', \SourceFramework\TEXTDOMAIN ),
        'new_item_name'              => __( 'New Place Categories Name', \SourceFramework\TEXTDOMAIN ),
        'add_new_item'               => __( 'Add New Item', \SourceFramework\TEXTDOMAIN ),
        'edit_item'                  => __( 'Edit Place Categories', \SourceFramework\TEXTDOMAIN ),
        'update_item'                => __( 'Update Place Categories', \SourceFramework\TEXTDOMAIN ),
        'view_item'                  => __( 'View Item', \SourceFramework\TEXTDOMAIN ),
        'add_or_remove_items'        => __( 'Add or remove items', \SourceFramework\TEXTDOMAIN ),
        'popular_items'              => __( 'Popular Items', \SourceFramework\TEXTDOMAIN ),
        'search_items'               => __( 'Search Place Categories', \SourceFramework\TEXTDOMAIN ),
        'not_found'                  => __( 'Not Found', \SourceFramework\TEXTDOMAIN ),
        'no_terms'                   => __( 'No items', \SourceFramework\TEXTDOMAIN ),
        'items_list'                 => __( 'Items list', \SourceFramework\TEXTDOMAIN ),
        'items_list_navigation'      => __( 'Items list navigation', \SourceFramework\TEXTDOMAIN ),
    );
    $rewrite = array(
        'slug'         => _x( 'place-category', 'taxonomy slug', \SourceFramework\TEXTDOMAIN ),
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
    register_taxonomy( 'place_cat', array( 'place' ), $args );
  }

  /**
   * Register Place Tag Taxonomy.
   *
   * @since 1.0.0
   */
  public function tag() {
    $labels  = array(
        'name'                       => __( 'Place Tags', \SourceFramework\TEXTDOMAIN ),
        'singular_name'              => __( 'Place Tag', \SourceFramework\TEXTDOMAIN ),
        'menu_name'                  => __( 'Tags', \SourceFramework\TEXTDOMAIN ),
        'parent_item'                => __( 'Parent Place Tags', \SourceFramework\TEXTDOMAIN ),
        'parent_item_colon'          => __( 'Parent Place Tags:', \SourceFramework\TEXTDOMAIN ),
        'new_item_name'              => __( 'New Place Tags Name', \SourceFramework\TEXTDOMAIN ),
        'add_new_item'               => __( 'Add New Item', \SourceFramework\TEXTDOMAIN ),
        'edit_item'                  => __( 'Edit Place Tags', \SourceFramework\TEXTDOMAIN ),
        'update_item'                => __( 'Update Place Tags', \SourceFramework\TEXTDOMAIN ),
        'view_item'                  => __( 'View Item', \SourceFramework\TEXTDOMAIN ),
        'add_or_remove_items'        => __( 'Add or remove items', \SourceFramework\TEXTDOMAIN ),
        'popular_items'              => __( 'Popular Items', \SourceFramework\TEXTDOMAIN ),
        'search_items'               => __( 'Search Place Tags', \SourceFramework\TEXTDOMAIN ),
        'no_terms'                   => __( 'No items', \SourceFramework\TEXTDOMAIN ),
        'items_list'                 => __( 'Items list', \SourceFramework\TEXTDOMAIN ),
        'items_list_navigation'      => __( 'Items list navigation', \SourceFramework\TEXTDOMAIN ),
    );
    $rewrite = array(
        'slug'         => _x( 'place-tag', 'taxonomy slug', \SourceFramework\TEXTDOMAIN ),
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
    register_taxonomy( 'place_tag', array( 'place' ), $args );
  }

}
