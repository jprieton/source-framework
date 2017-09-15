<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace SourceFramework\Core;

/**
 * User class
 *
 * @package        Core
 * @since          1.1.0
 * @author         Javier Prieto <jprieton@gmail.com>
 */
class User {

  /**
   * @since 1.1.0
   *
   * @param int $user_id
   */
  public static function block( $user_id ) {
    $user = get_user_by( 'id', (int) $user_id );

    if ( !empty( $user ) ) {
      update_user_meta( (int) $user_id, 'blocked', 'yes' );
    }
  }

  /**
   * @since 1.1.0
   *
   * @param int $user_id
   */
  public static function unblock( $user_id ) {
    delete_user_meta( (int) $user_id, 'blocked' );
  }

  /**
   * @since 1.1.0
   *
   * @param int $user_id
   *
   * @return bool
   */
  public static function is_blocked( $user_id ) {
    $blocked = false;
    $user    = get_user_by( 'id', (int) $user_id );

    if ( !empty( $user ) ) {
      $blocked = (get_user_meta( (int) $user_id, 'blocked', TRUE ) == 'yes');
    }

    return $blocked;
  }

  /**
   * @since 1.1.0
   *
   * @param int $user_id
   */
  public static function add_login_attemp( $user_id ) {
    $user = get_user_by( 'id', (int) $user_id );

    if ( !empty( $user ) ) {
      $login_attempts = (int) get_user_meta( (int) $user_id, 'login_attempts', TRUE );
      $login_attempts++;
      update_user_meta( (int) $user_id, 'login_attempts', $login_attempts );
    }
  }

  /**
   * @since 1.1.0
   *
   * @param int $user_id
   */
  public static function clear_login_attempts( $user_id ) {
    delete_user_meta( (int) $user_id, 'login_attempts' );
  }

}
