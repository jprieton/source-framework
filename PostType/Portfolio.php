<?php

namespace SourceFramework\PostType;

/**
 * If this file is called directly, abort.
 */
if ( !defined( 'ABSPATH' ) ) {
  die( 'Direct access is forbidden.' );
}

/**
 * Portfolio Post Type
 *
 * @package        PostType
 * @since          1.0.0
 * @author         Javier Prieto <jprieton@gmail.com>
 */
class Portfolio {

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
   * Register Portfolio Post Type.
   *
   * @since 1.0.0
   */
  public function post_type() {

    $labels  = array(
        'name'                  => __( 'Portfolios', \SMGTools\TEXTDOMAIN ),
        'singular_name'         => __( 'Portfolio', \SMGTools\TEXTDOMAIN ),
        'menu_name'             => __( 'Portfolios', \SMGTools\TEXTDOMAIN ),
        'name_admin_bar'        => __( 'Portfolio', \SMGTools\TEXTDOMAIN ),
        'archives'              => __( 'Item Archives', \SMGTools\TEXTDOMAIN ),
        'all_items'             => __( 'All Portfolios', \SMGTools\TEXTDOMAIN ),
        'add_new_item'          => __( 'Add New Portfolio', \SMGTools\TEXTDOMAIN ),
        'add_new'               => __( 'New Portfolio', \SMGTools\TEXTDOMAIN ),
        'new_item'              => __( 'New Item', \SMGTools\TEXTDOMAIN ),
        'edit_item'             => __( 'Edit Portfolio', \SMGTools\TEXTDOMAIN ),
        'update_item'           => __( 'Update Portfolio', \SMGTools\TEXTDOMAIN ),
        'view_item'             => __( 'View Portfolio', \SMGTools\TEXTDOMAIN ),
        'search_items'          => __( 'Search portfolio', \SMGTools\TEXTDOMAIN ),
        'not_found'             => __( 'No portfolio found', \SMGTools\TEXTDOMAIN ),
        'not_found_in_trash'    => __( 'No portfolio found in Trash', \SMGTools\TEXTDOMAIN ),
        'insert_into_item'      => __( 'Insert into item', \SMGTools\TEXTDOMAIN ),
        'uploaded_to_this_item' => __( 'Uploaded to this item', \SMGTools\TEXTDOMAIN ),
        'items_list'            => __( 'Items list', \SMGTools\TEXTDOMAIN ),
        'items_list_navigation' => __( 'Items list navigation', \SMGTools\TEXTDOMAIN ),
        'filter_items_list'     => __( 'Filter items list', \SMGTools\TEXTDOMAIN ),
    );
    $rewrite = array(
        'slug'       => _x( 'portfolio', 'post_type slug', \SMGTools\TEXTDOMAIN ),
        'with_front' => true,
        'pages'      => true,
        'feeds'      => true,
    );
    $args    = array(
        'label'               => __( 'Portfolio', \SMGTools\TEXTDOMAIN ),
        'description'         => __( 'Site portfolio.', \SMGTools\TEXTDOMAIN ),
        'labels'              => $labels,
        'supports'            => array( 'title', 'editor', 'excerpt', 'thumbnail', ),
        'taxonomies'          => array( 'portfolio_cat', 'portfolio_tag' ),
        'hierarchical'        => false,
        'public'              => true,
        'show_ui'             => true,
        'show_in_menu'        => true,
        'menu_position'       => 20,
        'menu_icon'           => 'dashicons-portfolio',
        'show_in_admin_bar'   => true,
        'show_in_nav_menus'   => true,
        'can_export'          => true,
        'has_archive'         => _x( 'portfolio', 'post_type archive_slug', \SMGTools\TEXTDOMAIN ),
        'exclude_from_search' => false,
        'publicly_queryable'  => true,
        'rewrite'             => $rewrite,
        'capability_type'     => 'post',
    );
    register_post_type( 'portfolio', $args );
  }

