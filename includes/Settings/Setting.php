<?php

namespace SourceFramework\Settings;

// If this file is called directly, abort.
if ( !defined( 'ABSPATH' ) ) {
  die( 'Direct access is forbidden.' );
}

/**
 * Setting class
 *
 * @author         Javier Prieto <jprieton@gmail.com>
 * @package        SourceFramework
 * @subpackage     Settings
 * @since          1.0.0
 */
class Setting {

  /**
   * Retrieves an option boolean value based on an option name.
   *
   * @since     1.0.0
   * @param     string    $option
   * @param     bool      $default
   * @return    bool      Default value if the option doesn't exists
   */
  public static function get_bool_option( $option, $default = false ) {
    $value = get_option( $option, $default );
    return (bool) in_array( strtolower( $value ), [ 'yes', 'true', '1' ] );
  }

  /**
   * Retrieves an option integer value based on an option name.
   *
   * @since     1.0.0
   * @param     string    $option
   * @param     int       $default
   * @return    int       Default value if the option doesn't exists
   */
  public static function get_int_option( $option, $default = 0 ) {
    $option = get_option( $option, $default );
    return intval( $option );
  }

  /**
   * Retrieves an option float value based on an option name.
   *
   * @since     1.0.0
   * @param     string    $option
   * @param     float       $default
   * @return    float       Default value if the option doesn't exists
   */
  public static function get_float_option( $option, $default = 0 ) {
    $option = get_option( $option, $default );
    return floatval( $option );
  }

  /**
   * Retrieves an option absolute numeric value based on an option name.
   *
   * @since     1.0.0
   * @param     string      $option
   * @param     int|float   $default
   * @return    int|float   Default value if the option doesn't exists
   */
  public static function get_abs_option( $option, $default = 0 ) {
    $option = get_option( $option, $default );
    return abs( $option );
  }

  /**
   * Retrieves an option absolute integer value based on an option name.
   *
   * @since     1.0.0
   * @param     string    $option
   * @param     int       $default
   * @return    int       Default value if the option doesn't exists
   */
  public static function get_absint_option( $option, $default = 0 ) {
    $option = get_option( $option, $default );
    return absint( $option );
  }

}
