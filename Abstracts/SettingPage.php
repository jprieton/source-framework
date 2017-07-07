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
   * Page title
   * @since   1.0.0
   * @var     string
   */
  private $menu_slug;

  /**
   * Page title
   * @since   1.0.0
   * @var     string
   */
  private $submenu_slug;

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
    add_menu_page( $page_title, $menu_title, $capability, $this->menu_slug, [ $this, 'render_setting_page' ], $icon_url );
  }

  /**
   *
   * @global   array         $wp_settings_sections
   * @global   array         $wp_settings_fields
   * @return boolean
   */
  public function render_setting_page() {
    ?>
    <div class="wrap">
      <h2><?php echo $this->title ?></h2>
    </div>
    <?php
  }

  public function add_submenu_page( $page_title, $menu_title, $capability ) {
    add_submenu_page( $this->menu_slug, $page_title, $menu_title, $capability, $this->submenu_slug, [ $this, 'render_setting_page' ] );
  }

}
