<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace SourceFramework\Template\Bootstrap4;

use SourceFramework\Template\Tag;

/**
 * Description of Breadcrumb
 *
 * @author perseo
 */
class Breadcrumb extends \SourceFramework\Template\Breadcrumb {

  public function generate() {
    $breadcrumb = parent::generate();

    if (empty($breadcrumb)) {
      return '';
    }

    $count = count( $breadcrumb );
    $list = [];
    $i    = 0;
    foreach ( $breadcrumb as $crumb ) {
      $i++;
      $li     = ($i < $count) ? 'li.breadcrumb-item' : 'li.breadcrumb-item.active';
      $link   = ($i < $count) ? Tag::a( $crumb[1], $crumb[0] ) : $crumb[0];
      $list[] = Tag::html( $li, $link );
    }

    return Tag::html( 'ol.breadcrumb', implode( "\n", $list ) );
  }

}
