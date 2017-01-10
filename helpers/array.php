<?php

/**
 * If this file is called directly, abort.
 */
if ( !defined( 'ABSPATH' ) ) {
  die( 'Direct access is forbidden.' );
}

/**
 * Get item from an array and returns its value.
 *
 * @since 1.0.0
 *
 * @param   array    $array
 * @param   string   $key
 * @param   mixed    $default
 *
 * @return  mixed
 */
function array_get( $array, $key, $default = null ) {
  if ( is_array( $array ) && isset( $array[$key] ) ) {
    $value = $array[$key];
  } else {
    $value = $default;
  }

  return $value;
}

/**
 * Get item from an array if not empty and returns its value.
 *
 * @since 1.0.0
 *
 * @param   array    $array
 * @param   string   $key
 * @param   mixed    $default
 *
 * @return  mixed
 */
function array_get_not_empty( $array, $key, $default = null ) {
  if ( is_array( $array ) && !empty( $array[$key] ) ) {
    $value = $array[$key];
  } else {
    $value = $default;
  }

  return $value;
}

/**
 * Removes an item from an array and returns its value.
 *
 * @since 1.0.0
 *
 * @param   array    $array
 * @param   string   $key
 * @param   mixed    $default
 *
 * @return  mixed
 */
function array_get_remove( &$array, $key, $default = null ) {
  if ( is_array( $array ) && isset( $array[$key] ) ) {
    $value = $array[$key];
    unset( $array[$key] );
  } else {
    $value = $default;
  }

  return $value;
}
