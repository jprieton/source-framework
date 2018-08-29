<?php

namespace SourceFramework\Template;

// If this file is called directly, abort.
if ( !defined( 'ABSPATH' ) ) {
  die( 'Direct access is forbidden.' );
}

use SourceFramework\Template\Html;
use WP_Locale;

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
 * @author      Javier Prieto
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
    return Html::tag( 'label', $label, $attributes );
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
  public static function input( $attributes = array() ) {
    $defaults   = array(
        'name'  => '',
        'value' => '',
        'type'  => 'text'
    );
    $attributes = wp_parse_args( $attributes, $defaults );

    return Html::tag( 'input', null, $attributes );
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

    return Html::tag( 'button', $label, $attributes );
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
    $type       = 'hidden';
    $attributes = array_merge( $attributes, compact( 'name', 'value', 'type' ) );
    return static::input( $attributes );
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
    $type       = 'text';
    $attributes = array_merge( $attributes, compact( 'name', 'value', 'type' ) );
    return static::input( $attributes );
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
    $type       = 'email';
    $attributes = array_merge( $attributes, compact( 'name', 'value', 'type' ) );
    return static::input( $attributes );
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
    $type       = 'url';
    $attributes = array_merge( $attributes, compact( 'name', 'value', 'type' ) );
    return static::input( $attributes );
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
    $type       = 'password';
    $attributes = array_merge( $attributes, compact( 'name', 'type' ) );
    return static::input( $attributes );
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
    $type       = 'file';
    $attributes = array_merge( $attributes, compact( 'name', 'value', 'type' ) );
    return static::input( $attributes );
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
  public static function select( $attributes = [], $options = [] ) {
    $placeholder = '';
    $required    = false;
    $selected    = '';

    if ( !empty( $attributes['placeholder'] ) && !is_bool( $attributes['placeholder'] ) ) {
      $placeholder = $attributes['placeholder'];
    } elseif ( !empty( $attributes['placeholder'] ) && is_bool( $attributes['placeholder'] ) && $attributes['placeholder'] ) {
      $placeholder = __( 'Select...', SF_TEXTDOMAIN );
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
      $placeholder = Html::tag( 'option', $placeholder, $atts );
    }

    unset( $attributes['placeholder'], $attributes['selected'], $attributes['required'] );

    return Html::tag( 'select', $placeholder . self::options( $options, $selected ), $attributes );
  }

  /**
   * Create a list of option tags from array .
   *
   * @since 1.0.0
   *
   * @global WP_Locale            $wp_locale
   *
   * @param  array|string         $options
   * @param  array                $selected
   * @return string
   */
  public static function options( $options, $selected = '' ) {
    global $wp_locale;

    $_options = '';

    switch ( $options ) {
      case 'month':
        $options = $wp_locale->month;
        break;
      case 'weekday':
        $options = $wp_locale->weekday;
        break;
      default:
        $options = (array) $options;
        break;
    }

    foreach ( $options as $key => $value ) {
      if ( is_array( $value ) ) {
        $_options .= Html::tag( 'optgroup', self::options( $value, $selected ), array( 'label' => $key ) );
      } else {
        $attributes = [
            'value'    => $key,
            'selected' => (!empty( $selected ) && $selected == $key) ? 'selected' : false,
        ];
        $_options .= Html::tag( 'option', $value, $attributes );
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
