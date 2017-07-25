<?php

namespace SourceFramework\Admin;

/**
 * If this file is called directly, abort.
 */
if ( !defined( 'ABSPATH' ) ) {
  die( 'Direct access is forbidden.' );
}

use SourceFramework\Abstracts\SettingPage;
use SourceFramework\Settings\SettingField;

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
    // CDN Section
    $this->general_section();
  }

  /**
   * Adds General setting section to Tools menu.
   *
   * @since 1.0.0
   */
  public function general_section() {
    $this->fields = new SettingField( 'source-framework', 'source-framework' );
    $this->add_setting_section( 'source-framework-tools', __( 'General', \SourceFramework\TEXTDOMAIN ) );

    $args = [
        'type' => 'checkbox',
        'name' => __( 'CDN', \SourceFramework\TEXTDOMAIN ),
        'id'   => 'cdn-enabled',
        'desc' => __( "This option enables the use of CDN in plugin's registered scripts and styles.", \SourceFramework\TEXTDOMAIN ),
    ];
    $this->fields->add_field( $args );
  }

}
