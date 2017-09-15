<?php

namespace SourceFramework\Data;

/**
 * If this file is called directly, abort.
 */
if ( !defined( 'ABSPATH' ) ) {
  die( 'Direct access is forbidden.' );
}

/**
 * Input class
 *
 * @package        Data
 * @since          1.1.0
 * @author         Javier Prieto <jprieton@gmail.com>
 */
class Input {

  /**
   * Return $_GET parameter
   *
   * @since          1.1.0
   *
   * @see http://php.net/manual/es/filter.filters.php
   *
   * @param string $field
   * @param mixed $default
   * @param array $args
   *
   * @return string
   */
  public static function get( $field, $default = '', $args = [] ) {
    $defaults = [
        'filter'   => FILTER_SANITIZE_STRING,
        'callback' => [ 'sanitize_text_field' ],
        'options'  => []
    ];
    $args     = wp_parse_args( $args, $defaults );
    $value    = filter_input( INPUT_GET, $field, $args['filter'], $args['options'] );

    if ( empty( $value ) ) {
      return $default;
    }

    if ( !empty( $args['callback'] ) ) {
      $value = self::_callback( $value, $args['callback'] );
    }

    return $value;
  }

  /**
   * Return $_POST parameter
   *
   * @since          1.1.0
   *
   * @see http://php.net/manual/es/filter.filters.php
   *
   * @param string $field
   * @param mixed $default
   * @param array $args
   *
   * @return string
   */
  public static function post( $field, $default = '', $args = [] ) {
    $defaults = [
        'filter'   => FILTER_SANITIZE_STRING,
        'callback' => [ 'sanitize_text_field' ],
        'options'  => []
    ];
    $args     = wp_parse_args( $args, $defaults );
    $value    = filter_input( INPUT_POST, $field, $args['filter'], $args['options'] );

    if ( empty( $value ) ) {
      return $default;
    }

    if ( !empty( $args['callback'] ) ) {
      $value = self::_callback( $value, $args['callback'] );
    }

    return $value;
  }

  /**
   * Return $_SERVER parameter
   *
   * @since          1.1.0
   *
   * @see http://php.net/manual/es/filter.filters.php
   *
   * @param string $field
   * @param mixed $default
   * @param array $args
   *
   * @return string
   */
  public static function server( $field, $default = '', $args = [] ) {
    $defaults = [
        'filter'   => FILTER_SANITIZE_STRING,
        'callback' => [ 'sanitize_text_field' ],
        'options'  => []
    ];
    $args     = wp_parse_args( $args, $defaults );
    $value    = filter_input( INPUT_SERVER, $field, $args['filter'], $args['options'] );

    if ( empty( $value ) ) {
      return $default;
    }

    if ( !empty( $args['callback'] ) ) {
      $value = self::_callback( $value, $args['callback'] );
    }

    return $value;
  }

  /**
   * Return $_COOKIE parameter
   *
   * @since          1.1.0
   *
   * @see http://php.net/manual/es/filter.filters.php
   *
   * @param string $field
   * @param mixed $default
   * @param array $args
   *
   * @return string
   */
  public static function cookie( $field, $default = '', $args = [] ) {
    $defaults = [
        'filter'   => FILTER_SANITIZE_STRING,
        'callback' => [ 'sanitize_text_field' ],
        'options'  => []
    ];
    $args     = wp_parse_args( $args, $defaults );
    $value    = filter_input( INPUT_COOKIE, $field, $args['filter'], $args['options'] );

    if ( empty( $value ) ) {
      return $default;
    }

    if ( !empty( $args['callback'] ) ) {
      $value = self::_callback( $value, $args['callback'] );
    }

    return $value;
  }

  /**
   * Executes the filter callbacks
   *
   * @since          1.1.0
   *
   * @param string $value
   * @param array $callable
   *
   * @return string
   */
  private static function _callback( $value, $callable = [] ) {
    foreach ( (array) $callable as $callback ) {
      if ( is_callable( $callback ) ) {
        $value = call_user_func( $callback, $value );
      }
    }
    return $value;
  }

}
