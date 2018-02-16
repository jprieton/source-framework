<?php

namespace SourceFramework\Template;

// If this file is called directly, abort.
if ( !defined( 'ABSPATH' ) ) {
  die( 'Direct access is forbidden.' );
}

/**
 * Class to generate admin notices
 *
 * @package        SourceFramework
 * @subpackage     Template
 * @since          1.5.0
 * @author         Javier Prieto
 */
class AdminNotice {

  /**
   * Admin notice message
   *
   * @since   1.5.0
   * @var     string
   */
  private $message;

  /**
   * Admin notice css class
   *
   * @since   1.5.0
   * @var     string
   */
  private $class;

  /**
   * Class constructor
   *
   * Creates and hook admin notice
   *
   * @since   1.5.0
   * @param   string    $message
   * @param   array     $attr
   */
  public function __construct( $message, $attr = [] ) {
    $defaults = [
        'type'        => '',
        'dismissible' => false,
    ];
    $attr     = wp_parse_args( $attr, $defaults );

    switch ( $attr['type'] ) {
      case 'error':
        $this->class = 'notice notice-error';
        break;

      case 'warning':
        $this->class = 'notice notice-warning';
        break;

      case 'success':
        $this->class = 'notice notice-success';
        break;

      case 'info':
        $this->class = 'notice notice-info';
        break;

      default:
        $this->class = 'notice';
        break;
    }

    if ( $attr['dismissible'] ) {
      $this->class .= ' is-dismissible';
    }

    $this->message = wpautop( make_clickable( $message ) );
    add_action( 'admin_notices', [ $this, 'show_admin_notice' ] );
  }

  /**
   * Hooked function to show admin notice
   *
   * @since   1.5.0
   */
  public function show_admin_notice() {
    printf( '<div class="%1$s">%2$s</div>', $this->class, $this->message );
  }

}
