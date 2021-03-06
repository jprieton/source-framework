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
 * @subpackage     Bootstrap3
 *
 * @since          0.5.0
 * @see            http://getbootstrap.com/docs/3.3/components/#pagination
 *
 * @author         Javier Prieto <jprieton@gmail.com>
 */
class Pagination {

  /**
   * Returns a Bootstrap pagination links
   *
   * @since  1.0.0
   * @see    https://codex.wordpress.org/Function_Reference/paginate_links
   *
   * @global  type          $wp_query
   * @param   array         $args
   * @return  string
   */
  public static function paginate_links( $args = [] ) {
    $defaults   = array(
        'nav_class' => 'text-center',
        'class'     => '',
        'prev_text' => '<span aria-hidden="true">&laquo;</span>',
        'next_text' => '<span aria-hidden="true">&raquo;</span>',
        'type'      => 'list',
    );
    $args       = wp_parse_args( $args, $defaults );
    $paginate   = paginate_links( $args );
    $search     = [
        "<ul class='page-numbers'>",
        "<li><span class='page-numbers current'>"
    ];
    $replace    = [
        sprintf( "<ul class='page-numbers %s'>", trim( 'paginate ' . $args['class'] ) ),
        "<li class='active'><span class='page-numbers current'>"
    ];
    $paginate   = str_replace( $search, $replace, $paginate );
    $pagination = Tag::html( 'nav', $paginate, [
                'itemscope',
                'itemtype'   => 'http://schema.org/SiteNavigationElement',
                'aria-label' => __( 'Page navigation', \SourceFramework\TEXTDOMAIN ),
                'class'      => $args['nav_class'],
            ] );

    return $pagination;
  }

}
