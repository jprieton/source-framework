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
 * Bootstrap modal class
 *
 * @package        Template
 * @subpackage     Bootstrap3
 *
 * @since          0.5.0
 * @see            http://getbootstrap.com/javascript/#modals
 *
 * @author         Javier Prieto <jprieton@gmail.com>
 */
class Modal {

  /**
   * Modal attributes
   *
   * @since   0.5.0
   *
   * @var array
   */
  private $attributes;

  /**
   * Modal body text
   *
   * @since   0.5.0
   *
   * @var string
   */
  private $body;

  /**
   * Bootstrap modal's constructor
   *
   * @since   0.5.0
   *
   * @param   array|string   $attributes
   */
  public function __construct( $attributes = array() ) {
    static $id;

    if ( is_null( $id ) ) {
      $id = 1;
    } else {
      $id++;
    }

    $defaults         = array(
        'class'    => 'modal fade',
        'tabindex' => '-1',
        'role'     => 'dialog',
        'id'       => "modal-{$id}",
    );
    $this->attributes = wp_parse_args( $attributes, $defaults );
  }

  /**
   * Set the modal body
   *
   * @since   0.5.0
   *
   * @param   string         $body
   */
  public function set_body( $body, $filter = 'raw' ) {
    if ( 'raw' != $filter ) {
      $body = apply_filters( $filter, $body );
    }
    $this->body = (string) $body;
  }

  /**
   * Retrieve a Bootstrap modal body markup
   *
   * @since   0.5.0
   *
   * @return  string
   */
  private function _get_body() {
    return empty( $this->body ) ? '' : Tag::html( 'div.modal-body', $this->body );
  }

  /**
   * Set the modal header
   *
   * @since   0.5.0
   *
   * @param   string         $header
   */
  public function set_header( $header, $dismissable = true ) {
    $dismiss      = $dismissable ? '<button type="button" class="close" data-dismiss="modal" aria-label="' . __( 'Close', \SourceFramework\TEXTDOMAIN ) . '">'
            . '<span aria-hidden="true">&times;</span>'
            . '</button>' : '';
    $title        = empty( $header ) ? '' : Tag::html( 'h4.modal-title', $header );
    $this->header = $dismiss . $title;
  }

  /**
   * Retrieve a Bootstrap modal header markup
   *
   * @since   0.5.0
   *
   * @return  string
   */
  private function _get_header() {
    return empty( $this->header ) ? '' : Tag::html( 'div.modal-header', $this->header );
  }

  /**
   * Set the modal footer
   *
   * @since   0.5.0
   *
   * @param   string         $footer
   */
  public function set_footer( $footer, $filter = 'raw' ) {
    if ( 'raw' != $filter ) {
      $footer = apply_filters( $filter, $footer );
    }
    $this->footer = (string) $footer;
  }

  /**
   * Retrieve a Bootstrap modal footer markup
   *
   * @since   0.5.0
   *
   * @return  string
   */
  private function _get_footer() {
    return empty( $this->footer ) ? '' : Tag::html( 'div.modal-footer', $this->footer );
  }

  /**
   * Retrieve a Bootstrap modal markup
   *
   * @since   0.5.0
   *
   * @param   bool           $echo
   * @return  string
   */
  public function render( $echo = false ) {
    $modal_content = $this->_get_header() . $this->_get_body() . $this->_get_footer();

    $modal = empty( $modal_content ) ? '' : Tag::open( 'div', $this->attributes ) .
            Tag::open( 'div.modal-dialog', 'role=document' ) .
            Tag::html( 'div.modal-content', $modal_content ) .
            Tag::close( 'div' ) .
            Tag::close( 'div' );

    if ( $echo ) {
      echo $modal;
    }

    return $modal;
  }

}
