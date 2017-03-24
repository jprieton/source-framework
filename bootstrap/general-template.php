<?php

use SourceFramework\Helpers\Html;

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
function bootstrap_paginate_links( $args = array() ) {
  $defaults = array(
      'type' => 'list',
  );
  $args     = wp_parse_args( $args, $defaults );

  $paginate   = paginate_links( $args );
  $search     = array(
      "<ul class='page-numbers'>",
      "<li><span class='page-numbers current'>"
  );
  $replace    = array(
      "<ul class='page-numbers pagination'>",
      "<li class='active'><span class='page-numbers current'>"
  );
  $paginate   = str_replace( $search, $replace, $paginate );
  $pagination = Html::tag( 'nav', $paginate, array(
              'itemscope',
              'itemtype' => 'http://schema.org/SiteNavigationElement' ) );

  return $paginate;
}
