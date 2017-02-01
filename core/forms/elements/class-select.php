<?php

namespace SourceFramework\Forms\Elements;

/**
 * If this file is called directly, abort.
 */
if ( !defined( 'ABSPATH' ) ) {
  die( 'Direct access is forbidden.' );
}

use SourceFramework\Forms\Element;
use SourceFramework\Html\Tag;

/**
 * Class Select
 *
 * @since 1.0.0
 *
 * @package Forms
 * @subpackage Elements
 *
 * @author  Javier Prieto <jprieton@gmail.com>
 */
class Select extends Element {

  public function __construct( $attributes, $data = array() ) {
    if ( !is_array( $attributes ) ) {
      $attributes = (array) $attributes;
    }

    $defaults   = array(
        'type' => 'text'
    );
    $attributes = wp_parse_args( $attributes, $defaults );

    $options = $this->_placeholder();
  }

  private function _placeholder( $text = '' ) {
    if ( empty( $text ) ) {
      $text = __( 'Select...', 'source-framework' );
    }
    $attributes  = array(
        'value' => '',
    );

    $tag         = new Tag();
    $placeholder = $tag->html( 'option', $text, $attributes );

    return $placeholder;
  }

}
