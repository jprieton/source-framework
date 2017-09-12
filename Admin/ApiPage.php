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
 * ApiPage class
 *
 * @package        Admin
 * @subpackage     SettingPages
 * @since          1.0.0
 * @author         Javier Prieto <jprieton@gmail.com>
 */
final class ApiPage extends SettingPage {

  /**
   * Constructor
   *
   * @since 1.0.0
   */
  public function __construct() {
    $this->title = __( 'APIs Settings ', \SourceFramework\TEXTDOMAIN );
    /**
     * Allow override menu slug
     * @since 1.0.0
     */
    $menu_slug   = apply_filters( 'source_framework_apis_menu_slug', 'source-framework' );

    $this->fields = new SettingField( 'api_settings', 'api_settings' );

    parent::__construct( $menu_slug, 'source-framework-api' );
    $this->add_submenu_page( __( 'APIs', \SourceFramework\TEXTDOMAIN ), __( 'APIs', \SourceFramework\TEXTDOMAIN ), 'activate_plugins' );
    $this->add_instagram_settings_section();
    $this->add_recatpcha_settings_section();
  }

  /**
   * Add Instagram API Section
   *
   * @since   1.0.0
   */
  private function add_instagram_settings_section() {
    $this->add_setting_section( 'source-framework-api-instagram', 'Instagram' );

    $this->fields->add_field( array(
        'name'        => 'Client ID',
        'id'          => 'instagram-client-id',
        'type'        => 'text',
        'input_class' => 'regular-text code',
    ) );

    $this->fields->add_field( array(
        'name'        => 'Token',
        'id'          => 'instagram-token',
        'type'        => 'text',
        'input_class' => 'regular-text code',
    ) );

    $this->fields->add_field( array(
        'name'        => __( 'Cache', \SourceFramework\TEXTDOMAIN ),
        'id'          => 'instagram-timeout-cache',
        'type'        => 'text',
        'input_class' => 'regular-text code',
        'placeholder' => 60 * MINUTE_IN_SECONDS,
        'desc'        => 'Set data cache of requests in seconds',
    ) );
  }

  /**
   * Add reCAPTCHA API Section
   *
   * @since   1.1.0
   */
  private function add_recatpcha_settings_section() {
    $this->add_setting_section( 'source-framework-api-recaptcha', 'reCAPTCHA' );

    $this->fields->add_field( array(
        'name'        => 'Site Key',
        'id'          => 'recaptcha-site-key',
        'type'        => 'text',
        'input_class' => 'regular-text code',
    ) );

    $this->fields->add_field( array(
        'name'        => 'Secret Key',
        'id'          => 'recaptcha-secret-key',
        'type'        => 'text',
        'input_class' => 'regular-text code',
    ) );
  }

}
