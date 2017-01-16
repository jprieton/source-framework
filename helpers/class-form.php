<?php

namespace SourceFramework\Helpers;

/**
 * If this file is called directly, abort.
 */
if ( !defined( 'ABSPATH' ) ) {
  die( 'Direct access is forbidden.' );
}

use SourceFramework\Helpers\Html;

/**
 * Html class
 *
 * Based on Laravel Forms & HTML helper and CodeIgniter form helper
 *
 * @package Helper
 *
 * @since   1.0.0
 * @see     https://laravelcollective.com/docs/master/html
 * @see     https://www.codeigniter.com/userguide3/helpers/form_helper.html
 *
 * @author         Javier Prieto <jprieton@gmail.com>
 */
class Form {

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
  public static function open( $attributes = array() ) {
    return Html::open_tag( 'form', $attributes );
  }

  /**
   * Open up a new HTML Multipart form.
   *
   * @since 1.0.0
   *
   * @param   array|string        $attributes
   *
   * @see     https://developer.mozilla.org/en-US/docs/Web/HTML/Element/form
   *
   * @return  string
   */
  public static function open_multipart( $attributes = array() ) {
    $defaults   = array(
        'enctype' => 'multipart/form-data'
    );
    $attributes = wp_parse_args( $attributes, $defaults );
    return self::open( $attributes );
  }

  /**
   * Close the HTML form.
   *
   * @since 1.0.0
   *
   * @return  string
   */
  public static function close() {
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
  public static function input( $type, $name, $value = '', $attributes = array() ) {
    $defaults   = array(
        'name'  => $name,
        'value' => $value,
        'type'  => $type
    );
    $attributes = wp_parse_args( $attributes, $defaults );

    return Html::void_tag( 'input', $attributes );
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
  public static function text( $name, $value = '', $attributes = array() ) {
    return self::input( 'text', $name, $value, $attributes );
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

    return Html::tag( 'textarea', esc_textarea( $text ), $attributes );
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
  public static function hidden( $name, $value = '', $attributes = array() ) {
    return self::input( 'hidden', $name, $value, $attributes );
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
  public static function email( $name, $value = '', $attributes = array() ) {
    return self::input( 'email', $name, $value, $attributes );
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
  public static function url( $name, $value = '', $attributes = array() ) {
    return self::input( 'url', $name, $value, $attributes );
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
  public static function password( $name, $attributes = array() ) {
    return self::input( 'password', $name, null, $attributes );
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
  public static function file( $name, $attributes = array() ) {
    return self::input( 'file', $name, null, $attributes );
  }

}

load_helper( 'html' );
