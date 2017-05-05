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
 * Class Email
 *
 * @since 1.0.0
 *
 * @package Forms
 * @subpackage Elements
 *
 * @author  Javier Prieto <jprieton@gmail.com>
 */
class Email extends Element {

  public function __construct( $attributes ) {
    if ( !is_array( $attributes ) ) {
      $attributes = (array) $attributes;
    }

    $defaults   = array(
        'type' => 'email'
    );
    $attributes = wp_parse_args( $attributes, $defaults );

    $this->_input( 'email', $attributes );
  }

}
