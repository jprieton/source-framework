<?php

namespace SourceFramework\Core;

/**
 * If this file is called directly, abort.
 */
if ( !defined( 'ABSPATH' ) ) {
  die( 'Direct access is forbidden.' );
}

/**
 * Option_Group class
 *
 * @package Core
 * @since 1.0.0
 * @author jprieton
 */
class Option_Group {

  /**
   * Setting group name
   *
   * @since 1.0.0
   *
   * @var   string
   */
  protected $option_group = '';

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
   * @param   string    $option_group
   */
  public function __construct( $option_group ) {
    $this->option_group = trim( $option_group );
    $this->options      = (array) get_option( $this->option_group, array() );
  }

  /**
   * PHP5 style destructor and will run when object is destroyed.
   *
   * @since   1.0.0
   * @return  true
   */
  public function __destruct() {
    return true;
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

    return update_option( $this->option_group, $this->options );
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
    $response = isset( $this->options[$option] ) ? $this->options[$option] : $default;

    return $response;
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

    return (bool) in_array( $value, array( 'Y', 'y', 'yes', 'true', '1' ) );
  }

  /**
   * Get float option value in option group.
   *
   * @since   1.0.0
   *
   * @param   string    $option   Name of option to retrieve. Expected to not be SQL-escaped.
   * @param   float     $default  Optional. Default value to return if the option does not exist.
   *
   * @return  float
   */
  public function get_float_option( $option, $default = 0 ) {
    return floatval( $this->get_option( $option, $default ) );
  }

  /**
   * Get integer option value in option group.
   *
   * @since   1.0.0
   *
   * @param   string    $option   Name of option to retrieve. Expected to not be SQL-escaped.
   * @param   integer   $default  Optional. Default value to return if the option does not exist.
   *
   * @return  integer
   */
  public function get_int_option( $option, $default = 0 ) {
    return intval( $this->get_option( $option, $default ) );
  }

  /**
   * Get non-negative integer option value in option group.
   *
   * @since   1.0.0
   *
   * @param   string    $option   Name of option to retrieve. Expected to not be SQL-escaped.
   * @param   integer   $default  Optional. Default value to return if the option does not exist.
   *
   * @return  integer
   */
  public function get_absint_option( $option, $default = 0 ) {
    return absint( $this->get_option( $option, $default ) );
  }

  /**
   * Get integer option value in option group.
   *
   * @since   1.0.0
   *
   * @param   string    $option   Name of option to retrieve. Expected to not be SQL-escaped.
   * @param   integer   $default  Optional. Default value to return if the option does not exist.
   *
   * @return  integer
   */
  public function get_array_option( $option, $default = array() ) {
    return (array) $this->get_option( $option, $default );
  }

  /**
   * Merge options before saving
   *
   * @since   1.0.0
   *
   * @param   array     $new_value
   * @param   array     $old_value
   * @return  array
   */
  public function pre_update_option( $new_value ) {
    if ( is_serialized( $new_value ) ) {
      $new_value = unserialize( $new_value );
    }

    $this->options = array_merge( $this->options, (array) $new_value );
    $this->options = $this->_clean_options( $this->options );
    return $this->options;
  }

  /**
   * Clean empty or _unset_ options
   *
   * @since   1.0.0
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

  /**
   * Register a setting. Must be called in admin_init hook.
   *
   * @since   1.0.0
   */
  public function register_setting() {
    register_setting( $this->option_group, $this->option_group );
  }

}
