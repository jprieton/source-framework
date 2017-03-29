<?php

/**
 * If this file is called directly, abort.
 */
if ( !defined( 'ABSPATH' ) ) {
  die( 'Direct access is forbidden.' );
}

/**
 * Checks if the user is blocked.
 *
 * @since 1.0.0
 *
 * @return bool True if user is blocked.
 */
function is_user_blocked( $user_id = null ) {

  if ( is_null( $user_id ) && is_user_logged_in() ) {
    $user_id = get_current_user_id();
  }

  if ( !is_int( $user_id ) || !ctype_digit( $user_id ) ) {
    return false;
  }

  $user_blocked = ('yes' == get_user_meta( (int) $user_id, 'blocked', true ));

  return $user_blocked;
}
