<?php

namespace SourceFramework\Core;

// If this file is called directly, abort.
if ( !defined( 'ABSPATH' ) ) {
  die( 'Direct access is forbidden.' );
}

use WP_Error;

/**
 * Error class
 *
 * Shorthands for predefined errors messages
 *
 * @package       SourceFramework
 * @subpackage    Error
 * @since         1.1.0
 * @author        Javier Prieto
 */
class Error_Message {

  /**
   * Error "Action not supported"
   *
   * @since   1.1.0
   * @param   mixed     $data      Optional. Error data.
   * @return  WP_Error
   */
  public static function action_not_supported( $data = '' ) {
    return new WP_Error( 'action_not_supported', __( "This action isn't supported.", SF_TEXTDOMAIN ), $data );
  }

  /**
   * Error "Action disabled"
   *
   * @since   1.1.0
   * @param   mixed     $data      Optional. Error data.
   * @return  WP_Error
   */
  public static function action_disabled( $data = '' ) {
    return new WP_Error( 'action_disabled', __( 'This action is disabled.', SF_TEXTDOMAIN ), $data );
  }

  /**
   * Error "User not authenticated"
   *
   * @since   1.1.0
   * @param   mixed     $data     Optional. Error data.
   * @return  WP_Error
   */
  public static function user_not_authenticated( $data = '' ) {
    return new WP_Error( 'user_not_authenticated', __( 'You must logged in to perform this action.', SF_TEXTDOMAIN ), $data );
  }

  /**
   * Error "User not authorized"
   *
   * @since   1.1.0
   * @param   mixed     $data     Optional. Error data.
   * @return  WP_Error
   */
  public static function user_not_authorized( $data = '' ) {
    return new WP_Error( 'user_not_authorized', __( 'You are not authorized to perform this action.', SF_TEXTDOMAIN ), $data );
  }

  /**
   * Error "Invalid data"
   *
   * @since 1.1.0
   *
   * @return WP_Error
   */
  public static function invalid_data( $data = '' ) {
    return new WP_Error( 'invalid_data', __( 'The data that you entered is invalid.', SF_TEXTDOMAIN ), $data );
  }

}
