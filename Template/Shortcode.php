<?php

namespace SourceFramework\Template;

/**
 * If this file is called directly, abort.
 */
if ( !defined( 'ABSPATH' ) ) {
  die( 'Direct access is forbidden.' );
}

use SourceFramework\Template\Html;
use SourceFramework\Settings\SettingGroup;

/**
 * Shortcode class
 *
 * A collection of template shortcodes.
 *
 * @package Template
 *
 * @since   1.0.0
 * @see     https://codex.wordpress.org/Shortcode_API
 *
 * @author  Javier Prieto <jprieton@gmail.com>
 */
class Shortcode {

  /**
   * Add an ofuscate mailto link to prevent spam-bots from sniffing it.
   *
   * @since 1.0.0
   *
   * @param  array      $attributes
   * @param  string     $content
   * @return string
   */
  public static function mailto( $attributes, $content = null ) {
    if ( is_email( $content ) ) {
      $attributes['href'] = $content;
    }

    $defaults = [
        'href' => ''
    ];

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

    return Html::mailto( $email, $content, $attributes );
  }

  /**
   * Add a Bootstrap styled button
   *
   * @since 1.5.0
   * @see http://getbootstrap.com/docs/4.0/components/buttons/
   * @see https://getbootstrap.com/docs/3.3/css/#buttons
   *
   * @param  array      $attributes
   * @param  string     $content
   * @return string
   */
  public static function button( $attributes, $content = null ) {
    $defaults = [
        'class' => 'btn btn-primary',
        'href'  => '#',
    ];

    $attributes = wp_parse_args( $attributes, $defaults );

    if ( isset( $attributes['disabled'] ) || strpos( $attributes['class'], 'disabled' ) !== false ) {
      $attributes['aria-disabled'] = 'true';
    }

    if ( !empty( $attributes['type'] ) ) {
      unset( $attributes['href'] );
      return Html::tag( 'button', $content, $attributes );
    } else {
      $attributes['role'] = 'button';
      return Html::tag( 'a', $content, $attributes );
    }
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

    $defaults = [
        'class'        => 'g-recaptcha',
        'data-sitekey' => $api_setting_group->get_option( 'recaptcha-site-key' )
    ];

    $attributes = wp_parse_args( $attributes, $defaults );
    return Html::tag( 'div', null, $attributes );
  }

}
