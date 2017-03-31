<?php

/**
 * If this file is called directly, abort.
 */
if ( !defined( 'ABSPATH' ) ) {
  die( 'Direct access is forbidden.' );
}

use SourceFramework\Helpers\Html;

/**
 * Add an ofuscate mailto link to prevent spam-bots from sniffing it.
 *
 * @since 1.0.0
 */
add_shortcode( 'mailto', function($atts, $content = null) {
  if ( is_email( $content ) ) {
    $atts['href'] = $content;
  }

  $atts = wp_parse_args( $atts, [ 'href' => '' ] );

  if ( empty( $atts['href'] ) ) {
    return '';
  } else {
    $email = $atts['href'];
    unset( $atts['href'] );
  }

  if ( empty( $content ) ) {
    $content = $email;
  }

  load_helper( 'Html' );
  return Html::mailto( $email, $content, $atts );
} );
