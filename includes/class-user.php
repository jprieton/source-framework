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
 * User class
 *
 * @package        Core
 * @since          1.0.0
 * @author         Javier Prieto <jprieton@gmail.com>
 */
class User {

  /**
   * Create an user
   *
   * @since 1.0.0
   */
  public function ajax_create_profile() {
    // Check if is enabled
    $users_can_register = get_bool_option( 'users_can_create_profile' );
    if ( !$users_can_register ) {
      wp_send_json_error( new WP_Error( 'user_create_profile_disabled', __( 'Action disabled', \SourceFramework\TEXTDOMAIN ) ) );
    }

    // Verify nonce
    $nonce        = filter_input( INPUT_POST, '_wpnonce', FILTER_SANITIZE_STRING );
    $verify_nonce = (bool) wp_verify_nonce( $nonce, 'user_create_profile' );
    if ( !$verify_nonce ) {
      wp_send_json_error( new WP_Error( 'action_disabled', __( 'Action disabled', \SourceFramework\TEXTDOMAIN ) ) );
    }

    // Get userdata
    $userdata = $this->_get_userdata();

    // If is enabled username add to $userdata
    $handle_username = get_bool_option( 'user_create_profile_handle_username', false );
    if ( $handle_username ) {
      $user_login = sanitize_user( filter_input( INPUT_POST, 'user_login', FILTER_SANITIZE_STRING ) );
      if ( empty( $user_login ) || !validate_username( $user_login ) ) {
        wp_send_json_error( new WP_Error( 'bad_user_login', __( 'Please enter a valid account username.', \SourceFramework\TEXTDOMAIN ) ) );
      }
      if ( username_exists( $user_login ) ) {
        wp_send_json_error( new WP_Error( 'user_login_exists', __( 'An account is already registered with that username. Please choose another.', \SourceFramework\TEXTDOMAIN ) ) );
      }
      $userdata['user_login'] = $user_login;
    } else {
      $userdata['user_login'] = $userdata['user_email'];
    }

    // If is enabled generate password
    $generate_password = get_bool_option( 'user_create_profile_generate_password', false );
    if ( $generate_password ) {
      $userdata['user_pass'] = wp_generate_password();
    } else {
      $userdata['user_pass'] = filter_input( INPUT_POST, 'user_pass', FILTER_SANITIZE_STRING );
    }
    if ( empty( $userdata['user_pass'] ) ) {
      wp_send_json_error( new WP_Error( 'empty_password', __( 'Empty password', \SourceFramework\TEXTDOMAIN ) ) );
    }

    // Confirm pass if isn't enabled generate password
    $user_pass_confirm = filter_input( INPUT_POST, 'user_pass_confirm', FILTER_SANITIZE_STRING );
    if ( !$generate_password && ($userdata['user_pass'] !== $user_pass_confirm) ) {
      wp_send_json_error( new WP_Error( 'password_error', __( 'Password does not match the confirm password.', \SourceFramework\TEXTDOMAIN ) ) );
    }

    // Filter $userdata
    $userdata = apply_filters( 'user_create_profile', $userdata );

    // Hook before the user is created
    do_action( 'before_user_create_profile', $userdata );

    // Create user
    $user_id = wp_insert_user( $userdata );

    // Hook after the user is created
    do_action( 'after_user_create_profile', $user_id, $userdata );

    if ( is_wp_error( $user_id ) ) {
      wp_send_json_error( $user_id );
    } else {
      $response = array(
          'code'    => 'user_created_successfully',
          'message' => __( 'User created successfully', \SourceFramework\TEXTDOMAIN )
      );
      wp_send_json_success( array( $response ) );
    }
  }

