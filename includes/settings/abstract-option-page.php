<?php

namespace SourceFramework\Abstracts;

/**
 * If this file is called directly, abort.
 */
if ( !defined( 'ABSPATH' ) ) {
  die( 'Direct access is forbidden.' );
}

use SourceFramework\Html\Tag;

abstract class Option_Page {

  public function add_options_page( $page_title, $menu_title, $capability, $menu_slug ) {

  }

}
