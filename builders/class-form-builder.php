<?php

namespace SourceFramework\Builders;

/**
 * If this file is called directly, abort.
 */
if ( !defined( 'ABSPATH' ) ) {
  die( 'Direct access is forbidden.' );
}

use SourceFramework\Builders\HtmlBuilder;

/**
 * Form_Builder class
 *
 * Based on Laravel Forms & HTML helper and CodeIgniter Form helper
 *
 * @package Helper
 *
 * @since   1.0.0
 * @see     https://laravelcollective.com/docs/master/html
 * @see     https://www.codeigniter.com/userguide3/helpers/form_helper.html
 *
 * @author  Javier Prieto <jprieton@gmail.com>
 */
class Form_Builder {

  /**
   * Static instance of this class
   *
   * @since         1.0.0
   * @var           Form_Builder
   */
  protected static $instance;

  /**
   * @since 1.0.0
   *
   * @return  static
   */
  public static function &get_instance() {
    if ( !isset( static::$instance ) ) {
      static::$instance = new static;
    }
    return static::$instance;
  }

  /**
   * Declared as protected to prevent creating a new instance outside of the class via the new operator.
   *
   * @since 1.0.0
   */
  protected function __construct() {
    if ( !class_exists( 'Html_Builder' ) ) {
      load_builder( 'Html_Builder' );
    }
  }

  /**
   * Declared as private to prevent cloning of an instance of the class via the clone operator.
   *
   * @since 1.0.0
   */
  private function __clone() {

  }

  /**
   * Declared as private to prevent unserializing of an instance of the class via the global function unserialize() .
   *
   * @since 1.0.0
   */
  private function __wakeup() {

  }

  /**
   * Declared as protected to prevent serializg of an instance of the class via the global function serialize().
   *
   * @since 1.0.0
   */
  protected function __sleep() {

  }

  /**
   * Open up a new HTML form.
   *
   * @since 1.0.0
   *
   * @param   array|string        $attributes
   *
   * @see     https://developer.mozilla.org/en-US/docs/Web/HTML/Element/form
   *
   * @return  string
   */
  public function open( $attributes = array() ) {
    $html = HtmlBuilder::get_instance();
    return sprintf( '<form $s>', $html->attributes( $attributes ) );
  }

  /**
   * Close the HTML form.
   *
   * @since 1.0.0
   *
   * @return  string
   */
  public function close() {
    return '</form>';
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
  public function input( $type = 'text', $name = '', $value = '', $attributes = array() ) {
    $defaults   = array(
        'name'  => $name,
        'value' => $value,
        'type'  => $type
    );
    $attributes = wp_parse_args( $attributes, $defaults );

    $html = Html_Builder::get_instance();
    return $html->tag( 'input', null, $attributes );
  }

  /**
   * Create a text input field.
   *
   * @since 1.0.0
   *
   * @param   string              $name
   * @param   string              $value
   * @param   array|string        $attributes
   * @return  string
   */
  public function text( $name, $value = '', $attributes = array() ) {
    return $this->input( 'text', $name, $value, $attributes );
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
  public function textarea( $name, $text = '', $attributes = array() ) {
    $defaults   = array(
        'name' => $name,
    );
    $attributes = wp_parse_args( $attributes, $defaults );

    $html = HtmlBuilder::get_instance();
    return $html->tag( 'textarea', esc_textarea( $text ), $attributes );
  }

  /**
   * Create a hidden input field.
   *
   * @since 1.0.0
   *
   * @param   string              $name
   * @param   string              $value
   * @param   array|string        $attributes
   * @return  string
   */
  public function hidden( $name, $value = '', $attributes = array() ) {
    return $this->input( 'hidden', $name, $value, $attributes );
  }

  /**
   * Create a email input field.
   *
   * @since 1.0.0
   *
   * @param   string              $name
   * @param   string              $value
   * @param   array|string        $attributes
   * @return  string
   */
  public function email( $name, $value = '', $attributes = array() ) {
    return $this->input( 'email', $name, $value, $attributes );
  }

  /**
   * Create a email input field.
   *
   * @since 1.0.0
   *
   * @param   string              $name
   * @param   string              $value
   * @param   array|string        $attributes
   * @return  string
   */
  public function url( $name, $value = '', $attributes = array() ) {
    return $this->input( 'url', $name, $value, $attributes );
  }

  /**
   * Create a password input field.
   *
   * @since 1.0.0
   *
   * @param   string              $name
   * @param   array|string        $attributes
   * @return  string
   */
  public function password( $name, $attributes = array() ) {
    return $this->input( 'password', $name, null, $attributes );
  }

  /**
   * Create a file input field.
   *
   * @since 1.0.0
   *
   * @param   string              $name
   * @param   array|string        $attributes
   * @return  string
   */
  public function file( $name, $attributes = array() ) {
    return $this->input( 'file', $name, null, $attributes );
  }

  /**
   *
   * @param string $label
   * @param string $type
   * @param type $attributes
   * @return string
   */
  public function button( $label, $type = 'button', $attributes = array() ) {
    $defaults   = array(
        'type' => $type,
    );
    $attributes = wp_parse_args( $attributes, $defaults );

    $html = Html_Builder::get_instance();

    return $html->tag( 'button', $label, $attributes );
  }

}
