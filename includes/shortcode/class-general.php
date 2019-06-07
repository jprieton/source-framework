<?php

namespace SourceFramework\Shortcode;

defined( 'ABSPATH' ) || exit;

use SMGTools\Template\Html;
use SMGTools\Settings\Settings_Group;

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
    $defaults   = [ 'href' => '' ];
    $attributes = wp_parse_args( $attributes, $defaults );

    if ( is_email( $content ) ) {
      $attributes['href'] = $content;
    }

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
   * Adds a list with the social media links
   * 
   * @since 2.1.0
   * 
   * @param  type $attributes
   * @return type
   */
  public static function social_links( $attributes = [] ) {
    $defaults   = [ 'class' => '' ];
    $attributes = wp_parse_args( $attributes, $defaults );

    if ( !empty( $attributes['class'] ) ) {
      $attributes['class'] .= ' social-links-container';
    } else {
      $attributes['class'] = 'social-links-container';
    }

    $social_links = apply_filters( 'social_networks', [] );
    $settings     = new Settings_Group( 'social_links' );

    $links = [];

    foreach ( $social_links as $key => $label ) {
      $link = $settings->get_option( $key );

      if ( empty( $link ) ) {
        continue;
      }

      $links[] = Html::a( $link, Html::span( $label ), [ 'class' => "social-link {$key}" ] );
    }

    if ( empty( $links ) ) {
      return '';
    }

    $html = apply_filters( 'social_links_shortcode', Html::ul( $links, $attributes ), $social_links, $settings );

    return $html;
  }

}
