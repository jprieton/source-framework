<?php

namespace SourceFramework\Template\Bootstrap3;

/**
 * If this file is called directly, abort.
 */
if ( !defined( 'ABSPATH' ) ) {
  die( 'Direct access is forbidden.' );
}

namespace SMGDevTools\Vendor\Bootstrap;

use SMGDevTools\Helpers\HtmlBuilder as Html;
use SMGDevTools\Vendor\Bootstrap\Misc;
use SourceFramework\Template\Tag;

/**
 * Pagination class
 *
 * @package        Template
 * @subpackage     Bootstrap
 *
 * @since          0.5.0
 * @see            http://getbootstrap.com/docs/3.3/components/#alert
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
   * @param   string|array        $attributes
   *
   * @return  string
   */
  public static function alert( $content, $attributes = array() ) {
    $defaults = array(
        'dismiss' => true,
        'role'    => 'alert',
        'class'   => '',
        'icon'    => '',
    );

    $attributes = wp_parse_args( $attributes, $defaults );

    // Alert icon span
    $icon = '';
    if ( $attributes['icon'] ) {
      $icon = Tag::html( 'span', null, array( 'aria-hidden' => 'true', 'class' => $attributes['icon'] ) );
    }
    unset( $attributes['icon'] );

    // Dimissible button
    $dismiss = '';
    if ( $attributes['dismiss'] ) {
      $dismiss = Misc::dismiss( 'modal' );
    }
    unset( $attributes['dismiss'] );

    $attributes['class'] .= ' alert';

    return Tag::html( 'div', $icon . $dismiss . $content, $attributes );
  }

  /**
   * Retrieve a Bootstrap success alert component
   *
   * @since 0.5.0
   *
   * @param   string              $content
   * @param   string|array        $attributes
   *
   * @return  string
   */
  public static function success( $content, $attributes = array() ) {
    $defaults   = array(
        'class' => 'alert-success',
    );
    $attributes = wp_parse_args( $attributes, $defaults );

    return self::alert( $content, $attributes );
  }

  /**
   * Retrieve a Bootstrap info alert component
   *
   * @since 0.5.0
   *
   * @param   string              $content
   * @param   string|array        $attributes
   *
   * @return  string
   */
  public static function info( $content, $attributes = array() ) {
    $defaults   = array(
        'class' => 'alert-info',
    );
    $attributes = wp_parse_args( $attributes, $defaults );

    return self::alert( $content, $attributes );
  }

  /**
   * Retrieve a Bootstrap warning alert component
   *
   * @since 0.5.0
   *
   * @param   string              $content
   * @param   string|array        $attributes
   *
   * @return  string
   */
  public static function warning( $content, $attributes = array() ) {
    $defaults   = array(
        'class' => 'alert-warning',
    );
    $attributes = wp_parse_args( $attributes, $defaults );

    return self::alert( $content, $attributes );
  }

  /**
   * Retrieve a Bootstrap danger alert component
   *
   * @since 0.5.0
   *
   * @param   string              $content
   * @param   string|array        $attributes
   *
   * @return  string
   */
  public static function danger( $content, $attributes = array() ) {
    $defaults   = array(
        'class' => 'alert-danger',
    );
    $attributes = wp_parse_args( $attributes, $defaults );

    return self::alert( $content, $attributes );
  }

  /**
   * Bootstrap close button for modals and/or alerts
   *
   * @since   0.5.0
   *
   * @param   string              $data_dismiss
   * @return  string
   */
  public static function dismiss( $data_dismiss ) {
    $span   = HTML::tag( 'span', '&times;', 'aria-hidden=true' );
    $button = HTML::tag( 'button.close', $span, array(
                'type'         => 'button',
                'data-dismiss' => $data_dismiss,
                'aria-label'   => __( 'Close', 'smgdevtools' )
            ) );

    return $button;
  }

}
