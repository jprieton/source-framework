<?php

namespace SourceFramework\Settings;

/**
 * If this file is called directly, abort.
 */
if ( !defined( 'ABSPATH' ) ) {
  die( 'Direct access is forbidden.' );
}

/**
 * SettingGroup class
 *
 * @package        SourceFramework
 * @subpackage     Settings
 *
 * @since          1.0.0
 *
 * @author         Javier Prieto <jprieton@gmail.com>
 */
class SettingGroup {

  /**
   * Setting group name
   *
   * @since 1.0.0
   *
   * @var   string
   */
  public $setting_group_name = '';

  /**
   * Option data
   *
   * @since   1.0.0
   *
   * @var     array
   */
  protected $options = array();

  /**
   * Constructor
   *
   * @since   1.0.0
   *
   * @param   string    $setting_group
   */
  public function __construct( $setting_group ) {
    $this->setting_group_name = trim( $setting_group );
    $this->options            = (array) get_option( $this->setting_group_name, array() );
    add_action( 'admin_init', array( &$this, 'register_setting' ) );
  }

  /**
   * Set option value in group option
   *
   * @since   1.0.0
   *
   * @param   string    $option   Name of option to set. Expected to not be SQL-escaped.
   * @param   mixed     $value    Option value. Must be serializable if non-scalar. Expected to not be SQL-escaped.
   *
   * @return  bool
   */
  public function set_option( $option, $value ) {
    $this->options[$option] = $value;

    return update_option( $this->setting_group_name, $this->options );
  }

  /**
   * Get option value in option group.
   *
   * @since   1.0.0
   *
   * @param   string    $option   Name of option to retrieve. Expected to not be SQL-escaped.
   * @param   mixed     $default  Optional. Default value to return if the option does not exist.
   *
   * @return  mixed
   */
  public function get_option( $option, $default = false ) {
    $value = isset( $this->options[$option] ) ? $this->options[$option] : $default;
    return $value;
  }

  /**
   * Get boolean option value in option group.
   *
   * @since   1.0.0
   *
   * @param   string    $option   Name of option to retrieve. Expected to not be SQL-escaped.
   * @param   boolean   $default  Optional. Default value to return if the option does not exist.
   *
   * @return  boolean
   */
  public function get_bool_option( $option, $default = false ) {
    $value = $this->get_option( $option, $default );
    return (bool) (strtolower( $value ) === 'yes' || $value === true || $value == '1');
  }

  /**
   * Get integer option value in option group.
   *
   * @since   1.0.0
   *
   * @param   string    $option   Name of option to retrieve. Expected to not be SQL-escaped.
   * @param   int       $default  Optional. Default value to return if the option does not exist.
   *
   * @return  int
   */
  public function get_int_option( $option, $default = 0 ) {
    $value = $this->get_option( $option, $default );

    if ( !is_numeric( $value ) ) {
      $value = $default;
    }

    return (int) $value;
  }

  /**
   * Merge options before saving
   *
   * @since   1.0.0
   *
   * @param   array     $new_value
   * @return  array
   */
  public function pre_update_option( $new_value ) {
    if ( is_serialized( $new_value ) ) {
      $new_value = unserialize( $new_value );
    }

    $this->options = array_merge( $this->options, (array) $new_value );

    foreach ( $this->options as $key => $value ) {
      if ( is_array( $value ) ) {
        $this->options[$key] = $this->_clean_options( $value );
      }

      if ( empty( $value ) || $value == '_unset_' ) {
        unset( $this->options[$key] );
      }
    }

    return $this->options;
  }

  /**
   * Register a setting. Must be called in admin_init hook.
   *
   * @since   1.0.0
   */
  public function register_setting() {
    register_setting( $this->setting_group_name, $this->setting_group_name, [ $this, 'pre_update_option' ] );
  }

  /**
   * Clean empty or _unset_ options
   *
   * @since   0.5.0
   *
   * @param   array     $new_value
   * @return  array
   */
  private function _clean_options( $new_value ) {
    foreach ( $new_value as $key => $value ) {
      if ( is_array( $value ) ) {
        $new_value[$key] = $this->_clean_options( $value );
      }

      if ( empty( $value ) || $value == '_unset_' ) {
        unset( $new_value[$key] );
      }
    }
    return $new_value;
  }

}
