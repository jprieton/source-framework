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
 * Class Email
 *
 * @since 1.0.0
 *
 * @package Forms
 *
 * @author  Javier Prieto <jprieton@gmail.com>
 */
class Element {

  protected $_element    = '';
  protected $_label      = '';
  protected $_attributes = '';

  /**
   * Create a input field.
   *
   * @since 1.0.0
   *
   * @param   string              $name
   * @param   array|string        $attributes
   * @return  void
   */
  protected function _input( $type, $attributes = array() ) {

    if ( !is_array( $attributes ) ) {
      $attributes = (array) $attributes;
    }

    if ( isset( $attributes[0] ) && !isset( $attributes['id'] ) ) {
      $attributes['id'] = $attributes[0];
      unset( $attributes[0] );
    }

    if ( !isset( $attributes['name'] ) ) {
      $attributes['name'] = $attributes['id'];
    }

    $attributes['type'] = $type;

    $this->_attributes = $attributes;

    $tag            = Tag::get_instance();
    $this->_element = $tag->html( 'input', null, $attributes );
  }

  /**
   * Create a textarea input field.
   *
   * @since 1.0.0
   *
   * @param   string              $name
   * @param   string              $text
   * @param   array|string        $attributes
   * @return  void
   */
  public function _textarea( $attributes = array(), $text = '' ) {
    if ( !is_array( $attributes ) ) {
      $attributes = (array) $attributes;
    }

    if ( isset( $attributes[0] ) && !isset( $attributes['id'] ) ) {
      $attributes['id'] = $attributes[0];
      unset( $attributes[0] );
    }

    if ( !isset( $attributes['name'] ) ) {
      $attributes['name'] = $attributes['id'];
    }

    $this->_attributes = $attributes;

    $tag            = Tag::get_instance();
    $this->_element = $tag->html( 'textarea', esc_textarea( $text ), $attributes );
  }

  /**
   * Create a input label.
   *
   * @since 1.0.0
   *
   * @param   string              $label
   * @param   array|string        $attributes
   * @return  void
   */
  public function label( $label, $attributes = array() ) {
    $defaults = array(
        'for' => $this->_attributes['id']
    );

    $attributes   = wp_parse_args( $attributes, $defaults );

    $tag            = Tag::get_instance();
    $this->_label = $tag->html( 'label', $label, $attributes );
  }

  public function __toString() {
    return $this->_label . $this->_element;
  }

}
