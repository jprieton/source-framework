<?php

namespace SourceFramework\Forms;

/**
 * If this file is called directly, abort.
 */
if ( !defined( 'ABSPATH' ) ) {
  die( 'Direct access is forbidden.' );
}

use SourceFramework\Html\Tag;

/**
 * Class Form
 *
 * @since 1.0.0
 *
 * @package Forms
 *
 * @author  Javier Prieto <jprieton@gmail.com>
 */
class Form {

  /**
   * @since 1.0.0
   */
  private $_attributes = array();

  /**
   * @since 1.0.0
   */
  private $_elements = array();

  /**
   * @since 1.0.0
   */
  private $_render = '';

  /**
   * @since 1.0.0
   */
  public function __construct( $attributes = array() ) {
    $defaults = array(
        'method' => 'post',
    );

    $this->_attributes = wp_parse_args( $attributes, $defaults );
  }

  /**
   * @since 1.0.0
   */
  public function add( $element, $wrapper = '' ) {
    $tag = Tag::get_instance();
    $this->_elements[] = empty( $wrapper ) ? $element : $tag->html( $wrapper, $element );
  }

  /**
   * @since 1.0.0
   */
  public function render( $echo = false ) {
    $tag = Tag::get_instance();
    $this->_render = $tag->open( 'form', $tag->parse_attributes( $this->_attributes ) );

    foreach ( $this->_elements as $element ) {
      $this->_render .= $element;
    }

    $this->_render .= $tag->close( 'form' );

    if ( $echo ) {
      echo $this->_render;
    }

    return $this->_render;
  }

}
