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
 * ToolsPage class
 *
 * @package        Admin
 * @subpackage     SettingPages
 * @since          1.0.0
 * @author         Javier Prieto <jprieton@gmail.com>
 */
final class ToolsPage extends SettingPage {

  /**
   * Constructor
   *
   * @since 1.0.0
   */
  public function __construct() {
    $this->title = __( 'Tools', \SourceFramework\TEXTDOMAIN );
    parent::__construct( 'source-framework', 'source-framework-tools' );
    $this->add_submenu_page( __( 'Tools', \SourceFramework\TEXTDOMAIN ), __( 'Tools', \SourceFramework\TEXTDOMAIN ), 'activate_plugins' );
  }

  /**
   * enable_frontend_helper
   */

}
