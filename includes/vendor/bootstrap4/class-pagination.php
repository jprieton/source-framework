<?php

namespace SourceFramework\Vendor\Bootstrap4;

// If this file is called directly, abort.
if ( !defined( 'ABSPATH' ) ) {
  die( 'Direct access is forbidden.' );
}

use SourceFramework\Template\Html;

/**
 * Bootstrap 4.x pagination class
 *
 * @package       SourceFramework
 * @subpackage    Vendor\Bootstrap4
 *
 * @since         2.0.0
 * @see           http://getbootstrap.com/docs/4.1/components/pagination/
 * @author        Javier Prieto
 */
class Pagination {

  /**
   * Returns a list of pagination link for the Bootstrap 4.x Pagination component.
   *
   * @see     https://codex.wordpress.org/Function_Reference/paginate_links
   *
   * @param   array   $args   Same args that WordPress function <code>paginate_links</code>,
   *                          the <code>type</code> argument is override
   * @return  string
   */
  public static function get_paginate_links( $args = [] ) {
    $args['type'] = 'array';

    $links = paginate_links( $args );

    if ( empty( $links ) ) {
      return '';
    }

    foreach ( $links as &$link ) {
      $link = str_replace( 'page-numbers', 'page-link page-numbers', $link );

      if ( strpos( $link, 'page-numbers current' ) !== FALSE ) {
        $link = Html::tag( 'li.page-item.active', $link );
      } else if ( strpos( $link, 'page-numbers dots' ) !== FALSE ) {
        $link = Html::tag( 'li.page-item.disabled', $link );
      } else {
        $link = Html::tag( 'li.page-item', $link );
      }
    }
    unset( $link );

    return implode( "\n", $links );
  }

}
