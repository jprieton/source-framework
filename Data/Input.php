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
 * Access form data (POST, GET, SERVER, COOKIE)
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
   * @see https://developer.wordpress.org/reference/functions/sanitize_text_field/
   *
   * @param string|array $field
   * @param mixed $default
   * @param array $args
   *
   * @return mixed
   */
  public static function get( $field, $default = '', $args = [] ) {
    $defaults = [
        'filter'   => FILTER_SANITIZE_STRING,
        'callback' => [ 'sanitize_text_field' ],
        'options'  => []
    ];
    $args     = wp_parse_args( $args, $defaults );

    if ( is_array( $field ) ) {
      foreach ( $field as $_field ) {
        $value['field'] = self::get( $_field, $default, $args );
      }
    } else {
      $value = filter_input( INPUT_GET, $field, $args['filter'], $args['options'] );

      if ( empty( $value ) ) {
        return $default;
      }

      if ( !empty( $args['callback'] ) ) {
        $value = self::_callback( $value, $args['callback'] );
      }
    }

    return $value;
  }

  /**
   * Return $_POST parameter
   *
   * @since          1.1.0
   *
   * @see http://php.net/manual/es/filter.filters.php
   * @see https://developer.wordpress.org/reference/functions/sanitize_text_field/
   *
   * @param string|array $field
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

    if ( is_array( $field ) ) {
      foreach ( $field as $_field ) {
        $value['field'] = self::post( $_field, $default, $args );
      }
    } else {
      $value = filter_input( INPUT_POST, $field, $args['filter'], $args['options'] );

      if ( empty( $value ) ) {
        return $default;
      }

      if ( !empty( $args['callback'] ) ) {
        $value = self::_callback( $value, $args['callback'] );
      }
    }

    return $value;
  }

  /**
   * Return $_SERVER parameter
   *
   * @since          1.1.0
   *
   * @see http://php.net/manual/es/filter.filters.php
   * @see https://developer.wordpress.org/reference/functions/sanitize_text_field/
   *
   * @param string|array $field
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

    if ( is_array( $field ) ) {
      foreach ( $field as $_field ) {
        $value['field'] = self::server( $_field, $default, $args );
      }
    } else {
      $value = filter_input( INPUT_SERVER, $field, $args['filter'], $args['options'] );

      if ( empty( $value ) ) {
        return $default;
      }

      if ( !empty( $args['callback'] ) ) {
        $value = self::_callback( $value, $args['callback'] );
      }
    }

    return $value;
  }

  /**
   * Return $_COOKIE parameter
   *
   * @since          1.1.0
   *
   * @see http://php.net/manual/es/filter.filters.php
   * @see https://developer.wordpress.org/reference/functions/sanitize_text_field/
   *
   * @param string|array $field
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

    if ( is_array( $field ) ) {
      foreach ( $field as $_field ) {
        $value['field'] = self::cookie( $_field, $default, $args );
      }
    } else {
      $value = filter_input( INPUT_COOKIE, $field, $args['filter'], $args['options'] );

      if ( empty( $value ) ) {
        return $default;
      }

      if ( !empty( $args['callback'] ) ) {
        $value = self::_callback( $value, $args['callback'] );
      }
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

  /**
   * Is AJAX request?
   *
   * Test to see if a request contains the HTTP_X_REQUESTED_WITH header.
   *
   * @since          1.1.0
   *
   * @return 	bool
   */
  public function is_ajax_request() {
    return (self::server( 'HTTP_X_REQUESTED_WITH' ) === 'xmlhttprequest');
  }

  /**
   * Is CLI?
   *
   * Test to see if a request was made from the command line.
   *
   * @since          1.1.0
   *
   * @return 	bool
   */
  public function is_cli_request() {
    return (PHP_SAPI === 'cli' OR defined( 'STDIN' ));
  }

  /**
   * Get Request Method
   *
   * Return the request method
   *
   * @since          1.1.0
   *
   * @return 	string
   */
  public function method() {
    return self::server( 'REQUEST_METHOD' );
  }

  /**
   * Fetch User Agent string
   *
   * @since          1.1.0
   *
   * @return	string	User Agent string or empty if it doesn't exist
   */
  public function user_agent() {
    return self::server( 'HTTP_USER_AGENT' );
  }

  /**
   * Generate URL-encoded query string for method request
   *
   * @since          1.1.0
   *
   * @param string $method Request method
   * @param array $override Overrides method query data
   * @return string
   */
  public function query_string( $method = 'get', $override = [] ) {
    $method     = '_' . strtoupper( $method );
    $query_data = wp_parse_args( $override, ${$method} );
    return http_build_query( $query_data );
  }

}
