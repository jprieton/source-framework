<?php

namespace SourceFramework\Ajax;

// If this file is called directly, abort.
if ( !defined( 'ABSPATH' ) ) {
  die( 'Direct access is forbidden.' );
}

use SourceFramework\Data\Input;
use SourceFramework\Core\Error_Message;
use WP_Error;

/**
 * User_Actions class
 *
 * @package        SourceFramework
 * @subpackage     Ajax
 * @since          2.0.0
 * @author         Javier Prieto
 */
class User_Actions {

  /**
   * Enables the password change for authenticated users via ajax
   *
   * @since          2.0.0
   */
  public static function change_password() {
    if ( defined( 'WP_DEBUG' ) && WP_DEBUG && defined( 'SF_AJAX_DEBUG' ) && SF_AJAX_DEBUG ) {
      error_reporting( E_ALL );
      ini_set( 'display_errors', 1 );
    }

    $user_id = get_current_user_id();
    if ( empty( $user_id ) ) {
      wp_send_json_error( Error_Message::user_not_authenticated() );
    }

    $verify_nonce = Input::verify_wpnonce( 'user_change_password' );
    if ( !$verify_nonce ) {
      wp_send_json_error( Error_Message::user_not_authorized() );
    }

    $new_password = Input::post( 'new_password' );
    if ( empty( $new_password ) ) {
      wp_send_json_error( Error_Message::invalid_data() );
    }

    // Hook before change password
    do_action( 'before_user_change_password', compact( 'user_id', 'new_password' ) );

    wp_set_password( $new_password, $user_id );

    $data = array(
        'code'    => 'user_change_password_success',
        'message' => __( 'Password successfully updated.', SF_TEXTDOMAIN ),
    );
    wp_send_json_success( [ $data ] );
  }

  /**
   * Enables to user authenticate via ajax
   *
   * @since          2.0.0
   */
  public static function authenticate() {
    if ( defined( 'WP_DEBUG' ) && WP_DEBUG && defined( 'SF_AJAX_DEBUG' ) && SF_AJAX_DEBUG ) {
      error_reporting( E_ALL );
      ini_set( 'display_errors', 1 );
    }

    $verify_nonce = Input::verify_wpnonce( 'user_authenticate' );
    if ( !$verify_nonce ) {
      wp_send_json_error( Error_Message::user_not_authorized() );
    }

    $credentials = [
        'user_login'    => Input::post( 'user_login' ),
        'user_password' => Input::post( 'user_password' ),
        'remember'      => Input::post( 'remember' ),
    ];

    // Hook before change password
    do_action( 'before_user_authenticate', $credentials );

    $response = wp_signon( $credentials );

    // Hook after change password
    do_action( 'after_user_authenticate', $response, $credentials );

    if ( is_wp_error( $response ) ) {
      // Overrides the default response
      $data = new WP_Error( 'user_authenticate_error', __( 'Your username or password are incorrect.', SF_TEXTDOMAIN ) );
      wp_send_json_error( $data );
    } else {
      $data = array(
          'code'    => 'user_authenticate_success',
          'message' => __( 'You have successfully logged in.', SF_TEXTDOMAIN ),
      );
      wp_send_json_success( [ $data ] );
    }
  }

}
