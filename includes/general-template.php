<?php

/**
 * If this file is called directly, abort.
 */
if ( !defined( 'ABSPATH' ) ) {
  die( 'Direct access is forbidden.' );
}

/**
 * Fire the wp_body action.
 *
 * @since 1.0.0
 */
function wp_body() {
  /**
   * Prints scripts or data in the body tag on the front end.
   *
   * @since 1.0.0
   */
  do_action( 'wp_body' );
}
