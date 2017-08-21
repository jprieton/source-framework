<?php

namespace SourceFramework\Settings;

/**
 * If this file is called directly, abort.
 */
if ( !defined( 'ABSPATH' ) ) {
  die( 'Direct access is forbidden.' );
}

/**
 * Setting class
 *
 * @package        SourceFramework
 * @subpackage     Settings
 *
 * @since          1.0.0
 *
 * @author         Javier Prieto <jprieton@gmail.com>
 */
class Setting {

  /**
   * Retrieves an option boolean value based on an option name.
   *
   * @since 1.0.0
   *
   * @param  string  $option
   * @param  bool    $default
   * @return bool    Default value if the option doesn't exists
   */
  public static function get_bool_option( $option, $default = false ) {
    $option = get_option( $option, $default );
    return (bool) (strtolower( $option ) === 'yes' || $option === true || $option == '1');
  }

  /**
   * Retrieves an option integer value based on an option name.
   *
   * @since  1.0.0
   *
   * @param  string  $option
   * @param  int     $default
   * @return int     Default value if the option doesn't exists
   */
  public static function get_int_option( $option, $default = 0 ) {
    $option = get_option( $option, $default );
    return intval( $option );
  }

}
