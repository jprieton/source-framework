<?php

/**
 * If this file is called directly, abort.
 */
if ( !defined( 'ABSPATH' ) ) {
  die( 'Direct access is forbidden.' );
}

/**
 * Load a helper
 *
 * @since 1.0.0
 *
 * @param   string   $helper    Helper name
 *
 * @return  mixed
 */
function load_helper( $helper = '' ) {
  $paths = array(
      SourceFramework\ABSPATH . '/helpers',
  );

  $helper = strtolower( $helper );

  foreach ( $paths as $path ) {
    if ( file_exists( $filename = "{$path}/{$helper}.php" ) ) {
      include_once $filename;
    }

    if ( file_exists( $filename = "{$path}/class-{$helper}.php" ) ) {
      include_once $filename;
    }
  }
}
