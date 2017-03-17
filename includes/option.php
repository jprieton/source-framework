<?php

/**
 * If this file is called directly, abort.
 */
if ( !defined( 'ABSPATH' ) ) {
  die( 'Direct access is forbidden.' );
}

/**
 * Retrieves an option boolean value based on an option name.
 *
 * @since 1.0.0
 *
 * @param string $option
 * @param bool $default
 * @return bool
 */
function get_bool_option( $option, $default = false ) {
  $option = get_option( $option, $default );
  return (bool) (strtolower( $option ) === 'yes' || $option === true);
}

/**
 * Retrieves an option integer value based on an option name.
 *
 * @since 1.0.0
 *
 * @param string $option
 * @param int $default
 * @return int
 */
function get_int_option( $option, $default = 0 ) {
  $option = get_option( $option, $default );
  return intval( $option );
}
