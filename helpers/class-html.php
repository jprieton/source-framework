<?php

/**
 * If this file is called directly, abort.
 */
if ( !defined( 'ABSPATH' ) ) {
  die( 'Direct access is forbidden.' );
}

namespace SourceFramework\Helpers;

/**
 * Html class
 *
 * Based on Laravel Forms & HTML helper and Yii Framework BaseHtml helper
 *
 * @package Helper
 *
 * @since   1.0.0
 * @see     https://laravelcollective.com/docs/master/html
 * @see     http://www.yiiframework.com/doc-2.0/yii-helpers-basehtml.html
 *
 * @author         Javier Prieto <jprieton@gmail.com>
 */
class Html {

  /**
   * @see http://w3c.github.io/html/syntax.html#void-elements
   *
   * @var array List of void elements.
   */
  public static $void = array(
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
  public static function tag( $tag, $content = '', $attributes = array() ) {
    $tag        = esc_attr( $tag );
    $attributes = self::attributes( $attributes );
    self::emmet( $tag, $attributes );

    if ( in_array( $tag, self::$void ) ) {
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
  public static function attributes( $attributes = array() ) {
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
  public static function emmet( &$tag, &$attributes = array() ) {
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
   * Retrieve a HTML open tag
   *
   * @since   1.0.0
   *
   * @param   string              $tag
   * @param   array|string        $attributes
   * @return  string
   */
  public static function open_tag( $tag, $attributes = array() ) {
    $tag        = esc_attr( $tag );
    $attributes = self::attributes( $attributes );
    self::emmet( $tag, $attributes );

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
  public static function close_tag( $tag ) {
    return sprintf( '</%s>', trim( esc_attr( $tag ) ) );
  }

  /**
   * Retrieve a HTML close tag
   *
   * @since   1.0.0
   *
   * @param   string              $tag
   * @return  string
   */
  public static function void_tag( $tag, $attributes = array() ) {
    $tag        = trim( esc_attr( $tag ) );
    $attributes = self::attributes( $attributes );
    self::emmet( $tag, $attributes );

    return sprintf( '<%s />', trim( $tag . ' ' . $attributes ) );
  }

  /**
   * Retrieve a HTML link
   *
   * @since   1.0.0
   *
   * @param   string              $text
   * @param   string              $href
   * @param   array|string        $attributes
   * @return  string
   */
  public static function a( $text, $href = '#', $attributes = array() ) {
    $attributes          = self::attributes( $attributes );
    $attributes ['href'] = $href;

    return self::tag( 'a', $text, $attributes );
  }

  /**
   * Retrieve an HTML style element. Is recommended enqueue the script using <i>wp_register_script</i> and/or
   * <i>wp_enqueue_script</i> because it is the method recommended by WordPress Guidelines.
   *
   * @since   1.0.0
   * @see     https://developer.wordpress.org/themes/basics/including-css-javascript/
   *
   * @param   string              $href
   * @param   string|array        $attributes
   *
   * @return  string
   */
  public static function link( $href, $attributes = array() ) {
    $defaults   = array(
        'href'  => $href,
        'rel'   => 'stylesheet',
        'type'  => 'text/css',
        'media' => 'all',
    );
    $attributes = wp_parse_args( $attributes, $defaults );

    return self::void_tag( 'link', $attributes );
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

    return self::void_tag( 'img', $attributes );
  }

  /**
   * Generate an un-ordered list of items.
   *
   * @since   1.0.0
   *
   * @param   array               $items
   * @param   array|string        $attributes
   *
   * @return  string
   */
  public static function ul( $items, $attributes = array() ) {
    $html = '';

    if ( !is_array( $items ) || count( $items ) == 0 ) {
      return $html;
    }

    foreach ( $items as $key => $value ) {
      if ( is_array( $value ) ) {
        $value = $key . self::ul( $value );
      }
      $html .= self::tag( 'li', $value );
    }

    return self::tag( 'ul', $html, $attributes );
  }

  /**
   * Generate an ordered list of items.
   *
   * @since   1.0.0
   *
   * @param   array               $items
   * @param   array|string        $attributes
   *
   * @return  string
   */
  public static function ol( $items, $attributes = array() ) {
    $html = '';

    if ( count( $items ) == 0 ) {
      return $html;
    }

    foreach ( $items as $key => $value ) {
      if ( is_array( $value ) ) {
        $value = $key . self::ol( $value );
      }
      $html .= self::tag( 'li', $value );
    }

    return self::tag( 'ol', $html, $attributes );
  }

}
