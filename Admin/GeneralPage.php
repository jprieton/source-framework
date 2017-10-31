<?php

namespace SourceFramework\Admin;

/**
 * If this file is called directly, abort.
 */
if ( !defined( 'ABSPATH' ) ) {
  die( 'Direct access is forbidden.' );
}

use SourceFramework\Abstracts\SettingPage;

/**
 * AboutPage class
 *
 * @package        Admin
 * @subpackage     SettingPages
 * @since          1.0.0
 * @author         Javier Prieto <jprieton@gmail.com>
 */
final class GeneralPage extends SettingPage {

  /**
   * Constructor
   *
   * @since 1.0.0
   */
  public function __construct() {

    $enabled = apply_filters( 'source_framework_enable_general_page', true );

    if ( $enabled ) {
      $this->title = __( 'General Settings', \SourceFramework\TEXTDOMAIN );
      parent::__construct( 'source-framework', 'source-framework' );
      $this->add_menu_page( __( 'General Settings', \SourceFramework\TEXTDOMAIN ), 'SourceFramework', 'activate_plugins' );
      $this->add_submenu_page( __( 'General', \SourceFramework\TEXTDOMAIN ), __( 'General', \SourceFramework\TEXTDOMAIN ), 'activate_plugins' );
    }
  }

}
