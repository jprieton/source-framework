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
    /**
     * Allow override menu slug
     * @since 1.0.0
     */
    $menu_slug   = apply_filters( 'source_framework_tools_menu_slug', 'source-framework' );

    parent::__construct( $menu_slug, 'source-framework-tools' );
    $this->add_submenu_page( __( 'Tools', \SourceFramework\TEXTDOMAIN ), __( 'Tools', \SourceFramework\TEXTDOMAIN ), 'activate_plugins' );

    $this->fields = new SettingField( 'tools_settings', 'tools_settings' );
    $this->add_general_section();
  }

  /**
   * Adds General setting section to Tools menu.
   *
   * @since 1.0.0
   */
  public function add_general_section() {
    $this->add_setting_section( 'source-framework-tools', __( 'General', \SourceFramework\TEXTDOMAIN ) );

    $args = [
        'type'    => 'select',
        'name'    => __( 'Frontend Helper', \SourceFramework\TEXTDOMAIN ),
        'id'      => 'frontend-helper-enabled',
        'desc'    => __( 'This option enables <strong>Frontend Helper</strong> feature.', \SourceFramework\TEXTDOMAIN ),
        'options' => [
            'no'          => __( 'Disabled', \SourceFramework\TEXTDOMAIN ),
            'bootstrap3x' => 'Bootstrap 3.x',
            'bootstrap4x' => 'Bootstrap 4.x',
        ]
    ];
    $this->fields->add_field( $args );
  }

}
