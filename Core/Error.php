<?php

namespace SourceFramework\Core;

/**
 * If this file is called directly, abort.
 */
if ( !defined( 'ABSPATH' ) ) {
  die( 'Direct access is forbidden.' );
}

use WP_Error;

/**
 * Error class
 *
 * Shorthands for common errors messages
 *
 * @package        Core
 * @since          1.1.0
 * @author         Javier Prieto <jprieton@gmail.com>
 */
class Error {

  /**
   * @since          1.1.0
   *
   * @param mixed $data
   * @return WP_Error
   */
  public static function action_not_supported( $data = '' ) {
    return new WP_Error( 'action_not_supported', __( "This action isn't supported", \SourceFramework\TEXTDOMAIN ), $data );
  }

  /**
   * @since          1.1.0
   *
   * @param mixed $data
   * @return WP_Error
   */
  public static function user_not_authenticated( $data = '' ) {
    return new WP_Error( 'user_not_authenticated', __( 'You must logged in to perform this action', \SourceFramework\TEXTDOMAIN ), $data );
  }

}
