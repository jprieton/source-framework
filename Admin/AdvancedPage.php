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
 * AdvancedPage class
 *
 * @package        Admin
 * @subpackage     SettingPages
 * @since          1.0.0
 * @author         Javier Prieto <jprieton@gmail.com>
 */
final class AdvancedPage extends SettingPage {

  /**
   * Constructor
   *
   * @since 1.0.0
   */
  public function __construct() {
    $this->title = __( 'Advanced Settings', \SourceFramework\TEXTDOMAIN );
    parent::__construct( 'source-framework', 'source-framework-advanced' );
    $this->add_submenu_page( __( 'Advanced', \SourceFramework\TEXTDOMAIN ), __( 'Advanced', \SourceFramework\TEXTDOMAIN ), 'activate_plugins' );
  }

  /**
   * enable_cli_commands
   */

}
