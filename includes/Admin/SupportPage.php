<?php

namespace SourceFramework\Admin;

// If this file is called directly, abort.
if ( !defined( 'ABSPATH' ) ) {
  die( 'Direct access is forbidden.' );
}

use SourceFramework\Abstracts\MenuPage;

/**
 * AboutPage class
 *
 * @package        SourceFramework
 * @subpackage     Admin
 * @since          1.0.0
 * @author         Javier Prieto
 */
final class SupportPage extends MenuPage {

  /**
   * Constructor
   *
   * @since 1.0.0
   */
  public function __construct() {
    $this->title = __( 'Support', SF_TEXTDOMAIN );
    parent::__construct( 'source-framework', 'source-framework' );
    $this->add_menu_page( __( 'Support', SF_TEXTDOMAIN ), 'SourceFramework', 'activate_plugins' );
    $this->add_submenu_page( __( 'Support', SF_TEXTDOMAIN ), __( 'Support', SF_TEXTDOMAIN ), 'activate_plugins' );
  }

}
