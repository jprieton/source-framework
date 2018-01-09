<?php

namespace SourceFramework\Template\Bootstrap4;

/**
 * If this file is called directly, abort.
 */
if ( !defined( 'ABSPATH' ) ) {
  die( 'Direct access is forbidden.' );
}

use SourceFramework\Template\Tag;

/**
 * Dropdown class
 *
 * @package        Template
 * @subpackage     Bootstrap4
 *
 * @since          1.3.2
 * @see            https://getbootstrap.com/docs/4.0/components/dropdowns/
 * @author         Javier Prieto <jprieton@gmail.com>
 */
class Dropdown {

  /**
   * @since       1.3.2
   * @access      private
   * @var         string
   */
  private $id;

  /**
   * @since       1.3.2
   * @access      private
   * @var         string
   */
  private $button;

  /**
   * @since       1.3.2
   * @access      private
   * @var         array
   */
  private $items = array();

  /**
   * Class constructor
   *
   * @since       1.3.2
   * @staticvar   int     $id
   */
  public function __construct() {
    static $id;

    if ( empty( $id ) ) {
      $id = 0;
    }

    $id++;

    $this->id = (string) $id;
  }

  /**
   * Add dropdown label
   *
   * @since   1.3.2
   * @param   string    $label
   * @param   array     $atts
   */
  public function add_label( $label, $atts = array() ) {

    $defaults = array(
        'id'            => "dropdownMenuButton{$this->id}",
        'data-toggle'   => 'dropdown',
        'aria-haspopup' => 'true',
        'aria-expanded' => 'false',
        'type'          => 'button',
        'class'         => 'btn btn-secondary dropdown-toggle',
    );

    $atts = wp_parse_args( $atts, $defaults );

    $this->id = $atts['id'];

    if ( 'link' == $atts['type'] ) {
      unset( $atts['type'] );
      $atts['href'] = '#';
      $this->button = Tag::html( 'a', $label, $atts );
    } else {
      $this->button = Tag::html( 'button', $label, $atts );
    }
  }

  /**
   * Add divider to dropdown
   *
   * @since   1.3.2
   */
  public function add_divider() {
    $this->items[] = Tag::html( 'div.dropdown-divider' );
  }

  /**
   * Add link item to dropdown
   *
   * @since   1.3.2
   *
   * @param   string    $label
   * @param   string    $href
   * @param   array     $atts
   */
  public function add_item( $label, $href = '#', $atts = array() ) {
    $defaults = array(
        'class' => 'dropdown-item',
        'href'  => esc_url( $href ),
    );

    $atts          = wp_parse_args( $atts, $defaults );
    $this->items[] = Tag::html( 'a', $label, $atts );
  }

  /**
   * Render the dropdown
   *
   * @since   1.3.2
   * 
   * @param   array   $atts
   * @return  string
   */
  public function render( $atts = array() ) {
    $defaults = array(
        'class' => 'dropdown',
    );
    $atts     = wp_parse_args( $atts, $defaults );

    $content = "\n\t{$this->button}\n\t" . Tag::html( 'div.dropdown-menu', implode( "\n\t\t", $this->items ), array( 'aria-labelledby' => $this->id ) );

    return Tag::html( 'div', $content, $atts );
  }

}
