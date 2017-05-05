<?php

namespace SourceFramework\Abstracts;

/**
 * If this file is called directly, abort.
 */
if ( !defined( 'ABSPATH' ) ) {
  die( 'Direct access is forbidden.' );
}

include_once './class-option-group.php';
use SourceFramework\Core\Option_Group;


use SourceFramework\Core\Factory\SettingFactory;
use SourceFramework\Helpers\ArrayHelper;
use SourceFramework\Helpers\HtmlBuilder as Html;
use SourceFramework\Helpers\FormBuilder as Form;

/**
 * Settings_Page abstract class
 *
 * @package        Core
 * @subpackage     Abstracts
 *
 * @since          1.0.0
 *
 * @author         Javier Prieto <jprieton@gmail.com>
 */
abstract class Settings_Page {

  /**
   * Page title
   * @since   1.0.0
   * @var     string
   */
  private $title;

  /**
   * Option group name
   * @since   1.0.0
   * @var     string
   */
  private $option_group;

  /**
   * SettingGroup object
   * @since   1.0.0
   * @var     SettingGroup
   */
  private $setting_group;

  /**
   * Constructor
   *
   * @since   1.0.0
   *
   * @param   string         $setting_group
   * @param   string         $menu
   * @param   string         $submenu
   */
  public function __construct( $setting_group, $menu, $submenu = '' ) {
    $this->menu          = $menu;
    $this->submenu       = empty( $submenu ) ? $menu : $submenu;
    $this->option_group  = $setting_group;
    $this->setting_group = SettingFactory::setting_group( $setting_group );
  }

  /**
   * Add a top-level menu page.
   *
   * @since   1.0.0
   *
   * @param   string         $page_title
   * @param   string         $menu_title
   * @param   string         $capability
   * @param   string         $icon_url
   * @param   int            $position
   */
  public function add_menu_page( $page_title, $menu_title, $capability, $icon_url = 'dashicons-admin-generic', $position = null ) {
    add_menu_page( $page_title, $menu_title, $capability, $this->menu, '__return_null', $icon_url );
  }

  /**
   * Add a submenu page.
   *
   * @since   1.0.0
   *
   * @param   string         $page_title
   * @param   string         $menu_title
   * @param   string         $capability
   */
  public function add_submenu_page( $page_title, $menu_title, $capability = 'administrator' ) {
    $this->title = $page_title;
    add_submenu_page( $this->menu, $page_title, $menu_title, $capability, $this->submenu, array( $this, 'render_setting_page' ) );
  }

  /**
   * Add a new section to a settings page.
   *
   * @since   1.0.0
   *
   * @param   string         $section
   * @param   string         $title
   */
  public function add_setting_section( $section, $title ) {
    $this->section = $section;
    add_settings_section( $this->section, $title, '__return_null', $this->submenu );
  }

