<?php

namespace SourceFramework\Data;

/**
 * If this file is called directly, abort.
 */
if ( !defined( 'ABSPATH' ) ) {
  die( 'Direct access is forbidden.' );
}

use WP_Importer;
use SourceFramework\Template\Tag;

/**
 * CSV PostImport class
 *
 * @package        Data
 * @since          1.0.0
 * @author         Javier Prieto <jprieton@gmail.com>
 */
class PostImport extends WP_Importer {

  /**
   * The current delimiter.
   *
   * @var string
   */
  public $delimiter = ';';

  /**
   * Default values
   *
   * @since          1.0.0
   * @var array
   */
  private $default = [
      'ID'                    => 0,
      'post_author'           => '',
      'post_date'             => '0000-00-00 00:00:00',
      'post_date_gmt'         => '0000-00-00 00:00:00',
      'post_content'          => '',
      'post_title'            => '',
      'post_excerpt'          => '',
      'post_status'           => 'publish',
      'comment_status'        => 'open',
      'ping_status'           => 'open',
      'post_password'         => '',
      'post_name'             => '',
      'to_ping'               => '',
      'pinged'                => '',
      'post_modified'         => '0000-00-00 00:00:00',
      'post_modified_gmt'     => '0000-00-00 00:00:00',
      'post_content_filtered' => '',
      'post_parent'           => 0,
      'guid'                  => '',
      'menu_order'            => 0,
      'post_type'             => 'post',
      'post_mime_type'        => '',
      'comment_count'         => 0,
  ];

  /**
   * Default filters
   *
   * @since          1.0.0
   * @var array
   */
  private $filter = [
      'ID'                    => [
          'callback' => 'absint' ],
      'post_author'           => [
          'callback' => 'absint' ],
      'post_date'             => [
          'validate' => 'is_date',
          'default'  => '0000-00-00 00:00:00' ],
      'post_date_gmt'         => [
          'validate' => 'is_date',
          'default'  => '0000-00-00 00:00:00' ],
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
          'validate' => 'is_date',
          'default'  => '0000-00-00 00:00:00' ],
      'post_modified_gmt'     => [
          'validate' => 'is_date',
          'default'  => '0000-00-00 00:00:00' ],
      'post_content_filtered' => [
          'callback' => 'trim' ],
      'post_parent'           => [
          'callback' => 'absint' ],
      'guid'                  => [
          'callback' => 'trim' ],
      'menu_order'            => [
          'callback' => 'intval' ],
      'post_type'             => [
          'callback' => 'trim',
          'values'   => [] ],
      'post_mime_type'        => [
          'callback' => 'trim' ],
      'comment_count'         => [
          'callback' => 'absint' ],
  ];

  /**
   * Stores the post data ready to import
   *
   * @since          1.0.0
   * @var type
   */
  private $data = [];

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

    $this->default = apply_filters( 'source_framework_post_import_default', $this->default );
    $this->filter  = apply_filters( 'source_framework_post_import_filter', $this->filter );

    parent::__construct();
  }

  /**
   * Output header html.
   *
   * @since          1.0.0
   */
  public function header() {
    echo Tag::open( 'div.wrap' );
    echo Tag::html( 'h2', __( 'CSV Post Importer', \SourceFramework\TEXTDOMAIN ) );
  }

  /**
   * Output footer html.
   *
   * @since          1.0.0
   */
  public function footer() {
    echo Tag::close( 'div' );
  }

  /**
   *
   * @since          1.0.0
   */
  public function greet() {
    $http_query['import'] = filter_input( INPUT_GET, 'import', FILTER_SANITIZE_STRING );
    $action               = get_admin_url( null, '/admin.php?' . http_build_query( $http_query ) );
    echo Tag::open( 'form#import-upload-form', [ 'enctype' => 'multipart/form-data', 'method' => 'post', 'action' => $action ] );
    echo Tag::close( 'form' );
  }

  /**
   * @since          1.0.0
   */
  public function dispatch() {
    $this->header();
    $this->greet();
    $this->footer();
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
   * Bump up the request timeout for http requests
   *
   * @param int $val
   * @return int
   */
  public function bump_request_timeout( $val = 60 ) {
    return (int) $val;
  }

}
