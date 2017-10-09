<?php

namespace SourceFramework\PostType;

/**
 * If this file is called directly, abort.
 */
if ( !defined( 'ABSPATH' ) ) {
  die( 'Direct access is forbidden.' );
}

/**
 * Quote Post Type
 *
 * @package        PostType
 * @since          1.0.0
 * @author         Javier Prieto <jprieton@gmail.com>
 */
class Quote {

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
   * Register Quote Post Type.
   *
   * @since 1.0.0
   */
  public function post_type() {

    $labels  = array(
        'name'                  => __( 'Quotes', \SourceFramework\TEXTDOMAIN ),
        'singular_name'         => __( 'Quote', \SourceFramework\TEXTDOMAIN ),
        'menu_name'             => __( 'Quotes', \SourceFramework\TEXTDOMAIN ),
        'name_admin_bar'        => __( 'Quote', \SourceFramework\TEXTDOMAIN ),
        'archives'              => __( 'Item Archives', \SourceFramework\TEXTDOMAIN ),
        'all_items'             => __( 'All Quotes', \SourceFramework\TEXTDOMAIN ),
        'add_new_item'          => __( 'Add New Quote', \SourceFramework\TEXTDOMAIN ),
        'add_new'               => __( 'New Quote', \SourceFramework\TEXTDOMAIN ),
        'new_item'              => __( 'New Item', \SourceFramework\TEXTDOMAIN ),
        'edit_item'             => __( 'Edit Quote', \SourceFramework\TEXTDOMAIN ),
        'update_item'           => __( 'Update Quote', \SourceFramework\TEXTDOMAIN ),
        'view_item'             => __( 'View Quote', \SourceFramework\TEXTDOMAIN ),
        'search_items'          => __( 'Search quote', \SourceFramework\TEXTDOMAIN ),
        'not_found'             => __( 'No quote found', \SourceFramework\TEXTDOMAIN ),
        'not_found_in_trash'    => __( 'No quote found in Trash', \SourceFramework\TEXTDOMAIN ),
        'insert_into_item'      => __( 'Insert into item', \SourceFramework\TEXTDOMAIN ),
        'uploaded_to_this_item' => __( 'Uploaded to this item', \SourceFramework\TEXTDOMAIN ),
        'items_list'            => __( 'Items list', \SourceFramework\TEXTDOMAIN ),
        'items_list_navigation' => __( 'Items list navigation', \SourceFramework\TEXTDOMAIN ),
        'filter_items_list'     => __( 'Filter items list', \SourceFramework\TEXTDOMAIN ),
    );
    $rewrite = array(
        'slug'       => _x( 'quote', 'post_type slug', \SourceFramework\TEXTDOMAIN ),
        'with_front' => true,
        'pages'      => true,
        'feeds'      => true,
    );
    $args    = array(
        'label'               => __( 'Quote', \SourceFramework\TEXTDOMAIN ),
        'labels'              => $labels,
        'supports'            => array( 'title', 'editor', 'excerpt', 'thumbnail', ),
        'taxonomies'          => array( 'quote_cat', 'quote_tag' ),
        'hierarchical'        => false,
        'public'              => true,
        'show_ui'             => true,
        'show_in_menu'        => true,
        'menu_position'       => 20,
        'menu_icon'           => 'dashicons-format-quote',
        'show_in_admin_bar'   => true,
        'show_in_nav_menus'   => true,
        'can_export'          => true,
        'has_archive'         => _x( 'quotes', 'post_type archive_slug', \SourceFramework\TEXTDOMAIN ),
        'exclude_from_search' => false,
        'publicly_queryable'  => true,
        'rewrite'             => $rewrite,
        'capability_type'     => 'post',
    );
    register_post_type( 'quote', $args );
  }

