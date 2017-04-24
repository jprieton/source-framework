<?php

/**
 * If this file is called directly, abort.
 */
if ( !defined( 'ABSPATH' ) ) {
  die( 'Direct access is forbidden.' );
}

/**
 * Returns an value from an variable, if the value is empty return the default value
 *
 * @since  1.0.0
 *
 * @param  array  $var
 * @param  mixed  $default
 * @return mixed  Default value if the variable is empty
 */
function maybe_empty( $var, $default = null ) {
  if ( !empty( $var ) ) {
    return $var;
  } else {
    return $default;
  }
}

/**
 * Returns an index value from an array, if the index doesn't exists return the default value
 *
 * @since  1.0.0
 *
 * @param  array  $array
 * @param  mixed  $key
 * @param  mixed  $default
 * @return mixed  Default value if the index doesn't exists
 */
function array_value( $array, $key, $default = null ) {
  if ( is_array( $array ) && isset( $array[$key] ) ) {
    return $array[$key];
  } else {
    return $default;
  }
}

/**
 * Returns an index value from an array, if the value is empty return the default value
 *
 * @since  1.0.0
 *
 * @param  array  $array
 * @param  mixed  $key
 * @param  mixed  $default
 * @return mixed  Default value if the index doesn't exists
 */
function array_value_maybe_empty( $array, $key, $default = null ) {
  if ( is_array( $array ) && !empty( $array[$key] ) ) {
    return $array[$key];
  } else {
    return $default;
  }
}

/**
 * Returns an index value from an array and it's removed, if the index doesn't exists return the default value
 *
 * @since  1.0.0
 *
 * @param  array  $array
 * @param  mixed  $key
 * @param  mixed  $default
 * @return mixed  Default value if the index doesn't exists
 */
function array_remove( &$array, $key, $default = null ) {
  if ( is_array( $array ) && isset( $array[$key] ) ) {
    $value = $array[$key];
    unset( $array[$key] );
    return $value;
  } else {
    return $default;
  }
}

/**
 * Returns an index value from an array and it's removed, if the index doesn't exists return the default value
 *
 * @since  1.0.0
 *
 * @param  array  $array
 * @param  mixed  $key
 * @param  mixed  $default
 * @return mixed  Default value if the index doesn't exists
 */
function array_remove_maybe_empty( &$array, $key, $default = null ) {
  if ( is_array( $array ) && isset( $array[$key] ) ) {
    $value = !empty( $array[$key] ) ? $array[$key] : $default;
    unset( $array[$key] );
    return $value;
  } else {
    return $default;
  }
}

/**
 * Retrieves an option boolean value based on an option name.
 *
 * @since 1.0.0
 *
 * @param  string  $option
 * @param  bool    $default
 * @return bool    Default value if the option doesn't exists
 */
function get_bool_option( $option, $default = false ) {
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
function get_int_option( $option, $default = 0 ) {
  $option = get_option( $option, $default );
  return intval( $option );
}

/**
 * Define a constant if it is not already defined.
 *
 * @since  1.0.0
 *
 * @param  string  $name
 * @param  string  $value
 */
function define_maybe_defined( $name, $value, $case_insensitive = false ) {
  if ( !defined( $name ) ) {
    define( $name, $value, $case_insensitive );
  }
}
