<?php

namespace SourceFramework\Builders;

/**
 * If this file is called directly, abort.
 */
if ( !defined( 'ABSPATH' ) ) {
  die( 'Direct access is forbidden.' );
}

/**
 * Html Builder class
 *
 * Singleton class Based on Laravel Forms & HTML helper and Yii Framework BaseHtml helper
 *
 * @package Builder
 *
 * @since   1.0.0
 * @see     https://laravelcollective.com/docs/master/html
 * @see     http://www.yiiframework.com/doc-2.0/yii-helpers-basehtml.html
 *
 * @author         Javier Prieto <jprieton@gmail.com>
 */
class Html_Builder {

  /**
   * Static instance of this class
   *
   * @since         1.0.0
   * @var           Html
   */
  protected static $instance;

  /**
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
   * @see http://w3c.github.io/html/syntax.html#void-elements
   *
   * @var array List of void elements.
   */
  public $void = array(
      'area', 'base', 'br', 'col', 'embed', 'hr', 'img', 'input',
      'link', 'menuitem', 'meta', 'param', 'source', 'track', 'wbr'
  );

  /**
   * Retrieve a HTML complete tag
   *
   * @since   1.0.0
   *
   * @param   string              $tag
   * @param   string              $content
   * @param   array|string        $attributes
   * @return  string
   */
  public function tag( $tag, $content = '', $attributes = array() ) {
    $tag        = esc_attr( $tag );
    $this->shorthand( $tag, $attributes );
    $attributes = $this->attributes( $attributes );

    if ( in_array( $tag, $this->void ) ) {
      $html_tag = sprintf( '<%s />', trim( $tag . ' ' . $attributes ) );
    } else {
      $html_tag = sprintf( '<%s>%s</%s>', trim( $tag . ' ' . $attributes ), $content, $tag );
    }

    return $html_tag;
  }

  /**
   * Convert an array to HTML attributes
   *
   * @since   1.0.0
   *
   * @param   array|string        $attributes
   * @return  string
   *
   */
  public function attributes( $attributes = array() ) {
    $attributes = wp_parse_args( $attributes );

    if ( count( $attributes ) == 0 ) {
      return '';
    }

    $_attributes = array();

    foreach ( (array) $attributes as $key => $value ) {
      if ( is_numeric( $key ) && !is_bool( $value ) ) {
        $key = $value;
      }

      if ( is_bool( $value ) && $value ) {
        $value = $key;
      }

      if ( is_bool( $value ) && !$value ) {
        continue;
      }

      if ( is_array( $value ) ) {
        $value = implode( ' ', $value );
      }

      if ( !is_null( $value ) ) {
        $_attributes[] = sprintf( '%s="%s"', trim( esc_attr( $key ) ), trim( esc_attr( $value ) ) );
      }
    }

    return implode( ' ', $_attributes );
  }

  /**
   * Parse a emmet snippet for single element (beta).
   * Current only support class and id attributes.
   *
   * @since   1.0.0
   *
   * @param   string              $tag
   * @param   array               $attributes
   * @return  array
   */
  public function shorthand( &$tag, &$attributes = array() ) {
    $matches = array();
    preg_match( '(#|\.)', $tag, $matches );

    if ( empty( $matches ) ) {
      // isn't shorthand, do nothing
      return;
    }

    $items = str_replace( array( '.', '#' ), array( ' .', ' #' ), $tag );
    $items = explode( ' ', $items );

    $tag   = $items[0];
    $id    = null;
    $class = null;

    foreach ( $items as $item ) {
      if ( strpos( $item, '#' ) !== false ) {
        $id = trim( str_replace( '#', '', $item ) );
      } elseif ( strpos( $item, '.' ) !== false ) {
        $class .= ' ' . trim( str_replace( '.', '', $item ) );
      }
    }

    if ( $id && empty( $attributes['id'] ) ) {
      $attributes['id'] = $id;
    }

    if ( $class && empty( $attributes['class'] ) ) {
      $attributes['class'] = $class;
    }
  }

}
