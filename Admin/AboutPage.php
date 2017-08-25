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
final class AboutPage extends SettingPage {

  /**
   * Constructor
   *
   * @since 1.0.0
   */
  public function __construct() {
    $this->title = __( 'About SourceFramework', \SourceFramework\TEXTDOMAIN );
    parent::__construct( 'source-framework', 'source-framework-about' );
    $this->add_submenu_page( __( 'About', \SourceFramework\TEXTDOMAIN ), __( 'About', \SourceFramework\TEXTDOMAIN ), 'activate_plugins' );
  }

}
