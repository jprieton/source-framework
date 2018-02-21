<?php

namespace SourceFramework\Vendor\Bootstrap;

// If this file is called directly, abort.
if ( !defined( 'ABSPATH' ) ) {
  die( 'Direct access is forbidden.' );
}

use SourceFramework\Template\Html;

/**
 * Bootstrap Alert class
 *
 * @package        SourceFramework
 * @subpackage     Vendor
 * @subpackage     Bootstrap
 * @since          2.0.0
 * @author         Javier Prieto
 */
class Alert {

  private $dismiss    = '';
  private $heading    = '';
  private $body       = '';
  private $icon       = '';
  private $attributes = '';

  /**
   * 
   * @param type $type
   * @param type $attributes
   */
  public function __construct( $type = 'primary', $attributes = [] ) {
    $defaults = array(
        'heading'     => '',
        'body'        => '',
        'role'        => 'alert',
        'class'       => "alert alert-{$type}",
        'dismissible' => true,
    );

    $this->attributes = wp_parse_args( $attributes, $defaults );

    $this->set_dismissible( $this->attributes['dismissible'] );
    $this->set_body( $this->attributes['body'] );
    $this->set_heading( $this->attributes['heading'] );

    $unset = [
        'body'        => '',
        'heading'     => '',
        'dismissible' => ''
    ];

    $this->attributes = array_diff_key( $this->attributes, $unset );
  }

  /**
   * Render the alert
   * 
   * @since   2.0.0
   * 
   * @return  string
   */
  public function render() {
    return Html::tag( 'div', $this->dismiss . $this->icon . $this->heading . $this->body, $this->attributes );
  }

  /**
   * Set the alert heading
   * 
   * @since   2.0.0
   * 
   * @param   string    $content
   */
  public function set_heading( $content = '' ) {
    $this->heading = $content ? Html::tag( 'h4.alert-heading', $content ) : '';
  }

  /**
   * Set the alert body
   * 
   * @since   2.0.0
   * 
   * @param   string    $content
   */
  public function set_body( $content ) {
    $this->body = wptexturize( trim( $content ) );
  }

  /**
   * Close button for modal
   * 
   * @since   2.0.0
   * 
   * @param   bool    $dismissible  Set if the alert is dismissible
   * @return  string
   */
  public function set_dismissible( $dismissible = true ) {
    if ( $dismissible ) {
      if ( strpos( $this->attributes['class'], 'alert-dismissible' ) === false ) {
        $this->attributes['class'] .= ' alert-dismissible fade show';
      }
      $span          = Html::span( '&times;', [ 'aria-hidden' => 'true' ] );
      $this->dismiss = Html::tag( 'button.close', $span, [
                  'type'         => 'button',
                  'data-dismiss' => 'alert',
                  'aria-label'   => __( 'Close', SF_TEXTDOMAIN )
              ] );
    } else {
      $this->dismiss = '';
    }
  }

}
