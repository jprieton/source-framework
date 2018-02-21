<?php

namespace SourceFramework\Shortcode;

/**
 * If this file is called directly, abort.
 */
if ( !defined( 'ABSPATH' ) ) {
  die( 'Direct access is forbidden.' );
}

use SourceFramework\Template\Html;

/**
 * General shortcode class
 *
 * A collection of template shortcodes.
 *
 * @package Template
 *
 * @since   2.0.0
 * @see     https://codex.wordpress.org/Shortcode_API
 *
 * @author  Javier Prieto
 */
class General {

  /**
   * Add an ofuscate mailto link to prevent spam-bots from sniffing it.
   *
   * @since 2.0.0
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

}
