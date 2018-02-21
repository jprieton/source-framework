<?php

namespace SourceFramework\Vendor\Bootstrap4;

// If this file is called directly, abort.
if ( !defined( 'ABSPATH' ) ) {
  die( 'Direct access is forbidden.' );
}

use SourceFramework\Template\Html;

/**
 * Description of Components
 *
 * @author perseo
 */
class Components {

  /**
   * Retrieve a Bootstrap alert component
   *
   * @since 2.0.0
   *
   * @see     https://getbootstrap.com/docs/4.0/components/alerts/
   *
   * @param   string              $type
   * @param   string              $heading
   * @param   string              $body
   * @param   string|array        $attributes
   *
   * @return  string
   */
  public static function alert( $type = 'primary', $heading = '', $body = '', $attributes = [] ) {
    $defaults = array(
        'role'        => 'alert',
        'class'       => "alert alert-{$type}",
        'dismissible' => true,
    );

    $attributes = wp_parse_args( $attributes, $defaults );

    $content = '';

    if ( $attributes['dismissible'] ) {
      $content             .= static::dismiss( 'alert' );
      $attributes['class'] .= ' alert-dismissible fade show';
    }
    unset( $attributes['dismissible'] );

    if ( $heading ) {
      $content .= sprintf( '<h4 class="alert-heading">%s</h4>', trim( $heading ) );
    }

    $content .= wptexturize( trim( $body ) );

    return Html::tag( 'div', $content, $attributes );
  }

  /**
   * Bootstrap close button for modals and/or alerts
   *
   * @since   2.0.0
   *
   * @param   string              $component
   * @return  string
   */
  public static function dismiss( $component ) {
    $format = '<button type="button" class="close" data-dismiss="%s" aria-label="%s"><span aria-hidden="true">&times;</span></button>';
    return sprintf( $format, $component, __( 'Close', SF_TEXTDOMAIN ) );
  }

}
