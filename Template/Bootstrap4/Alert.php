<?php

namespace SourceFramework\Template\Bootstrap3;

/**
 * If this file is called directly, abort.
 */
if ( !defined( 'ABSPATH' ) ) {
  die( 'Direct access is forbidden.' );
}

use SourceFramework\Template\Tag;

/**
 * Pagination class
 *
 * @package        Template
 * @subpackage     Bootstrap4
 *
 * @since          1.0.0
 * @see            https://getbootstrap.com/docs/4.0/components/alerts/
 *
 * @author         Javier Prieto <jprieton@gmail.com>
 */
class Alert {

  /**
   * Retrieve a Bootstrap alert component
   *
   * @since 0.5.0
   *
   * @param   string              $content
   * @param   string|array        $attr
   *
   * @return  string
   */
  public static function alert( $content, $attr = array() ) {
    $defaults = [
        'dismiss' => true,
        'role'    => 'alert',
        'class'   => 'alert ',
    ];
    $attr     = wp_parse_args( $attr, $defaults );

    if ( $attr['dismiss'] ) {
      $dismiss       = '<button type="button" class="close" data-dismiss="alert" aria-label="' . __( 'Close', \SourceFramework\TEXTDOMAIN ) . '">'
              . '<span aria-hidden="true">&times;</span>'
              . '</button>';
      $attr['class'] .= ' alert-dismissible ';
    } else {
      $dismiss = '';
    }
    unset( $attr['dismiss'] );

    return Tag::html( 'div', $icon . $dismiss . $content, $attr );
  }

}
