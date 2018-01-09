<?php

namespace SourceFramework\Template;

/**
 * If this file is called directly, abort.
 */
if ( !defined( 'ABSPATH' ) ) {
  die( 'Direct access is forbidden.' );
}

use SourceFramework\Template\Tag;
use SourceFramework\Settings\SettingGroup;

/**
 * Shortcode class
 *
 * A collection of static methods to mark up schemas for structured data.
 *
 * @package Template
 *
 * @since   1.0.0
 * @see     http://schema.org/docs/schemas.html
 *
 * @author  Javier Prieto <jprieton@gmail.com>
 */
class Shortcode {

  /**
   * Add an ofuscate mailto link to prevent spam-bots from sniffing it.
   *
   * @since 1.0.0
   *
   * @param  type      $attributes
   * @param  type      $content
   * @return string
   */
  public static function mailto( $attributes, $content = null ) {
    if ( is_email( $content ) ) {
      $attributes['href'] = $content;
    }

    $defaults = array(
        'href' => ''
    );

    $attributes = wp_parse_args( $attributes, $defaults );

    if ( empty( $attributes['href'] ) ) {
      return '';
    } else {
      $email = $attributes['href'];
      unset( $attributes['href'] );
    }

    if ( empty( $content ) ) {
      $content = $email;
    }

    return Tag::mailto( $email, $content, $attributes );
  }

  /**
   * Returns a reCAPTCHA div
   *
   * @since 1.1.0
   *
   * @global SettingGroup $api_setting_group
   * @param array $attributes
   * @return string
   */
  public static function recaptcha( $attributes ) {
    global $api_setting_group;

    if ( empty( $api_setting_group ) ) {
      $api_setting_group = new SettingGroup( 'api_settings' );
    }

    $defaults = array(
        'class'        => 'g-recaptcha',
        'data-sitekey' => $api_setting_group->get_option( 'recaptcha-site-key' )
    );

    $attributes = wp_parse_args( $attributes, $defaults );
    return Tag::html( 'div', null, $attributes );
  }

}
