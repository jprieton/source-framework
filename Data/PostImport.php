<?php

namespace SourceFramework\Data;

/**
 * If this file is called directly, abort.
 */
if ( !defined( 'ABSPATH' ) ) {
  die( 'Direct access is forbidden.' );
}

/**
 * CSV PostImport class
 *
 * @package        Data
 * @since          1.0.0
 * @author         Javier Prieto <jprieton@gmail.com>
 */
class PostImport {

  /**
   * The current delimiter.
   *
   * @var string
   */
  public $delimiter = ';';

  /**
   * Default post filters
   *
   * @since          1.0.0
   * @var array
   */
  protected $post_filter = [
      'ID'                    => [
          'callback' => 'absint' ],
      'post_author'           => [
          'callback' => 'absint' ],
      'post_date'             => [
          'validate' => 'is_date' ],
      'post_date_gmt'         => [
          'validate' => 'is_date' ],
      'post_content'          => [
          'callback' => 'trim' ],
      'post_title'            => [
          'callback' => 'trim' ],
      'post_excerpt'          => [
          'callback' => 'trim' ],
      'post_status'           => [
          'callback' => 'trim',
          'values'   => [ 'draft', 'publish', 'pending', 'private' ] ],
      'comment_status'        => [
          'callback' => 'trim',
          'values'   => [ 'open', 'close' ] ],
      'ping_status'           => [
          'callback' => 'trim',
          'values'   => [ 'open', 'close' ] ],
      'post_password'         => [
          'callback' => 'trim' ],
      'post_name'             => [
          'callback' => 'trim' ],
      'to_ping'               => [
          'callback' => 'trim' ],
      'pinged'                => [
          'callback' => 'trim' ],
      'post_modified'         => [
          'validate' => 'is_date' ],
      'post_modified_gmt'     => [
          'validate' => 'is_date', ],
      'post_content_filtered' => [
          'callback' => 'trim' ],
      'post_parent'           => [
          'callback' => 'absint',
          'default'  => 0 ],
      'guid'                  => [
          'callback' => 'trim' ],
      'menu_order'            => [
          'callback' => 'intval',
          'default'  => 0 ],
      'post_type'             => [
          'callback' => 'trim',
          'values'   => [] ],
      'post_mime_type'        => [
          'callback' => 'trim' ],
      'comment_count'         => [
          'callback' => 'absint' ],
  ];

  /**
   * Default meta filters
   *
   * @since          1.0.0
   * @var array
   */
  protected $meta_filter = [];

  /**
   * Default taxonomy filters
   *
   * @since          1.0.0
   * @var array
   */
  protected $taxonomy_filter = [];

  /**
   * Stores the post data ready to import
   *
   * @since          1.0.0
   * @var type
   */
  private $post_data = [];

  /**
   * Stores the post data before to import
   *
   * @since          1.0.0
   * @var type
   */
  private $raw_data = [];

  /**
   * @since          1.0.0
   */
  public function __construct() {
    // Add all enabled post types to filter
    $this->filter['post_type']['values'] = array_values( get_post_types( array(), 'names' ) );

    $this->post_filter     = apply_filters( 'source_framework_post_import_post_filter', $this->post_filter );
    $this->meta_filter     = apply_filters( 'source_framework_post_import_meta_filter', $this->meta_filter );
    $this->taxonomy_filter = apply_filters( 'source_framework_post_import_taxonomy_filter', $this->taxonomy_filter );
  }

  /**
   *
   * @param string $filepath
   */
  public function import( $filepath ) {
    if ( !is_file( $filepath ) ) {
      fwrite( STDERR, __( "The file does not exist.\n", \SourceFramework\TEXTDOMAIN ) );
      exit();
    }

    $handle = fopen( $filepath, "r" );
    if ( $handle === false ) {
      fwrite( STDERR, __( "Error on read file.\n", \SourceFramework\TEXTDOMAIN ) );
      exit();
    }
  }

  /**
   * Filter the post data
   *
   * @since          1.0.0
   */
  public function _filter_fields() {
    foreach ( $this->filter as $key => $rules ) {

      if ( !array_key_exists( $key, $this->raw_data ) ) {
        $this->data[$key] = $this->default[$key];
        continue;
      }

      if ( !empty( $this->raw_data[$key] ) ) {
        $this->data[$key] = $this->raw_data[$key];
        unset( $this->raw_data[$key] );
      } else {
        $this->data[$key] = $this->default[$key];
        continue;
      }

      if ( !empty( $rules['callback'] ) && is_callable( $rules['callback'] ) ) {
        $this->data[$key] = $rules['callback']( $this->data[$key] );
      } elseif ( !empty( $rules['callback'] ) && function_exists( $rules['callback'] ) ) {
        $this->data[$key] = call_user_func( $rules['callback'], $this->data[$key] );
      }

      if ( !empty( $rules['validate'] ) && is_callable( $rules['validate'] ) ) {
        $validated = (bool) $rules['validate']( $this->data[$key] );
      } elseif ( !empty( $rules['validate'] ) && function_exists( $rules['validate'] ) ) {
        $validated = (bool) call_user_func( $rules['validate'], $this->data[$key] );
      } else {
        $validated = true;
      }

      $this->data[$key] = $validated ? $this->data[$key] : $this->default[$key];

      if ( !empty( $rules['values'] ) && !in_array( $this->data[$key], $rules['values'] ) ) {
        $this->data[$key] = $this->default[$key];
      }
    }
  }

  /**
   * @since          1.0.0
   */
  public function save_post() {
    // Check if post exists
    if ( $this->data['ID'] > 0 ) {
      $post = get_post( $this->data['ID'] );
      if ( empty( $post ) ) {
        unset( $this->data['ID'] );
      }
    }
    // Check if post parent exists
    if ( $this->data['post_parent'] > 0 ) {
      $post = get_post( $this->data['post_parent'] );
      if ( empty( $post ) ) {
        $this->data['post_parent'] = 0;
      }
    }
  }

  /**
   * Create terms if not exists
   * 
   * @since          1.0.0
   * 
   * @param string $name
   * @param string $taxonomy
   */
  private function _create_term( $name, $taxonomy ) {
    $term_ids = [];
    $names    = array_diff( array_unique( explode( '>', $name ) ), [ '' ] );

    $parent = 0;
    foreach ( $names as $item ) {
      $item  = apply_filters( "pre_term_name", $item, $taxonomy );
      $_term = get_term_by( 'name', $item, $taxonomy );

      if ( empty( $_term ) ) {
        $_term      = wp_insert_term( $item, $taxonomy, compact( 'parent' ) );
        $term_ids[] = $parent     = $_term['term_id'];
      } else {
        $term_ids[] = $parent     = $_term->term_id;
      }
    }
    return $term_ids;
  }

}
