<?php

namespace SourceFramework\Vendor\Bootstrap4;

// If this file is called directly, abort.
if ( !defined( 'ABSPATH' ) ) {
  die( 'Direct access is forbidden.' );
}

use SourceFramework\Template\Html;

/**
 * Bootstrap 4.x alert class
 *
 * @package       SourceFramework
 * @subpackage    Vendor\Bootstrap4
 *
 * @since         2.0.0
 * @see           http://getbootstrap.com/components/#alerts
 * @author        Javier Prieto
 */
class Alert {

  /**
   * Returns a Bootstrap alert component
   *
   * @since 2.0.0
   *
   * @see     https://getbootstrap.com/docs/4.0/components/alerts/
   *
   * @param     string                $heading
   * @param     string                $body
   * @param     string|array|object   $args
   * @return    string
   */
  public static function _alert( $heading = '', $body = '', $args = [] ) {
    $defaults = array(
        'role'        => 'alert',
        'class'       => "alert alert-primary",
        'dismissible' => true,
    );

    $args = wp_parse_args( $args, $defaults );

    $content = '';

    if ( $args['dismissible'] ) {
      $content       .= static::dismiss();
      $args['class'] .= ' alert-dismissible fade show';
    }
    unset( $args['dismissible'] );

    if ( $heading ) {
      $content .= sprintf( '<h4 class="alert-heading">%s</h4>', trim( $heading ) );
    }

    $content .= wpautop( make_clickable( trim( $body ) ) );

    // Set margin bottom to 0 in the last paragraph
    if ( ( $pos = strrpos( $content, '<p>' ) ) !== false ) {
      $search_length = strlen( '<p>' );
      $content       = substr_replace( $content, '<p class="mb-0">', $pos, $search_length );
    }

    $classes = explode( ' ', $args['class'] );

    if ( !in_array( 'alert', $classes ) ) {
      $classes[] = 'alert';
    }

    $attibutes['class'] = implode( ' ', $classes );

    return Html::tag( 'div', $content, $args );
  }

  /**
   * Returns a Bootstrap 4.x primary alert component
   *
   * @param     string                $heading
   * @param     string                $body
   * @param     string|array|object   $args
   * @return    string
   */
  public static function primary( $heading = '', $body = '', $args = [] ) {
    $defaults = array(
        'class' => 'alert-primary',
    );
    $args     = wp_parse_args( $args, $defaults );
    return self::_alert( $heading, $body, $args );
  }

  /**
   * Returns a Bootstrap 4.x secondary alert component
   *
   * @param     string                $heading
   * @param     string                $body
   * @param     string|array|object   $args
   * @return    string
   */
  public static function secondary( $heading = '', $body = '', $args = [] ) {
    $defaults = array(
        'class' => 'alert-secondary',
    );
    $args     = wp_parse_args( $args, $defaults );
    return self::_alert( $heading, $body, $args );
  }

  /**
   * Returns a Bootstrap 4.x success alert component
   *
   * @param     string                $heading
   * @param     string                $body
   * @param     string|array|object   $args
   * @return    string
   */
  public static function success( $heading = '', $body = '', $args = [] ) {
    $defaults = array(
        'class' => 'alert-success',
    );
    $args     = wp_parse_args( $args, $defaults );
    return self::_alert( $heading, $body, $args );
  }

  /**
   * Returns a Bootstrap 4.x danger alert component
   *
   * @param     string                $heading
   * @param     string                $body
   * @param     string|array|object   $args
   * @return    string
   */
  public static function danger( $heading = '', $body = '', $args = [] ) {
    $defaults = array(
        'class' => 'alert-danger',
    );
    $args     = wp_parse_args( $args, $defaults );
    return self::_alert( $heading, $body, $args );
  }

  /**
   * Returns a Bootstrap 4.x warning alert component
   *
   * @param     string                $heading
   * @param     string                $body
   * @param     string|array|object   $args
   * @return    string
   */
  public static function warning( $heading = '', $body = '', $args = [] ) {
    $defaults = array(
        'class' => 'alert-warning',
    );
    $args     = wp_parse_args( $args, $defaults );
    return self::_alert( $heading, $body, $args );
  }

  /**
   * Returns a Bootstrap 4.x info alert component
   *
   * @param     string                $heading
   * @param     string                $body
   * @param     string|array|object   $args
   * @return    string
   */
  public static function info( $heading = '', $body = '', $args = [] ) {
    $defaults = array(
        'class' => 'alert-info',
    );
    $args     = wp_parse_args( $args, $defaults );
    return self::_alert( $heading, $body, $args );
  }

  /**
   * Returns a Bootstrap 4.x light alert component
   *
   * @param     string                $heading
   * @param     string                $body
   * @param     string|array|object   $args
   * @return    string
   */
  public static function light( $heading = '', $body = '', $args = [] ) {
    $defaults = array(
        'class' => 'alert-light',
    );
    $args     = wp_parse_args( $args, $defaults );
    return self::_alert( $heading, $body, $args );
  }

  /**
   * Returns a Bootstrap 4.x dark alert component
   *
   * @param     string                $heading
   * @param     string                $body
   * @param     string|array|object   $args
   * @return    string
   */
  public static function dark( $heading = '', $body = '', $args = [] ) {
    $defaults = array(
        'class' => 'alert-dark',
    );
    $args     = wp_parse_args( $args, $defaults );
    return self::_alert( $heading, $body, $args );
  }

  /**
   * Bootstrap close button for modals and/or alerts
   *
   * @since   2.0.0
   *
   * @param   string    $component
   * @return  string
   */
  public static function dismiss() {
    $format = '<button type="button" class="close" data-dismiss="alert" aria-label="%s"><span aria-hidden="true">&times;</span></button>';
    return sprintf( $format, __( 'Close', SF_TEXTDOMAIN ) );
  }

}
