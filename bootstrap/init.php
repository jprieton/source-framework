<?php

/**
 * If this file is called directly, abort.
 */
if ( !defined( 'ABSPATH' ) ) {
  die( 'Direct access is forbidden.' );
}

if ( !get_bool_option( 'bootstrap_enabled' ) ) {
  return;
}

require_once SourceFramework\ABSPATH . '/bootstrap/class-bootstrap-init.php';
require_once SourceFramework\ABSPATH . '/bootstrap/general-template.php';