  /**
   * Render a settings page.
   *
   * @since   1.0.0
   *
   * @global   array         $wp_settings_sections
   * @global   array         $wp_settings_fields
   * @return   void
   */
  public function render_setting_page() {
    global $wp_settings_sections, $wp_settings_fields;

    if ( !array_key_exists( $this->submenu, (array) $wp_settings_sections ) ) {
      return false;
    }

    echo Html::open_tag( 'div.wrap' );

    if ( !empty( $this->title ) ) {
      echo Html::tag( 'h2', $this->title );
    }

    settings_errors();
    echo Form::open( array( 'method' => 'post', 'action' => 'options.php' ) );
    settings_fields( $this->option_group );

    if ( !empty( $this->description ) ) {
      apply_filters( 'the_content', $this->description );
    }

    $tab_list = '';

    if ( count( (array) $wp_settings_sections[$this->submenu] ) > 1 ) {

      $tab_class = 'nav-tab nav-tab-active';

      foreach ( (array) $wp_settings_sections[$this->submenu] as $section ) {
        $tab_list  .= Html::a( '#', $section['title'], array( 'class' => $tab_class, 'data-target' => "#{$section['id']}" ) );
        $tab_class = 'nav-tab';
      }

      echo Html::tag( 'h2.nav-tab-wrapper.custom-nav-tab-wrapper', $tab_list );
    }

    foreach ( (array) $wp_settings_sections[$this->submenu] as $section ) {

      if ( $section['title'] && empty( $tab_list ) ) {
        echo Html::tag( 'h2', $section['title'] );
      }

      if ( $section['callback'] ) {
        call_user_func( $section['callback'], $section );
      }

      if ( !isset( $wp_settings_fields ) || !isset( $wp_settings_fields[$this->submenu] ) || !isset( $wp_settings_fields[$this->submenu][$section['id']] ) ) {
        continue;
      }

      echo Html::open_tag( 'div.data-tab', array( 'id' => $section['id'] ) );
      echo Html::open_tag( 'table.form-table' );
      do_settings_fields( $this->submenu, $section['id'] );
      echo Html::close_tag( 'table' );
      echo Html::close_tag( 'div' );
    }
    submit_button();
    echo Html::close_tag( 'form' );
    echo Html::close_tag( 'div' );
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
    $field['input_class'] = ArrayHelper::extract( $field, 'class', '' );

    $defaults = array(
        'type' => 'text',
        'desc' => '',
        'id'   => null
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

    add_settings_field( $field['id'], $field['name'], $callback, $this->submenu, $this->section, $field );
  }

  /**
   * Render a input field
   *
   * @since   1.0.0
   *
   * @param   array          $field
   */
  public function render_input( $field ) {
    $type    = ArrayHelper::extract( $field, 'type', 'text' );
    $name    = sprintf( "{$this->option_group}[%s]", $field['id'] );
    $default = ArrayHelper::extract( $field, 'default', '' );
    $value   = $this->setting_group->get_option( $field['id'], $default );

    if ( array_key_exists( 'desc', $field ) ) {
      $description = apply_filters( 'the_content', $field['desc'] );
      $description = str_replace( '<p>', '<p class="description">', $description );
      unset( $field['desc'] );
    } else {
      $description = '';
    }

    $field['class'] = ArrayHelper::extract( $field, 'input_class', '' );

    unset( $field['name'], $field['value'] );
    $input = Form::input( $type, $name, $value, $field );

    echo $input . $description;
  }

  /**
   * Render a textarea field
   *
   * @since   1.0.0
   *
   * @param   array          $field
   */
  public function render_textarea( $field ) {
    $name    = sprintf( "{$this->option_group}[%s]", $field['id'] );
    $default = ArrayHelper::extract( $field, 'default', '' );
    $raw     = ArrayHelper::extract( $field, 'raw', false );
    $value   = $this->setting_group->get_option( $field['id'], $default );

    if ( !$raw ) {
      $value = esc_textarea( $value );
    }

    if ( array_key_exists( 'desc', $field ) ) {
      $description = apply_filters( 'the_content', $field['desc'] );
      $description = str_replace( '<p>', '<p class="description">', $description );
      unset( $field['desc'] );
    } else {
      $description = '';
    }

    $field['class'] = ArrayHelper::extract( $field, 'input_class', '' );

    unset( $field['name'], $field['value'] );
    $textarea = Form::textarea( $name, $value, $field );

    echo $textarea . $description;
  }

  /**
   * Render a checkbox field
   *
   * @since   1.0.0
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

    $field['class'] = ArrayHelper::extract( $field, 'input_class', '' );

    if ( empty( $options ) ) {
      $options[] = $field;
    }

    foreach ( $options as $item ) {
      $item['type']  = 'checkbox';
      $item['id']    = ArrayHelper::get( $item, 'id', false );
      $item['name']  = ArrayHelper::get( $item, 'name', false );
      $item['value'] = ArrayHelper::get( $item, 'value', 'yes' );

      if ( $is_multiple && !$item['id'] && !$item['name'] ) {
        $item['id']   = $field['id'] . '-' . substr( md5( $item['value'] ), 0, 8 );
        $item['name'] = sprintf( "{$this->option_group}[%s][]", $field['id'] );
      } else {
        $is_multiple  = false;
        $item['name'] = sprintf( "{$this->option_group}[%s]", $item['id'] );
      }

      $label = ArrayHelper::extract( $item, 'label', false );
      if ( $label ) {
        $label = '%s ' . $label;
      } else {
        $label = '%s ';
      }

      $desc = ArrayHelper::extract( $item, 'desc', '' );
      if ( $desc ) {
        $desc = apply_filters( 'the_content', $desc );
        $desc = str_replace( '<p>', '<p class="description">', $desc );
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

      $label = Form::label( $item['id'], $label );
      $input = Form::hidden( $item['name'], '_unset_' ) . Form::checkbox( $item['name'], 'yes', $item );

      echo sprintf( $label, $input ) . $desc;
    }
  }

  /**
   * Render a select field
   *
   * @since   1.0.0
   *
   * @param   array          $field
   */
  public function render_select( $field ) {


    $options = $field['options'];
    unset( $field['options'] );

    $name        = sprintf( "{$this->option_group}[%s]", $field['id'] );
    $class       = ArrayHelper::extract( $field, 'class', '' );
    $selected    = $this->setting_group->get_option( $field['id'] );
    $desc        = ArrayHelper::extract( $field, 'desc', '' );
    $placeholder = array( '' => __( 'Default', SMGDEVTOOLS_TEXTDOMAIN ) );

    if ( $desc ) {
      $desc = apply_filters( 'the_content', $desc );
      $desc = str_replace( '<p>', '<p class="description">', $desc );
    }

    echo Form::select( $name, $options, compact( 'selected', 'placeholder' ) ) . $desc;
  }

}
