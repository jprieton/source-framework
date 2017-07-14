<?php

namespace SourceFramework\Core;

/**
 * If this file is called directly, abort.
 */
if ( !defined( 'ABSPATH' ) ) {
  die( 'Direct access is forbidden.' );
}

use WP_Importer;
use SourceFramework\Template\Tag;

/**
 * CSV PostImporter class
 *
 * @package        Data
 * @since          1.0.0
 * @author         Javier Prieto <jprieton@gmail.com>
 */
class PostImporter extends WP_Importer {

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
   * Bump up the request timeout for http requests
   *
   * @since          1.0.0
   * 
   * @param int $val
   * @return int
   */
  public function bump_request_timeout( $val = 60 ) {
    return (int) $val;
  }

}
