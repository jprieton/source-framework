<?php

namespace SourceFramework\Template;

// If this file is called directly, abort.
if ( !defined( 'ABSPATH' ) ) {
  die( 'Direct access is forbidden.' );
}

/**
 * Html class
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
 * @author         Javier Prieto
 */
class Html {

  /**
   * @see http://w3c.github.io/html/syntax.html#void-elements
   *
   * @var array List of void elements.
   * @since   1.0.0
   */
  private static $void = [
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
  public static function open( $tag, $attributes = [] ) {
    $tag = esc_attr( $tag );
    if ( empty( $tag ) ) {
      return '';
    }
    static::parse_shorthand( $tag, $attributes );
    $attributes = static::parse_attributes( $attributes );

    if ( in_array( $tag, static::$void ) ) {
      $html = sprintf( '<%s />', trim( $tag . ' ' . $attributes ) );
    } else {
      $html = sprintf( '<%s>', trim( $tag . ' ' . $attributes ) );
    }

    return $html;
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
    if ( empty( $tag ) ) {
      return '';
    }
    return in_array( $tag, static::$void ) ? '' : sprintf( '</%s>', trim( esc_attr( $tag ) ) );
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
  public static function tag( $tag, $content = '', $attributes = [] ) {
    $tag        = esc_attr( $tag );
    static::parse_shorthand( $tag, $attributes );
    $attributes = static::parse_attributes( $attributes );

    if ( in_array( $tag, static::$void ) ) {
      $html = sprintf( '<%s />', trim( $tag . ' ' . $attributes ) );
    } else {
      $html = sprintf( '<%s>%s</%s>', trim( $tag . ' ' . $attributes ), $content, $tag );
    }

    return $html;
  }

  /**
   * Retrieve a HTML link
   *
   * @since   1.0.0
   *
   * @param   string              $href
   * @param   string              $text
   * @param   array|string        $attributes
   * @return  string
   */
  public static function a( $href, $text = '', $attributes = [] ) {
    return self::tag( 'a', (string) $text, wp_parse_args( $attributes, compact( 'href' ) ) );
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
  public static function img( $src, $attributes = [] ) {
    if ( 'pixel' == $src ) {
      $src = 'data:image/gif;base64,R0lGODlhAQABAIAAAP///wAAACH5BAEAAAAALAAAAAABAAEAAAICRAEAOw==';
    }

    // avoid overrides if $src is defined
    if ( !empty( $src ) ) {
      unset( $attributes['src'] );
    }

    $attributes = wp_parse_args( $attributes, compact( 'src' ) );

    return static::tag( 'img', '', $attributes );
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
  public static function parse_attributes( $attributes = [] ) {
    $attributes = wp_parse_args( $attributes );

    if ( count( $attributes ) == 0 ) {
      return '';
    }

    $_attributes = [];

    foreach ( (array) $attributes as $key => $value ) {
      if ( is_numeric( $key ) && !is_bool( $value ) ) {
        $key   = $value;
        $value = null;
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
      } else {
        $_attributes[] = trim( esc_attr( $key ) );
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
  public static function parse_shorthand( &$tag, &$attributes = [] ) {
    $matches = [];
    preg_match( '(#|\.)', $tag, $matches );

    if ( empty( $matches ) ) {
      // isn't shorthand, do nothing
      return;
    }

    $items = str_replace( [ '.', '#' ], [ ' .', ' #' ], $tag );
    $items = explode( ' ', $items );

    $tag   = !empty( $items[0] ) ? $items[0] : 'div';
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
  public static function mailto( $email, $text = null, $attributes = [] ) {
    if ( empty( $email ) || !is_email( $email ) ) {
      return '';
    }

    $text  = $text ?: antispambot( $email );
    $email = antispambot( 'mailto:' . $email );

    $defaults   = [
        'href' => $email,
    ];
    $attributes = wp_parse_args( $attributes, $defaults );

    return static::tag( 'a', $text, $attributes );
  }

  /**
   * Generate a HTML-formatted unordered list
   *
   * @since   1.5.0
   *
   * @param   array|string        $list
   * @param   array|string        $attributes
   * @return  string
   */
  public static function ul( $list, $attributes = [] ) {
    $content = '';

    foreach ( (array) $list as $key => $item ) {
      if ( is_array( $item ) ) {
        $content .= static::tag( 'li', $key . static::ul( $item ) );
      } else {
        $content .= static::tag( 'li', $item );
      }
    }

    $content = static::tag( 'ul', $content, $attributes );
    return $content;
  }

  /**
   * Generate a HTML-formatted ordered list
   *
   * @since   1.5.0
   *
   * @param   array|string        $list
   * @param   array|string        $attributes
   * @return  string
   */
  public static function ol( $list, $attributes = [] ) {
    $content = '';

    foreach ( (array) $list as $key => $item ) {
      if ( is_array( $item ) ) {
        $content .= static::tag( 'li', $key . static::ol( $item ) );
      } else {
        $content .= static::tag( 'li', $item );
      }
    }

    $content = static::tag( 'ol', $content, $attributes );
    return $content;
  }

  /**
   * Magic method for tags
   * 
   * @since   2.0.0
   * 
   * @param   string    $tag
   * @param   array     $arguments
   * @return  string
   */
  public static function __callStatic( $tag, $arguments ) {
    list($content, $attributes) = $arguments + [ '', '' ];
    return static::tag( $tag, $content, $attributes );
  }

}
