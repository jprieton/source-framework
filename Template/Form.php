<?php

namespace SourceFramework\Template;

/**
 * If this file is called directly, abort.
 */
if ( !defined( 'ABSPATH' ) ) {
  die( 'Direct access is forbidden.' );
}

use SourceFramework\Template\Tag;

/**
 * Form class
 *
 * A collection of static methods to generate form elements markup.
 *
 * @package Template
 *
 * @since   1.0.0
 * @see     https://laravelcollective.com/docs/master/html
 * @see     https://www.codeigniter.com/userguide3/helpers/form_helper.html
 * @see     https://developer.mozilla.org/en-US/docs/Web/HTML/Element/form
 *
 * @author  Javier Prieto <jprieton@gmail.com>
 */
class Form {

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
    return Tag::html( 'label', $label, $attributes );
  }

  /**
   * Create a form input field.
   *
   * @since 1.0.0
   *
   * @param   string              $name
   * @param   string              $value
   * @param   array|string        $attributes
   * @return  string
   */
  public static function input( $type = 'text', $name = '', $value = '', $attributes = array() ) {
    $defaults   = array(
        'name'  => $name,
        'value' => $value,
        'type'  => $type
    );
    $attributes = wp_parse_args( $attributes, $defaults );

    return Tag::html( 'input', null, $attributes );
  }

  /**
   * Create a textarea input field.
   *
   * @since 1.0.0
   *
   * @param   string              $name
   * @param   string              $text
   * @param   array|string        $attributes
   * @return  string
   */
  public static function textarea( $name, $text = '', $attributes = array() ) {
    $defaults   = array(
        'name' => $name,
    );
    $attributes = wp_parse_args( $attributes, $defaults );

    return Tag::html( 'textarea', esc_textarea( $text ), $attributes );
  }

  /**
   * Create a button element.
   *
   * @param   string              $label
   * @param   string              $type
   * @param   type                $attributes
   * @return  string
   */
  public static function button( $label, $type = 'button', $attributes = array() ) {
    $defaults   = array(
        'type' => $type,
    );
    $attributes = wp_parse_args( $attributes, $defaults );

    return Tag::html( 'button', $label, $attributes );
  }

  /**
   * Shorthand for hidden input field.
   *
   * @since 1.0.0
   *
   * @param   string              $name
   * @param   string              $value
   * @param   array|string        $attributes
   * @return  string
   */
  public function hidden( $name, $value = '', $attributes = array() ) {
    return static::input( 'hidden', $name, $value, $attributes );
  }

  /**
   * Shorthand for text input field.
   *
   * @since 1.0.0
   *
   * @param   string              $name
   * @param   string              $value
   * @param   array|string        $attributes
   * @return  string
   */
  public function text( $name, $value = '', $attributes = array() ) {
    return static::input( 'text', $name, $value, $attributes );
  }

  /**
   * Shorthand for email input field.
   *
   * @since 1.0.0
   *
   * @param   string              $name
   * @param   string              $value
   * @param   array|string        $attributes
   * @return  string
   */
  public function email( $name, $value = '', $attributes = array() ) {
    return static::input( 'email', $name, $value, $attributes );
  }

  /**
   * Shorthand for email input field.
   *
   * @since 1.0.0
   *
   * @param   string              $name
   * @param   string              $value
   * @param   array|string        $attributes
   * @return  string
   */
  public function url( $name, $value = '', $attributes = array() ) {
    return static::input( 'url', $name, $value, $attributes );
  }

  /**
   * Shorthand for password input field.
   *
   * @since 1.0.0
   *
   * @param   string              $name
   * @param   array|string        $attributes
   * @return  string
   */
  public function password( $name, $attributes = array() ) {
    return static::input( 'password', $name, null, $attributes );
  }

  /**
   * Shorthand for file input field.
   *
   * @since 1.0.0
   *
   * @param   string              $name
   * @param   array|string        $attributes
   * @return  string
   */
  public function file( $name, $attributes = array() ) {
    return static::input( 'file', $name, null, $attributes );
  }

}
