<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace SourceFramework\Settings;

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
