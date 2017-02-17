<?php

namespace SourceFramework\Core\Factory;

/**
 * If this file is called directly, abort.
 */
if ( !defined( 'ABSPATH' ) ) {
  die( 'Direct access is forbidden.' );
}

require_once './class-option-group.php';

use SourceFramework\Core\OptionGroup;

/**
 * Factory class for Option_Group
 *
 * @package        Core
 * @subpackage     Factory
 *
 * @since          1.0.0
 *
 * @author         Javier Prieto <jprieton@gmail.com>
 */
class Setting_Factory {

  /**
   * Register a setting group and add filter
   *
   * @since    1.0.0
   *
   * @param    string    $option_group
   */
  public static function register_option_group( $option_group ) {
    $option_group_object = self::setting_group( $option_group );
    add_action( 'admin_init', array( $option_group_object, 'register_setting' ) );
    add_filter( "pre_update_option_{$option_group}", array( $option_group_object, 'pre_update_option' ), 10, 2 );
  }

  /**
   * Creates and returns an SettingGroup object
   *
   * @since    1.0.0
   *
   * @param    string    $option_group
   *
   * @return             Option_Group
   */
  public static function option_group( $option_group ) {
    return new Option_Group( $option_group );
  }

}
