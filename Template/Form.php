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
 * @package     SourceFramework
 * @subpackage  Template
 *
 * @see     https://laravelcollective.com/docs/master/html
 * @see     https://www.codeigniter.com/userguide3/helpers/form_helper.html
 * @see     https://developer.mozilla.org/en-US/docs/Web/HTML/Element/form
 *
 * @author      Javier Prieto <jprieton@gmail.com>
 * @copyright	  Copyright (c) 2017, Javier Prieto
 * @since       1.0.0
 * @license     http://www.gnu.org/licenses/gpl-3.0.txt
 */
class Form {

  /**
   * Create a input label.
   *
   * @since 1.0.0
   *
   * @param   string              $label
   * @param   array|string        $attributes
   * @return  string
   */
  public static function label( $label, $attributes = array() ) {
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
  public static function hidden( $name, $value = '', $attributes = array() ) {
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
  public static function text( $name, $value = '', $attributes = array() ) {
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
  public static function email( $name, $value = '', $attributes = array() ) {
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
  public static function url( $name, $value = '', $attributes = array() ) {
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
  public static function password( $name, $attributes = array() ) {
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
  public static function file( $name, $attributes = array() ) {
    return static::input( 'file', $name, null, $attributes );
  }

  /**
   * Create a dropdown list.
   *
   * @since 1.0.0
   *
   * @param   string              $name
   * @param   array|string        $options
   * @param   array|string        $attributes
   * @return  string
   */
  public static function select( $name, $options, $attributes = array() ) {
    global $wp_locale;

    $content     = '';
    $placeholder = '';
    $required    = false;
    $selected    = '';

    switch ( $options ) {
      case 'month':
        $options = $wp_locale->month;
        break;
      case 'weekday':
        $options = $wp_locale->weekday;
        break;
      default:
        $options = (is_array( $options )) ? $options : (array) $options;
        break;
    }

    $attributes = wp_parse_args( $attributes, compact( 'name' ) );

    if ( !empty( $attributes['placehonder'] ) && !is_bool( $attributes['placehonder'] ) ) {
      $placeholder = $attributes['placehonder'];
    } elseif ( !empty( $attributes['placehonder'] ) && is_bool( $attributes['placehonder'] ) && $attributes['placehonder'] ) {
      $placeholder = __( 'Select...', \SourceFramework\TEXTDOMAIN );
    }

    if ( !empty( $attributes['required'] ) && is_bool( $attributes['required'] ) && $attributes['required'] ) {
      $required = true;
    }

    if ( !empty( $attributes['selected'] ) ) {
      $selected = $attributes['selected'];
    }

    if ( !empty( $placeholder ) ) {
      $atts        = [
          'selected' => ($selected == ''),
          'value'    => '',
          'disabled' => $required,
      ];
      $placeholder = Tag::html( 'option', $placeholder, $atts );
    }

    unset( $attributes['placehonder'], $attributes['selected'], $attributes['required'] );

    $options .= self::options( $options, $selected );

    return HtmlBuilder::tag( 'select', $content, $attributes );
  }

  /**
   * Create a list of option tags from array .
   *
   * @since 1.0.0
   *
   * @param   array               $options
   * @param   string              $selected
   */
  public static function options( $options, $selected = '' ) {
    $_options = '';

    foreach ( $options as $key => $value ) {
      if ( is_array( $value ) ) {
        $_options .= Tag::html( 'optgroup', self::options( $value, $selected ), array( 'label' => $key ) );
      } else {
        $attributes = array(
            'value' => $key,
        );
        if ( !empty( $selected ) && ($selected == $key) ) {
          $attributes[] = 'selected';
        }
        $_options .= Tag::html( 'option', $value, $attributes );
      }
    }
    return $_options;
  }

  /**
   * Retrieves the alternative nonce hidden form field.
   *
   * @since 1.0.0
   *
   * @param   string    $action
   * @return  string
   */
  public static function create_nonce( $action ) {
    $nonce = wp_create_nonce( $action );
    return static::hidden( $nonce, '', [ 'data-nonce' => $nonce ] );
  }

  /**
   * Verify that alternative nonce is correct and unexpired with the respect to a specified action.
   *
   * @since 1.0.0
   *
   * @param   string    $action
   * @return  bool|int
   */
  public static function verify_nonce( $action ) {
    $nonce = wp_create_nonce( $action );
    $post  = filter_input( INPUT_POST, $nonce, FILTER_SANITIZE_STRING );
    $get   = filter_input( INPUT_GET, $nonce, FILTER_SANITIZE_STRING );
    $value = empty( $get ) ? $post : $get;
    return wp_verify_nonce( $value, $action );
  }

}
