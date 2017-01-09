<?php

/**
 * If this file is called directly, abort.
 */
if ( !defined( 'ABSPATH' ) ) {
  die( 'Direct access is forbidden.' );
}

function load_helper( $helper = '' ) {
  $filename  = "class-{$helper}.php";
  $classname = ucwords( $helper );
  if ( file_exists( $filename ) && !class_exists( "\SourceFramework\Core\Helpers\{$classname}" ) ) {
    include_once $filename;
  }
}
