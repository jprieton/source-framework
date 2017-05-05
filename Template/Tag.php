<?php

namespace SourceFramework\Template;

/**
 * If this file is called directly, abort.
 */
if ( !defined( 'ABSPATH' ) ) {
  die( 'Direct access is forbidden.' );
}

/**
 * Tag class
 *
 * Class based on Laravel Forms & HTML helper and Yii Framework BaseHtml helper
 *
 * @package Template
 *
 * @since   1.0.0
 * @see     https://laravelcollective.com/docs/master/html
 * @see     http://www.yiiframework.com/doc-2.0/yii-helpers-basehtml.html
 * @see     https://docs.phalconphp.com/en/latest/reference/tags.html#tag-service
 *
 * @author         Javier Prieto <jprieton@gmail.com>
 */
class Tag {

  /**
   * @see http://w3c.github.io/html/syntax.html#void-elements
   *
   * @var array List of void elements.
   * @since   1.0.0
   */
  public static $void = [
      'area', 'base', 'br', 'col', 'embed', 'hr', 'img', 'input',
      'link', 'menuitem', 'meta', 'param', 'source', 'track', 'wbr'
  ];

  /**
   * Retrieve a HTML open tag
   *
   * @since   1.0.0
   *
   * @param   string              $tag
   * @param   array|string        $attributes
   * @return  string
   */
  public static function open( $tag, $attributes = array() ) {
    $tag        = esc_attr( $tag );
    static::parse_shorthand( $tag, $attributes );
    $attributes = static::parse_attributes( $attributes );

    return sprintf( '<%s>', trim( $tag . ' ' . $attributes ) );
  }

  /**
   * Retrieve a HTML close tag
   *
   * @since   1.0.0
   *
   * @param   string              $tag
   * @return  string
   */
  public static function close( $tag ) {
    return sprintf( '</%s>', trim( esc_attr( $tag ) ) );
  }

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
  public static function html( $tag, $content = '', $attributes = array() ) {
    $tag        = esc_attr( $tag );
    static::parse_shorthand( $tag, $attributes );
    $attributes = static::parse_attributes( $attributes );

    if ( in_array( $tag, static::void ) ) {
      $html = sprintf( '<%s />', trim( $tag . ' ' . $attributes ) );
    } else {
      $html = sprintf( '<%s>%s</%s>', trim( $tag . ' ' . $attributes ), $content, $tag );
    }

    return $html;
  }

  /**
   * Retrieve an HTML img element
   *
   * @since 1.0.0
   *
   * @param   string              $src
   * @param   string|array        $attributes
   *
   * @see     http://png-pixel.com/
   *
   * @return  string
   */
  public static function img( $src, $attributes = array() ) {
    if ( 'pixel' == $src ) {
      $src = 'data:image/gif;base64,R0lGODlhAQABAIAAAP///wAAACH5BAEAAAAALAAAAAABAAEAAAICRAEAOw==';
    }
    $attributes = wp_parse_args( $attributes, compact( 'src' ) );

    return static::html( 'img', '', $attributes );
  }

  /**
   * Convert an asociative array to HTML attributes
   *
   * @since   1.0.0
   *
   * @param   array|string        $attributes
   * @return  string
   *
   */
  public static function parse_attributes( $attributes = array() ) {
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
   * Parse a shorthand for single element (beta).
   *
   * @since   1.0.0
   *
   * @param   string              $tag
   * @param   array               $attributes
   * @return  array
   */
  public static function parse_shorthand( &$tag, &$attributes = array() ) {
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

  /**
   * Generate a HTML link to an email address.
   *
   * @since   1.0.0
   *
   * @param   string              $email
   * @param   string              $text
   * @param   array|string        $attributes
   * @return  string
   */
  public static function mailto( $email, $text = null, $attributes = array() ) {
    if ( empty( $email ) || !is_email( $email ) ) {
      return '';
    }

    $email = obfuscate_email( $email );
    $text  = $text ?: $email;
    $email = obfuscate( 'mailto:' ) . $email;

    $defaults   = array(
        'href' => $email
    );
    $attributes = wp_parse_args( $attributes, $defaults );

    return static::html( 'a', $text, $attributes );
  }

}
