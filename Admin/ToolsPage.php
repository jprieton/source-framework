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
        'name' => __( 'Frontend Helper', \SourceFramework\TEXTDOMAIN ),
        'id'   => 'frontend-helper-enabled',
        'desc' => __( 'This option enables <strong>Frontend Helper</strong> feature.', \SourceFramework\TEXTDOMAIN ),
    ];
    $this->fields->add_field( $args );
  }

}
