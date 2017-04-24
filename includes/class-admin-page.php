<?php

namespace SourceFramework\Core;

/**
 * If this file is called directly, abort.
 */
if ( !defined( 'ABSPATH' ) ) {
  die( 'Direct access is forbidden.' );
}

use SourceFramework\Helpers\Html;

/**
 * Admin_Init class
 *
 * @package        Core
 * @subpackage     Init
 * @since          1.0.0
 * @author         Javier Prieto <jprieton@gmail.com>
 */
class Admin_Page {

  public $page_title;

  public function __construct( $page_title, $menu_title, $capability, $menu_slug, $icon, $position ) {

  }

  public function add_menu_page() {

  }

  public function add_submenu_page() {

  }

  public function add_settings() {

  }

  public function render_page( $content = '' ) {
    $content = Html::tag( 'h2', $this->page_title ) . $content;
    echo Html::tag( 'div.wrap', $content );
  }

}
