<?php

namespace SourceFramework\Forms\Elements;

/**
 * If this file is called directly, abort.
 */
if ( !defined( 'ABSPATH' ) ) {
  die( 'Direct access is forbidden.' );
}

use SourceFramework\Forms\Element;

/**
 * Class Text
 *
 * @since 1.0.0
 *
 * @package Forms
 * @subpackage Elements
 *
 * @author  Javier Prieto <jprieton@gmail.com>
 */
class Textarea extends Element {

  public function __construct( $attributes, $content = '' ) {
    if ( !is_array( $attributes ) ) {
      $attributes = (array) $attributes;
    }

    $attributes = wp_parse_args( $attributes, $defaults );

    $this->_textarea( $attributes, $content );
  }

}
