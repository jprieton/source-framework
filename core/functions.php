<?php

/**
 * If this file is called directly, abort.
 */
if ( !defined( 'ABSPATH' ) ) {
  die( 'Direct access is forbidden.' );
}

if ( !function_exists( 'maybe_define_constant' ) ) {

  /**
   * Define a constant if it is not already defined.
   *
   * @since  1.0.0
   * @param  string $name
   * @param  string $value
   */
  function maybe_define_constant( $name, $value ) {
    if ( !defined( $name ) ) {
      define( $name, $value );
    }
  }

}
