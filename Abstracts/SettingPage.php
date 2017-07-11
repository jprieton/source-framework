<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace SourceFramework\Abstracts;

/**
 * If this file is called directly, abort.
 */
if ( !defined( 'ABSPATH' ) ) {
  die( 'Direct access is forbidden.' );
}

use SourceFramework\Settings\SettingField;
use SourceFramework\Template\Tag;

/**
 * SettingPage abstract class
 *
 * @package     SourceFramework
 * @subpackage  Abstracts
 *
 * @author      Javier Prieto <jprieton@gmail.com>
 * @copyright	  Copyright (c) 2017, Javier Prieto
 * @since       1.0.0
 * @license     http://www.gnu.org/licenses/gpl-3.0.txt
 */
abstract class SettingPage {

  /**
   * Page title
   * @since   1.0.0
   * @var     string
   */
  protected $title;

  /**
   * Page description
   * @since   1.0.0
   * @var     string
   */
  protected $description;

  /**
   * Page menu slug
   * @since   1.0.0
   * @var     string
   */
  private $menu_slug;

  /**
   * Page submenu slug
   * @since   1.0.0
   * @var     string
   */
  private $submenu_slug;

  /**
   * Page section
   * @since   1.0.0
   * @var     string
   */
  private $section;

  /**
   * @var SettingField
   * @since 1.0.0
   */
  public $fields;

  /**
   * Constructor
   *
   * @since   1.0.0
   *
   * @param   string         $setting_group
   * @param   string         $menu_slug
   * @param   string         $submenu_slug
   */
  public function __construct( $menu_slug, $submenu_slug = '' ) {
    $this->menu_slug    = $menu_slug;
    $this->submenu_slug = empty( $submenu_slug ) ? $menu_slug : $submenu_slug;
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
    add_menu_page( $page_title, $menu_title, $capability, $this->menu_slug, [ $this, 'render_setting_page' ], $icon_url, $position );
  }

  /**
   * Render setting page
   *
   * @since 1.0.0
   */
  public function render_setting_page() {
    global $wp_settings_sections;

    echo Tag::open( 'div.wrap' ) . Tag::html( 'h2', $this->title );

    if ( !empty( $this->description ) ) {
      apply_filters( 'the_content', $this->description );
    }

    if ( !empty( $wp_settings_sections[$this->submenu_slug] ) ) {

      echo Tag::open( 'form', [ 'method' => 'post', 'action' => 'options.php' ] );

      settings_fields( $this->fields->option_group );

      $this->_show_tabs();
      $this->_show_sections();

      submit_button();

      echo Tag::close( 'form' );
    }

    echo Tag::close( 'div' );
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
  public function add_submenu_page( $page_title, $menu_title, $capability ) {
    add_submenu_page( $this->menu_slug, $page_title, $menu_title, $capability, $this->submenu_slug, [ $this, 'render_setting_page' ] );
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
    if ( empty( $this->fields ) ) {
      $this->fields = new SettingField( $this->submenu_slug );
    }

    $this->section              = $section;
    $this->fields->section      = $this->section;
    $this->fields->submenu_slug = $this->submenu_slug;

    add_settings_section( $this->fields->section, $title, '__return_null', $this->submenu_slug );
  }

  /**
   * Show page settings tabs
   * 
   * @since   1.0.0
   * 
   * @global array $wp_settings_sections
   */
  private function _show_tabs() {
    global $wp_settings_sections;

    $tab_list = '';

    if ( count( (array) $wp_settings_sections[$this->submenu_slug] ) > 1 ) {

      $tab_class = 'nav-tab nav-tab-active';

      foreach ( (array) $wp_settings_sections[$this->submenu_slug] as $section ) {
        $tab_list  .= Tag::a( '#', $section['title'], [ 'class' => $tab_class, 'data-target' => "#{$section['id']}" ] );
        $tab_class = 'nav-tab';
      }

      echo Tag::html( 'h2.nav-tab-wrapper.custom-nav-tab-wrapper', $tab_list );
    }
  }

  /**
   * Show page settings sections
   * 
   * @since   1.0.0
   * 
   * @global array $wp_settings_sections
   * @global array $wp_settings_fields
   */
  private function _show_sections() {
    global $wp_settings_sections, $wp_settings_fields;

    foreach ( (array) $wp_settings_sections[$this->submenu_slug] as $section ) {
      if ( $section['title'] ) {
        echo Tag::html( 'h2', $section['title'] );
      }

      if ( $section['callback'] ) {
        call_user_func( $section['callback'], $section );
      }

      if ( !isset( $wp_settings_fields ) || !isset( $wp_settings_fields[$this->submenu_slug] ) || !isset( $wp_settings_fields[$this->submenu_slug][$section['id']] ) ) {
        continue;
      }

      echo Tag::open( 'div.data-tab', [ 'id' => $section['id'] ] )
      . Tag::open( 'table.form-table' );

      do_settings_fields( $this->submenu_slug, $section['id'] );

      echo Tag::close( 'table' )
      . Tag::close( 'div' );
    }
  }

}