  /**
   * Register Portfolio Category Taxonomy.
   *
   * @since 1.0.0
   */
  public function category() {
    $labels  = array(
        'name'                       => __( 'Portfolio Categories', \SMGTools\TEXTDOMAIN ),
        'singular_name'              => __( 'Portfolio Category', \SMGTools\TEXTDOMAIN ),
        'menu_name'                  => __( 'Categories', \SMGTools\TEXTDOMAIN ),
        'all_items'                  => __( 'All Portfolio Categories', \SMGTools\TEXTDOMAIN ),
        'parent_item'                => __( 'Parent Portfolio Categories', \SMGTools\TEXTDOMAIN ),
        'parent_item_colon'          => __( 'Parent Portfolio Categories:', \SMGTools\TEXTDOMAIN ),
        'new_item_name'              => __( 'New Portfolio Categories Name', \SMGTools\TEXTDOMAIN ),
        'add_new_item'               => __( 'Add New Item', \SMGTools\TEXTDOMAIN ),
        'edit_item'                  => __( 'Edit Portfolio Categories', \SMGTools\TEXTDOMAIN ),
        'update_item'                => __( 'Update Portfolio Categories', \SMGTools\TEXTDOMAIN ),
        'view_item'                  => __( 'View Item', \SMGTools\TEXTDOMAIN ),
        'separate_items_with_commas' => __( 'Separate items with commas', \SMGTools\TEXTDOMAIN ),
        'add_or_remove_items'        => __( 'Add or remove items', \SMGTools\TEXTDOMAIN ),
        'choose_from_most_used'      => __( 'Choose from the most used', \SMGTools\TEXTDOMAIN ),
        'popular_items'              => __( 'Popular Items', \SMGTools\TEXTDOMAIN ),
        'search_items'               => __( 'Search Portfolio Categories', \SMGTools\TEXTDOMAIN ),
        'not_found'                  => __( 'Not Found', \SMGTools\TEXTDOMAIN ),
        'no_terms'                   => __( 'No items', \SMGTools\TEXTDOMAIN ),
        'items_list'                 => __( 'Items list', \SMGTools\TEXTDOMAIN ),
        'items_list_navigation'      => __( 'Items list navigation', \SMGTools\TEXTDOMAIN ),
    );
    $rewrite = array(
        'slug'         => _x( 'portfolio-category', 'taxonomy slug', \SMGTools\TEXTDOMAIN ),
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
    register_taxonomy( 'portfolio_cat', array( 'portfolio' ), $args );
  }

  /**
   * Register Portfolio Tag Taxonomy.
   *
   * @since 1.0.0
   */
  public function tag() {
    $labels  = array(
        'name'                       => __( 'Portfolio Tags', \SMGTools\TEXTDOMAIN ),
        'singular_name'              => __( 'Portfolio Tag', \SMGTools\TEXTDOMAIN ),
        'menu_name'                  => __( 'Tags', \SMGTools\TEXTDOMAIN ),
        'all_items'                  => __( 'All Portfolio Tags', \SMGTools\TEXTDOMAIN ),
        'parent_item'                => __( 'Parent Portfolio Tags', \SMGTools\TEXTDOMAIN ),
        'parent_item_colon'          => __( 'Parent Portfolio Tags:', \SMGTools\TEXTDOMAIN ),
        'new_item_name'              => __( 'New Portfolio Tags Name', \SMGTools\TEXTDOMAIN ),
        'add_new_item'               => __( 'Add New Item', \SMGTools\TEXTDOMAIN ),
        'edit_item'                  => __( 'Edit Portfolio Tags', \SMGTools\TEXTDOMAIN ),
        'update_item'                => __( 'Update Portfolio Tags', \SMGTools\TEXTDOMAIN ),
        'view_item'                  => __( 'View Item', \SMGTools\TEXTDOMAIN ),
        'separate_items_with_commas' => __( 'Separate items with commas', \SMGTools\TEXTDOMAIN ),
        'add_or_remove_items'        => __( 'Add or remove items', \SMGTools\TEXTDOMAIN ),
        'choose_from_most_used'      => __( 'Choose from the most used', \SMGTools\TEXTDOMAIN ),
        'popular_items'              => __( 'Popular Items', \SMGTools\TEXTDOMAIN ),
        'search_items'               => __( 'Search Portfolio Tags', \SMGTools\TEXTDOMAIN ),
        'not_found'                  => __( 'Not Found', \SMGTools\TEXTDOMAIN ),
        'no_terms'                   => __( 'No items', \SMGTools\TEXTDOMAIN ),
        'items_list'                 => __( 'Items list', \SMGTools\TEXTDOMAIN ),
        'items_list_navigation'      => __( 'Items list navigation', \SMGTools\TEXTDOMAIN ),
    );
    $rewrite = array(
        'slug'         => _x( 'portfolio-tag', 'taxonomy slug', \SMGTools\TEXTDOMAIN ),
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
    register_taxonomy( 'portfolio_tag', array( 'portfolio' ), $args );
  }

}