  /**
   * Register Quote Category Taxonomy.
   *
   * @since 1.0.0
   */
  public function category() {
    $labels  = array(
        'name'                       => __( 'Quote Categories', \SourceFramework\TEXTDOMAIN ),
        'singular_name'              => __( 'Quote Category', \SourceFramework\TEXTDOMAIN ),
        'menu_name'                  => __( 'Categories', \SourceFramework\TEXTDOMAIN ),
        'parent_item'                => __( 'Parent Quote Categories', \SourceFramework\TEXTDOMAIN ),
        'parent_item_colon'          => __( 'Parent Quote Categories:', \SourceFramework\TEXTDOMAIN ),
        'new_item_name'              => __( 'New Quote Categories Name', \SourceFramework\TEXTDOMAIN ),
        'add_new_item'               => __( 'Add New Item', \SourceFramework\TEXTDOMAIN ),
        'edit_item'                  => __( 'Edit Quote Categories', \SourceFramework\TEXTDOMAIN ),
        'update_item'                => __( 'Update Quote Categories', \SourceFramework\TEXTDOMAIN ),
        'view_item'                  => __( 'View Item', \SourceFramework\TEXTDOMAIN ),
        'add_or_remove_items'        => __( 'Add or remove items', \SourceFramework\TEXTDOMAIN ),
        'popular_items'              => __( 'Popular Items', \SourceFramework\TEXTDOMAIN ),
        'search_items'               => __( 'Search Quote Categories', \SourceFramework\TEXTDOMAIN ),
        'not_found'                  => __( 'Not Found', \SourceFramework\TEXTDOMAIN ),
        'no_terms'                   => __( 'No items', \SourceFramework\TEXTDOMAIN ),
        'items_list'                 => __( 'Items list', \SourceFramework\TEXTDOMAIN ),
        'items_list_navigation'      => __( 'Items list navigation', \SourceFramework\TEXTDOMAIN ),
    );
    $rewrite = array(
        'slug'         => _x( 'quote-category', 'taxonomy slug', \SourceFramework\TEXTDOMAIN ),
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
    register_taxonomy( 'quote_cat', array( 'quote' ), $args );
  }

  /**
   * Register Quote Tag Taxonomy.
   *
   * @since 1.0.0
   */
  public function tag() {
    $labels  = array(
        'name'                       => __( 'Quote Tags', \SourceFramework\TEXTDOMAIN ),
        'singular_name'              => __( 'Quote Tag', \SourceFramework\TEXTDOMAIN ),
        'menu_name'                  => __( 'Tags', \SourceFramework\TEXTDOMAIN ),
        'parent_item'                => __( 'Parent Quote Tags', \SourceFramework\TEXTDOMAIN ),
        'parent_item_colon'          => __( 'Parent Quote Tags:', \SourceFramework\TEXTDOMAIN ),
        'new_item_name'              => __( 'New Quote Tags Name', \SourceFramework\TEXTDOMAIN ),
        'add_new_item'               => __( 'Add New Item', \SourceFramework\TEXTDOMAIN ),
        'edit_item'                  => __( 'Edit Quote Tags', \SourceFramework\TEXTDOMAIN ),
        'update_item'                => __( 'Update Quote Tags', \SourceFramework\TEXTDOMAIN ),
        'view_item'                  => __( 'View Item', \SourceFramework\TEXTDOMAIN ),
        'add_or_remove_items'        => __( 'Add or remove items', \SourceFramework\TEXTDOMAIN ),
        'popular_items'              => __( 'Popular Items', \SourceFramework\TEXTDOMAIN ),
        'search_items'               => __( 'Search Quote Tags', \SourceFramework\TEXTDOMAIN ),
        'no_terms'                   => __( 'No items', \SourceFramework\TEXTDOMAIN ),
        'items_list'                 => __( 'Items list', \SourceFramework\TEXTDOMAIN ),
        'items_list_navigation'      => __( 'Items list navigation', \SourceFramework\TEXTDOMAIN ),
    );
    $rewrite = array(
        'slug'         => _x( 'quote-tag', 'taxonomy slug', \SourceFramework\TEXTDOMAIN ),
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
    register_taxonomy( 'quote_tag', array( 'quote' ), $args );
  }

}
