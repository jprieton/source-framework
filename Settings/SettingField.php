<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace SourceFramework\Settings;

use SourceFramework\Settings\SettingGroup;
use SourceFramework\Template\Tag;
use SourceFramework\Template\Form;

/**
 * SettingField class
 *
 * @package        Admin
 * @since          1.0.0
 * @author         Javier Prieto <jprieton@gmail.com>
 */
class SettingField {

  /**
   * SettingGroup object
   *
   * @since          1.0.0
   * @var SettingGroup
   */
  private $setting_group;

  /**
   * Option group name object
   *
   * @since          1.0.0
   * @var string
   */
  public $option_group;

  /**
   * Section name
   * @since          1.0.0
   * @var string
   */
  public $section;

  /**
   * Page submenu slug
   * @since   1.0.0
   * @var     string
   */
  public $submenu_slug;

  /**
   * Constructor
   *
   * @since   1.0.0
   * @param string $setting_group Setting group name
   */
  public function __construct( $option_group, $setting_group = null ) {

    if ( !empty( $setting_group ) ) {
      $this->setting_group = new SettingGroup( $setting_group );
      $this->option_group  = $option_group;
      register_setting( $option_group, $setting_group );
    }
  }

  /**
   * Add field to section
   *
   * @since   1.0.0
   *
   * @param   array          $field
   * @return  boolean
   */
  public function add_field( $field ) {
    if ( (!is_array( $field ) || !array_key_exists( 'name', $field ) ) && array_key_exists( 'options', $field ) ) {
      return false;
    }

    $defaults = array(
        'type'        => 'text',
        'desc'        => '',
        'id'          => null,
        'input_class' => '',
    );

    $field = wp_parse_args( $field, $defaults );

    switch ( $field['type'] ) {
      case 'checkbox':
        $callback = array( &$this, 'render_checkbox' );
        break;

      case 'textarea':
        $callback = array( &$this, 'render_textarea' );
        break;

      case 'select':
        $callback = array( &$this, 'render_select' );
        break;

      case 'text':
      case 'password':
      case 'email':
      default:
        $callback = array( &$this, 'render_input' );
        break;
    }

    add_settings_field( $field['id'], $field['name'], $callback, $this->submenu_slug, $this->section, $field );
  }

  /**
   * Render a input field
   *
   * @since   0.5.0
   *
   * @param   array          $field
   */
  public function render_input( $field ) {
    $description   = '';
    $default_value = '';

    if ( array_key_exists( 'desc', $field ) ) {
      $description = $this->_parse_description( $field['desc'] );
      unset( $field['desc'] );
    }

    if ( array_key_exists( 'input_class', $field ) ) {
      $field['class'] = $field['input_class'];
      unset( $field['input_class'] );
    }

    if ( array_key_exists( 'default', $field ) ) {
      $default_value = $field['default'];
      unset( $field['default'] );
    }

    if ( !empty( $this->setting_group ) ) {
      $field['name']  = sprintf( "{$this->setting_group->setting_group_name}[%s]", $field['id'] );
      $field['value'] = $this->setting_group->get_option( $field['id'], $default_value );
    } else {
      $field['name']  = $field['id'];
      $field['value'] = get_option( $field['id'], $default_value );
    }

    $defaults = [
        'type'  => 'text',
        'class' => '',
    ];

    $attributes = wp_parse_args( $field, $defaults );
    $input      = Form::input( $attributes );

    echo $input . $description;
  }

  /**
   * Render a textarea field
   *
   * @since   0.5.0
   *
   * @param   array          $field
   */
  public function render_textarea( $field ) {
    $description   = '';
    $default_value = '';
    $value         = '';
    $raw           = false;

    if ( array_key_exists( 'desc', $field ) ) {
      $description = $this->_parse_description( $field['desc'] );
      unset( $field['desc'] );
    }

    if ( array_key_exists( 'input_class', $field ) ) {
      $field['class'] = $field['input_class'];
      unset( $field['input_class'] );
    }

    if ( array_key_exists( 'raw', $field ) ) {
      $raw = (bool) $field['raw'];
      unset( $field['raw'] );
    }

    if ( array_key_exists( 'default', $field ) ) {
      $default_value = (string) $field['default'];
      unset( $field['default'] );
    }

    if ( !empty( $this->setting_group ) ) {
      $field['name'] = sprintf( "{$this->setting_group->setting_group_name}[%s]", $field['id'] );
      $value         = $this->setting_group->get_option( $field['id'], $default_value );
    } else {
      $field['name'] = $field['id'];
      $value         = get_option( $field['id'], $default_value );
    }

    if ( !$raw ) {
      $value = esc_textarea( $value );
    }

    $defaults = [
        'class' => '',
    ];

    $attributes = wp_parse_args( $field, $defaults );
    $input      = Tag::html( 'textarea', $value, $attributes );

    echo $input . $description;
  }

  /**
   * Render a checkbox field
   *
   * @since   0.5.0
   *
   * @param   array          $field
   */
  public function render_checkbox( $field ) {

    $options = array();

    $is_multiple = false;
    if ( array_key_exists( 'options', $field ) ) {
      $options     = $field['options'];
      unset( $field['options'] );
      $is_multiple = true;
    }

    if ( array_key_exists( 'input_class', $field ) ) {
      $field['class'] = $field['input_class'];
      unset( $field['input_class'] );
    }

    if ( empty( $options ) ) {
      $options[] = $field;
    }

    $defaults = [
        'id'    => false,
        'name'  => false,
        'value' => 'yes',
        'type'  => 'checkbox'
    ];


    foreach ( $options as $item ) {
      $item = wp_parse_args( $item, $defaults );

      if ( $is_multiple && !$item['id'] && !$item['name'] ) {
        $item['id']   = $field['id'] . '-' . substr( md5( $item['value'] ), 0, 8 );
        $item['name'] = sprintf( "{$this->option_group}[%s][]", $field['id'] );
      } else {
        $is_multiple  = false;
        $item['name'] = sprintf( "{$this->option_group}[%s]", $item['id'] );
      }

      if ( array_key_exists( 'label', $item ) ) {
        $label = '%s ' . $item['label'];
        unset( $item['label'] );
      } else {
        $label = '%s ';
      }

      if ( array_key_exists( 'desc', $item ) ) {
        $desc = $this->_parse_description( $item['desc'] );
        unset( $item['desc'] );
      } else {
        $desc = '<br />';
      }

      if ( $is_multiple ) {
        $options = (array) $this->setting_group->get_option( $field['id'], array() );
      } else {
        $options = (bool) $this->setting_group->get_bool_option( $item['id'] );
      }

      if ( (is_bool( $options ) && $options) || (is_array( $options ) && in_array( $item['value'], $options )) ) {
        $item['checked'] = 'checked';
      }

      $label = Form::label( $label, [ 'for' => $item['id'] ] );
      $input = Form::hidden( $item['name'], 'no' ) . Form::input( $item );

      echo sprintf( $label, $input ) . $desc;
    }
  }

  private function _parse_description( $description = '' ) {
    if ( is_array( $description ) ) {
      $description = implode( "\n\n", $description );
    }

    $description = apply_filters( 'the_content', $description );
    $description = str_replace( '<p>', '<p class="description">', $description );

    return $description;
  }

}
