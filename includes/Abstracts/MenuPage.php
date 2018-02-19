<?php

namespace SourceFramework\Abstracts;

// If this file is called directly, abort.
if ( !defined( 'ABSPATH' ) ) {
  die( 'Direct access is forbidden.' );
}

/**
 * SettingPage abstract class
 *
 * @package       SourceFramework
 * @subpackage    Abstracts
 * @since         1.0.0
 * @author        Javier Prieto
 */
abstract class MenuPage {

  /**
   * Page title
   * @since   1.0.0
   * @var     string
   */
  protected $title = '';

  /**
   * Page description
   * @since   1.0.0
   * @var     string
   */
  protected $description = '';

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
   * Constructor
   *
   * @since   1.0.0
   *
   * @param   string      $menu_slug
   * @param   string      $submenu_slug
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
   * @param   string      $page_title
   * @param   string      $menu_title
   * @param   string      $capability
   * @param   string      $icon_url
   * @param   int         $position
   */
  public function add_menu_page( $page_title, $menu_title, $capability, $icon_url = 'dashicons-admin-generic', $position = null ) {
    add_menu_page( $page_title, $menu_title, $capability, $this->menu_slug, [ $this, 'render_menu_page' ], $icon_url, $position );
  }

  /**
   * Add a submenu page.
   *
   * @since   1.0.0
   *
   * @param   string      $page_title
   * @param   string      $menu_title
   * @param   string      $capability
   */
  public function add_submenu_page( $page_title, $menu_title, $capability ) {
    add_submenu_page( $this->menu_slug, $page_title, $menu_title, $capability, $this->submenu_slug, [ $this, 'render_menu_page' ] );
  }

  /**
   * Render setting page
   *
   * @since 1.0.0
   */
  public function render_menu_page() {
    ?>
    <div class="wrap">

      <h2><?php echo $this->title ?></h2>

      <?php settings_errors() ?>

      <?php
      if ( !empty( $this->description ) ) {
        echo apply_filters( 'the_content', $this->description );
      }
      ?>

    </div>
    <?php
  }

}
