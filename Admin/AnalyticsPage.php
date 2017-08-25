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
 * Analytics class
 *
 * @package        Admin
 * @subpackage     SettingPages
 * @since          1.0.0
 * @author         Javier Prieto <jprieton@gmail.com>
 */
final class AnalyticsPage extends SettingPage {

  /**
   * Constructor
   *
   * @since 1.0.0
   */
  public function __construct() {
    $this->title = __( 'Analytics &amp; SEO', \SourceFramework\TEXTDOMAIN );
    /**
     * Allow override menu slug
     * @since 1.0.0
     */
    $menu_slug   = apply_filters( 'source_framework_analytics_menu_slug', 'source-framework' );

    parent::__construct( $menu_slug, 'source-framework-analytics' );

    $this->fields = new SettingField( 'analytics_settings', 'analytics_settings' );

    $this->add_submenu_page( __( 'Analytics &amp; SEO', \SourceFramework\TEXTDOMAIN ), __( 'Analytics &amp; SEO', \SourceFramework\TEXTDOMAIN ), 'activate_plugins' );
    $this->add_google_settings_section();
    $this->add_bing_settings_section();
    $this->add_facebook_pixel_settings_section();
  }

  /**
   * Add Google settings section
   *
   * @since   0.5.0
   */
  private function add_google_settings_section() {
    $this->add_setting_section( 'source-framework-analytics-google', 'Google' );
    $this->fields->add_field( array(
        'name'        => 'Google Universal Analytics',
        'id'          => 'google-universal-analytics',
        'type'        => 'textarea',
        'raw'         => true,
        'rows'        => 6,
        'input_class' => 'large-text code',
        'desc'        => __( 'This snippet is inserted before the closing <code>&lt;head&gt;</code> tag.', \SourceFramework\TEXTDOMAIN ),
    ) );
    $this->fields->add_field( array(
        'name'        => 'Google Tag Manager',
        'id'          => 'google-tag-manager',
        'type'        => 'textarea',
        'raw'         => true,
        'rows'        => 6,
        'input_class' => 'large-text code',
        'desc'        => __( 'This snippet is inserted after the opening <code>&lt;body&gt;</code> tag.', \SourceFramework\TEXTDOMAIN ),
    ) );
    $this->fields->add_field( array(
        'name'        => __( 'Site Verification Code', \SourceFramework\TEXTDOMAIN ),
        'id'          => 'google-site-verification',
        'type'        => 'text',
        'input_class' => 'large-text code',
        'desc'        => [
            '<code>&lt;meta name="google-site-verification" content="<b>{' . _x( 'verification-code', 'settings', \SourceFramework\TEXTDOMAIN ) . '}</b>"&gt;</code>',
            __( 'This snippet is inserted after the opening <code>&lt;head&gt;</code> tag.', \SourceFramework\TEXTDOMAIN ) ],
    ) );
  }

  /**
   * Add Bing settings section
   *
   * @since   0.5.0
   */
  private function add_bing_settings_section() {
    $this->add_setting_section( 'source-framework-analytics-bing', 'Bing' );
    $this->fields->add_field( array(
        'name'        => __( 'Site Verification Code', \SourceFramework\TEXTDOMAIN ),
        'id'          => 'bing-site-verification',
        'type'        => 'text',
        'input_class' => 'large-text code',
        'desc'        => [
            '<code>&lt;meta  name="msvalidate.01" content="<b>{' . _x( 'verification-code', 'settings', \SourceFramework\TEXTDOMAIN ) . '}</b>"&gt;</code>',
            __( 'This snippet is inserted after the opening <code>&lt;head&gt;</code> tag.', \SourceFramework\TEXTDOMAIN ) ],
    ) );
  }

  /**
   * Add Facebook Pixel Code settings section
   *
   * @since   0.5.0
   */
  private function add_facebook_pixel_settings_section() {
    $this->add_setting_section( 'source-framework-analytics-facebook', 'Facebook' );
    $this->fields->add_field( array(
        'name'        => 'Facebook Pixel Code',
        'id'          => 'facebook-pixel-code',
        'type'        => 'textarea',
        'raw'         => true,
        'rows'        => 6,
        'input_class' => 'large-text code',
        'desc'        => __( 'This snippet is inserted before the closing <code>&lt;head&gt;</code> tag.', \SourceFramework\TEXTDOMAIN ),
    ) );
  }

}
