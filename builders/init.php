<?php

/**
 * If this file is called directly, abort.
 */
if ( !defined( 'ABSPATH' ) ) {
  die( 'Direct access is forbidden.' );
}

/**
 * Load a builder
 *
 * @since 1.0.0
 *
 * @param   string   $builder    Builder name
 *
 * @return  mixed
 */
function load_builder( $builder = '' ) {
  $paths = array(
      SourceFramework\ABSPATH . '/builders',
  );

  $builder = str_replace( '_', '-', strtolower( $builder ) );

  $paths = apply_filters( 'source_framework_builder_paths', $paths );

  foreach ( $paths as $path ) {
    if ( file_exists( $filename = "{$path}/{$builder}.php" ) ) {
      include_once $filename;
    }

    if ( file_exists( $filename = "{$path}/class-{$builder}.php" ) ) {
      include_once $filename;
    }
  }
}
