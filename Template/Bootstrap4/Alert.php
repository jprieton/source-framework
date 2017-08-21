<?php

namespace SourceFramework\Template\Bootstrap3;

/**
 * If this file is called directly, abort.
 */
if ( !defined( 'ABSPATH' ) ) {
  die( 'Direct access is forbidden.' );
}

use SourceFramework\Template\Tag;

/**
 * Pagination class
 *
 * @package        Template
 * @subpackage     Bootstrap4
 *
 * @since          1.0.0
 * @see            https://getbootstrap.com/docs/4.0/components/alerts/
 *
 * @author         Javier Prieto <jprieton@gmail.com>
 */
class Alert {

  /**
   * Retrieve a Bootstrap alert component
   *
   * @since 0.5.0
   *
   * @param   string              $content
   * @param   string|array        $attr
   *
   * @return  string
   */
  public static function alert( $content, $attr = array() ) {
    $defaults = [
        'dismiss' => true,
        'role'    => 'alert',
        'class'   => 'alert ',
    ];
    $attr     = wp_parse_args( $attr, $defaults );

    if ( $attr['dismiss'] ) {
      $dismiss       = '<button type="button" class="close" data-dismiss="alert" aria-label="' . __( 'Close', \SourceFramework\TEXTDOMAIN ) . '">'
              . '<span aria-hidden="true">&times;</span>'
              . '</button>';
      $attr['class'] .= ' alert-dismissible ';
    } else {
      $dismiss = '';
    }
    unset( $attr['dismiss'] );

    return Tag::html( 'div', $dismiss . $content, $attr );
  }

  /**
   * Retrieve a Bootstrap primary alert component
   *
   * @since 1.0.0
   *
   * @param   string              $content
   * @param   string|array        $attr
   *
   * @return  string
   */
  public static function primary( $content, $attr = array() ) {
    $defaults   = array(
        'class' => 'alert-primary',
    );
    $attr = wp_parse_args( $attr, $defaults );

    return self::alert( $content, $attr );
  }

  /**
   * Retrieve a Bootstrap secondary alert component
   *
   * @since 1.0.0
   *
   * @param   string              $content
   * @param   string|array        $attr
   *
   * @return  string
   */
  public static function secondary( $content, $attr = array() ) {
    $defaults   = array(
        'class' => 'alert-secondary',
    );
    $attr = wp_parse_args( $attr, $defaults );

    return self::alert( $content, $attr );
  }

  /**
   * Retrieve a Bootstrap success alert component
   *
   * @since 1.0.0
   *
   * @param   string              $content
   * @param   string|array        $attr
   *
   * @return  string
   */
  public static function success( $content, $attr = array() ) {
    $defaults   = array(
        'class' => 'alert-success',
    );
    $attr = wp_parse_args( $attr, $defaults );

    return self::alert( $content, $attr );
  }

  /**
   * Retrieve a Bootstrap danger alert component
   *
   * @since 1.0.0
   *
   * @param   string              $content
   * @param   string|array        $attr
   *
   * @return  string
   */
  public static function danger( $content, $attr = array() ) {
    $defaults   = array(
        'class' => 'alert-danger',
    );
    $attr = wp_parse_args( $attr, $defaults );

    return self::alert( $content, $attr );
  }

  /**
   * Retrieve a Bootstrap warning alert component
   *
   * @since 1.0.0
   *
   * @param   string              $content
   * @param   string|array        $attr
   *
   * @return  string
   */
  public static function warning( $content, $attr = array() ) {
    $defaults   = array(
        'class' => 'alert-warning',
    );
    $attr = wp_parse_args( $attr, $defaults );

    return self::alert( $content, $attr );
  }

  /**
   * Retrieve a Bootstrap info alert component
   *
   * @since 1.0.0
   *
   * @param   string              $content
   * @param   string|array        $attr
   *
   * @return  string
   */
  public static function info( $content, $attr = array() ) {
    $defaults   = array(
        'class' => 'alert-info',
    );
    $attr = wp_parse_args( $attr, $defaults );

    return self::alert( $content, $attr );
  }

  /**
   * Retrieve a Bootstrap light alert component
   *
   * @since 1.0.0
   *
   * @param   string              $content
   * @param   string|array        $attr
   *
   * @return  string
   */
  public static function light( $content, $attr = array() ) {
    $defaults   = array(
        'class' => 'alert-light',
    );
    $attr = wp_parse_args( $attr, $defaults );

    return self::alert( $content, $attr );
  }

  /**
   * Retrieve a Bootstrap dark alert component
   *
   * @since 1.0.0
   *
   * @param   string              $content
   * @param   string|array        $attr
   *
   * @return  string
   */
  public static function dark( $content, $attr = array() ) {
    $defaults   = array(
        'class' => 'alert-dark',
    );
    $attr = wp_parse_args( $attr, $defaults );

    return self::alert( $content, $attr );
  }

}
