<?php

namespace SourceFramework\PostType;

/**
 * If this file is called directly, abort.
 */
if ( !defined( 'ABSPATH' ) ) {
  die( 'Direct access is forbidden.' );
}

/**
 * Product Post Type
 *
 * @package        PostType
 * @since          1.0.0
 * @author         Javier Prieto <jprieton@gmail.com>
 */
class Product {

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
   * Register Product Post Type.
   *
   * @since 1.0.0
   */
  public function post_type() {

    $labels  = array(
        'name'                  => __( 'Products', \SourceFramework\TEXTDOMAIN ),
        'singular_name'         => __( 'Product', \SourceFramework\TEXTDOMAIN ),
        'menu_name'             => __( 'Products', \SourceFramework\TEXTDOMAIN ),
        'name_admin_bar'        => __( 'Product', \SourceFramework\TEXTDOMAIN ),
        'archives'              => __( 'Item Archives', \SourceFramework\TEXTDOMAIN ),
        'all_items'             => __( 'All Products', \SourceFramework\TEXTDOMAIN ),
        'add_new_item'          => __( 'Add New Product', \SourceFramework\TEXTDOMAIN ),
        'add_new'               => __( 'New Product', \SourceFramework\TEXTDOMAIN ),
        'edit_item'             => __( 'Edit Product', \SourceFramework\TEXTDOMAIN ),
        'update_item'           => __( 'Update Product', \SourceFramework\TEXTDOMAIN ),
        'view_item'             => __( 'View Product', \SourceFramework\TEXTDOMAIN ),
        'search_items'          => __( 'Search product', \SourceFramework\TEXTDOMAIN ),
        'not_found'             => __( 'No product found', \SourceFramework\TEXTDOMAIN ),
        'not_found_in_trash'    => __( 'No product found in Trash', \SourceFramework\TEXTDOMAIN ),
        'insert_into_item'      => __( 'Insert into item', \SourceFramework\TEXTDOMAIN ),
        'uploaded_to_this_item' => __( 'Uploaded to this item', \SourceFramework\TEXTDOMAIN ),
        'items_list'            => __( 'Items list', \SourceFramework\TEXTDOMAIN ),
        'items_list_navigation' => __( 'Items list navigation', \SourceFramework\TEXTDOMAIN ),
        'filter_items_list'     => __( 'Filter items list', \SourceFramework\TEXTDOMAIN ),
    );
    $rewrite = array(
        'slug'       => _x( 'product', 'post_type slug', \SourceFramework\TEXTDOMAIN ),
        'with_front' => true,
        'pages'      => true,
        'feeds'      => true,
    );
    $args    = array(
        'label'               => __( 'Product', \SourceFramework\TEXTDOMAIN ),
        'labels'              => $labels,
        'supports'            => array( 'title', 'editor', 'excerpt', 'thumbnail', ),
        'taxonomies'          => array( 'product_cat', 'product_tag' ),
        'hierarchical'        => false,
        'public'              => true,
        'show_ui'             => true,
        'show_in_menu'        => true,
        'menu_position'       => 20,
        'menu_icon'           => 'dashicons-cart',
        'show_in_admin_bar'   => true,
        'show_in_nav_menus'   => true,
        'can_export'          => true,
        'has_archive'         => _x( 'product', 'post_type archive_slug', \SourceFramework\TEXTDOMAIN ),
        'exclude_from_search' => false,
        'publicly_queryable'  => true,
        'rewrite'             => $rewrite,
        'capability_type'     => 'post',
    );
    register_post_type( 'product', $args );
  }

  /**
   * Register Product Category Taxonomy.
   *
   * @since 1.0.0
   */
  public function category() {
    $labels  = array(
        'name'                       => __( 'Product Categories', \SourceFramework\TEXTDOMAIN ),
        'singular_name'              => __( 'Product Category', \SourceFramework\TEXTDOMAIN ),
        'menu_name'                  => __( 'Categories', \SourceFramework\TEXTDOMAIN ),
        'parent_item'                => __( 'Parent Product Categories', \SourceFramework\TEXTDOMAIN ),
        'parent_item_colon'          => __( 'Parent Product Categories:', \SourceFramework\TEXTDOMAIN ),
        'new_item_name'              => __( 'New Product Categories Name', \SourceFramework\TEXTDOMAIN ),
        'add_new_item'               => __( 'Add New Item', \SourceFramework\TEXTDOMAIN ),
        'edit_item'                  => __( 'Edit Product Categories', \SourceFramework\TEXTDOMAIN ),
        'update_item'                => __( 'Update Product Categories', \SourceFramework\TEXTDOMAIN ),
        'view_item'                  => __( 'View Item', \SourceFramework\TEXTDOMAIN ),
        'add_or_remove_items'        => __( 'Add or remove items', \SourceFramework\TEXTDOMAIN ),
        'popular_items'              => __( 'Popular Items', \SourceFramework\TEXTDOMAIN ),
        'search_items'               => __( 'Search Product Categories', \SourceFramework\TEXTDOMAIN ),
        'not_found'                  => __( 'Not Found', \SourceFramework\TEXTDOMAIN ),
        'no_terms'                   => __( 'No items', \SourceFramework\TEXTDOMAIN ),
        'items_list'                 => __( 'Items list', \SourceFramework\TEXTDOMAIN ),
        'items_list_navigation'      => __( 'Items list navigation', \SourceFramework\TEXTDOMAIN ),
    );
    $rewrite = array(
        'slug'         => _x( 'product-category', 'taxonomy slug', \SourceFramework\TEXTDOMAIN ),
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
    register_taxonomy( 'product_cat', array( 'product' ), $args );
  }

  /**
   * Register Product Tag Taxonomy.
   *
   * @since 1.0.0
   */
  public function tag() {
    $labels  = array(
        'name'                       => __( 'Product Tags', \SourceFramework\TEXTDOMAIN ),
        'singular_name'              => __( 'Product Tag', \SourceFramework\TEXTDOMAIN ),
        'menu_name'                  => __( 'Tags', \SourceFramework\TEXTDOMAIN ),
        'parent_item'                => __( 'Parent Product Tags', \SourceFramework\TEXTDOMAIN ),
        'parent_item_colon'          => __( 'Parent Product Tags:', \SourceFramework\TEXTDOMAIN ),
        'new_item_name'              => __( 'New Product Tags Name', \SourceFramework\TEXTDOMAIN ),
        'add_new_item'               => __( 'Add New Item', \SourceFramework\TEXTDOMAIN ),
        'edit_item'                  => __( 'Edit Product Tags', \SourceFramework\TEXTDOMAIN ),
        'update_item'                => __( 'Update Product Tags', \SourceFramework\TEXTDOMAIN ),
        'view_item'                  => __( 'View Item', \SourceFramework\TEXTDOMAIN ),
        'add_or_remove_items'        => __( 'Add or remove items', \SourceFramework\TEXTDOMAIN ),
        'popular_items'              => __( 'Popular Items', \SourceFramework\TEXTDOMAIN ),
        'search_items'               => __( 'Search Product Tags', \SourceFramework\TEXTDOMAIN ),
        'no_terms'                   => __( 'No items', \SourceFramework\TEXTDOMAIN ),
        'items_list'                 => __( 'Items list', \SourceFramework\TEXTDOMAIN ),
        'items_list_navigation'      => __( 'Items list navigation', \SourceFramework\TEXTDOMAIN ),
    );
    $rewrite = array(
        'slug'         => _x( 'product-tag', 'taxonomy slug', \SourceFramework\TEXTDOMAIN ),
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
    register_taxonomy( 'product_tag', array( 'product' ), $args );
  }

}
