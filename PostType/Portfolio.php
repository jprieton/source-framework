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
        'name'                  => __( 'Portfolios', \SourceFramework\TEXTDOMAIN ),
        'singular_name'         => __( 'Portfolio', \SourceFramework\TEXTDOMAIN ),
        'menu_name'             => __( 'Portfolios', \SourceFramework\TEXTDOMAIN ),
        'name_admin_bar'        => __( 'Portfolio', \SourceFramework\TEXTDOMAIN ),
        'archives'              => __( 'Item Archives', \SourceFramework\TEXTDOMAIN ),
        'all_items'             => __( 'All Portfolios', \SourceFramework\TEXTDOMAIN ),
        'add_new_item'          => __( 'Add New Portfolio', \SourceFramework\TEXTDOMAIN ),
        'add_new'               => __( 'New Portfolio', \SourceFramework\TEXTDOMAIN ),
        'new_item'              => __( 'New Item', \SourceFramework\TEXTDOMAIN ),
        'edit_item'             => __( 'Edit Portfolio', \SourceFramework\TEXTDOMAIN ),
        'update_item'           => __( 'Update Portfolio', \SourceFramework\TEXTDOMAIN ),
        'view_item'             => __( 'View Portfolio', \SourceFramework\TEXTDOMAIN ),
        'search_items'          => __( 'Search portfolio', \SourceFramework\TEXTDOMAIN ),
        'not_found'             => __( 'No portfolio found', \SourceFramework\TEXTDOMAIN ),
        'not_found_in_trash'    => __( 'No portfolio found in Trash', \SourceFramework\TEXTDOMAIN ),
        'insert_into_item'      => __( 'Insert into item', \SourceFramework\TEXTDOMAIN ),
        'uploaded_to_this_item' => __( 'Uploaded to this item', \SourceFramework\TEXTDOMAIN ),
        'items_list'            => __( 'Items list', \SourceFramework\TEXTDOMAIN ),
        'items_list_navigation' => __( 'Items list navigation', \SourceFramework\TEXTDOMAIN ),
        'filter_items_list'     => __( 'Filter items list', \SourceFramework\TEXTDOMAIN ),
    );
    $rewrite = array(
        'slug'       => _x( 'portfolio', 'post_type slug', \SourceFramework\TEXTDOMAIN ),
        'with_front' => true,
        'pages'      => true,
        'feeds'      => true,
    );
    $args    = array(
        'label'               => __( 'Portfolio', \SourceFramework\TEXTDOMAIN ),
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
        'has_archive'         => _x( 'portfolio', 'post_type archive_slug', \SourceFramework\TEXTDOMAIN ),
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
        'name'                       => __( 'Portfolio Categories', \SourceFramework\TEXTDOMAIN ),
        'singular_name'              => __( 'Portfolio Category', \SourceFramework\TEXTDOMAIN ),
        'menu_name'                  => __( 'Categories', \SourceFramework\TEXTDOMAIN ),
        'parent_item'                => __( 'Parent Portfolio Categories', \SourceFramework\TEXTDOMAIN ),
        'parent_item_colon'          => __( 'Parent Portfolio Categories:', \SourceFramework\TEXTDOMAIN ),
        'new_item_name'              => __( 'New Portfolio Categories Name', \SourceFramework\TEXTDOMAIN ),
        'add_new_item'               => __( 'Add New Item', \SourceFramework\TEXTDOMAIN ),
        'edit_item'                  => __( 'Edit Portfolio Categories', \SourceFramework\TEXTDOMAIN ),
        'update_item'                => __( 'Update Portfolio Categories', \SourceFramework\TEXTDOMAIN ),
        'view_item'                  => __( 'View Item', \SourceFramework\TEXTDOMAIN ),
        'add_or_remove_items'        => __( 'Add or remove items', \SourceFramework\TEXTDOMAIN ),
        'popular_items'              => __( 'Popular Items', \SourceFramework\TEXTDOMAIN ),
        'search_items'               => __( 'Search Portfolio Categories', \SourceFramework\TEXTDOMAIN ),
        'not_found'                  => __( 'Not Found', \SourceFramework\TEXTDOMAIN ),
        'no_terms'                   => __( 'No items', \SourceFramework\TEXTDOMAIN ),
        'items_list'                 => __( 'Items list', \SourceFramework\TEXTDOMAIN ),
        'items_list_navigation'      => __( 'Items list navigation', \SourceFramework\TEXTDOMAIN ),
    );
    $rewrite = array(
        'slug'         => _x( 'portfolio-category', 'taxonomy slug', \SourceFramework\TEXTDOMAIN ),
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
        'name'                       => __( 'Portfolio Tags', \SourceFramework\TEXTDOMAIN ),
        'singular_name'              => __( 'Portfolio Tag', \SourceFramework\TEXTDOMAIN ),
        'menu_name'                  => __( 'Tags', \SourceFramework\TEXTDOMAIN ),
        'parent_item'                => __( 'Parent Portfolio Tags', \SourceFramework\TEXTDOMAIN ),
        'parent_item_colon'          => __( 'Parent Portfolio Tags:', \SourceFramework\TEXTDOMAIN ),
        'new_item_name'              => __( 'New Portfolio Tags Name', \SourceFramework\TEXTDOMAIN ),
        'add_new_item'               => __( 'Add New Item', \SourceFramework\TEXTDOMAIN ),
        'edit_item'                  => __( 'Edit Portfolio Tags', \SourceFramework\TEXTDOMAIN ),
        'update_item'                => __( 'Update Portfolio Tags', \SourceFramework\TEXTDOMAIN ),
        'view_item'                  => __( 'View Item', \SourceFramework\TEXTDOMAIN ),
        'add_or_remove_items'        => __( 'Add or remove items', \SourceFramework\TEXTDOMAIN ),
        'popular_items'              => __( 'Popular Items', \SourceFramework\TEXTDOMAIN ),
        'search_items'               => __( 'Search Portfolio Tags', \SourceFramework\TEXTDOMAIN ),
        'no_terms'                   => __( 'No items', \SourceFramework\TEXTDOMAIN ),
        'items_list'                 => __( 'Items list', \SourceFramework\TEXTDOMAIN ),
        'items_list_navigation'      => __( 'Items list navigation', \SourceFramework\TEXTDOMAIN ),
    );
    $rewrite = array(
        'slug'         => _x( 'portfolio-tag', 'taxonomy slug', \SourceFramework\TEXTDOMAIN ),
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