  /**
   * Update an user
   *
   * @since 1.0.0
   */
  public function ajax_update_profile() {
    // Check if is enabled
    $users_can_update = get_bool_option( 'users_can_update_profile' );
    if ( $users_can_update ) {
      wp_send_json_error( new WP_Error( 'user_update_profile_disabled', __( 'Action disabled', \SourceFramework\TEXTDOMAIN ) ) );
    }

    // Verify nonce
    $nonce        = filter_input( INPUT_POST, '_wpnonce', FILTER_SANITIZE_STRING );
    $verify_nonce = (bool) wp_verify_nonce( $nonce, 'user_update_profile' );
    if ( !$verify_nonce ) {
      wp_send_json_error( new WP_Error( 'action_disabled', __( 'Action disabled', \SourceFramework\TEXTDOMAIN ) ) );
    }

    // Get userdata
    $userdata       = $this->_get_userdata();
    $userdata['ID'] = get_current_user_id();

    // Check if password is updated
    $user_pass         = filter_input( INPUT_POST, 'user_pass', FILTER_SANITIZE_STRING );
    $user_pass_confirm = filter_input( INPUT_POST, 'user_pass_confirm', FILTER_SANITIZE_STRING );
    if ( !empty( $user_pass ) && $user_pass != $user_pass_confirm ) {
      wp_send_json_error( new WP_Error( 'password_error', __( 'Password does not match the confirm password.', \SourceFramework\TEXTDOMAIN ) ) );
    } elseif ( !empty( $user_pass ) && $user_pass == $user_pass_confirm ) {
      $userdata = array_merge( $userdata, compact( 'user_pass' ) );
    }

    // Filter $userdata
    $userdata = apply_filters( 'user_update_profile', $userdata );

    // Hook before the user is updated
    do_action( 'before_user_update_profile', $userdata );

    // Create user
    $user_id = wp_update_user( $userdata );

    // Hook after the user is updated
    do_action( 'after_user_update_profile', $user_id, $userdata );

    if ( is_wp_error( $user_id ) ) {
      wp_send_json_error( $user_id );
    } else {
      $response = array(
          'code'    => 'user_updated_successfully',
          'message' => __( 'User updated successfully', \SourceFramework\TEXTDOMAIN )
      );
      wp_send_json_success( array( $response ) );
    }
  }

  /**
   * Get userdata
   *
   * @since 1.0.0
   *
   * @return array
   */
  private function _get_userdata() {
    $userdata = array(
        'user_email' => sanitize_text_field( strtolower( filter_input( INPUT_POST, 'user_email', FILTER_SANITIZE_EMAIL ) ) ),
        'role'       => 'susbcriber'
    );

    if ( !is_email( $userdata['user_email'] ) ) {
      wp_send_json_error( new WP_Error( 'bad_user_email', __( 'Please provide a valid email address.', \SourceFramework\TEXTDOMAIN ) ) );
    }

    if ( email_exists( $userdata['user_email'] ) ) {
      wp_send_json_error( new WP_Error( 'user_email_exists', __( 'An account is already registered with your email address.', \SourceFramework\TEXTDOMAIN ) ) );
    }

    $first_name = sanitize_text_field( filter_input( INPUT_POST, 'first_name', FILTER_SANITIZE_STRING ) );
    if ( !empty( $first_name ) ) {
      $userdata = array_merge( $userdata, compact( 'first_name' ) );
    }

    $last_name = sanitize_text_field( filter_input( INPUT_POST, 'last_name', FILTER_SANITIZE_STRING ) );
    if ( !empty( $last_name ) ) {
      $userdata = array_merge( $userdata, compact( 'last_name' ) );
    }

    $user_nicename = sanitize_text_field( filter_input( INPUT_POST, 'user_nicename', FILTER_SANITIZE_STRING ) );
    if ( !empty( $user_nicename ) ) {
      $userdata = array_merge( $userdata, compact( 'user_nicename' ) );
    }

    $display_name = sanitize_text_field( filter_input( INPUT_POST, 'display_name', FILTER_SANITIZE_STRING ) );
    if ( !empty( $display_name ) ) {
      $userdata = array_merge( $userdata, compact( 'display_name' ) );
    }

    $nickname = sanitize_text_field( filter_input( INPUT_POST, 'nickname', FILTER_SANITIZE_STRING ) );
    if ( !empty( $nickname ) ) {
      $userdata = array_merge( $userdata, compact( 'nickname' ) );
    }

    $description = sanitize_textarea_field( filter_input( INPUT_POST, 'description', FILTER_SANITIZE_STRING ) );
    if ( !empty( $description ) ) {
      $userdata = array_merge( $userdata, compact( 'description' ) );
    }

    return $userdata;
  }

}
