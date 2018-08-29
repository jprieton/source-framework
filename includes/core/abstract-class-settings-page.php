<?php

namespace SourceFramework\Abstracts;

// If this file is called directly, abort.
if ( !defined( 'ABSPATH' ) ) {
  die( 'Direct access is forbidden.' );
}

/**
 * Settings_Page abstract class
 *
 * @package       SourceFramework
 * @subpackage    Abstracts
 * @since         1.0.0
 * @author        Javier Prieto
 */
abstract class Settings_Page {

  /**
   * Page title
   * @since   1.0.0
   * @var     string
   */
  protected $page_title;

  /**
   * Page description
   * @since   1.0.0
   * @var     string
   */
  protected $page_description;

  /**
   * Option name
   * @since   1.0.0
   * @var     string
   */
  protected $option_name;

  /**
   * Option group
   * @since   1.0.0
   * @var     string
   */
  protected $option_group;

  /**
   * Option page
   * @since   1.0.0
   * @var     string
   */
  protected $option_page;

  /**
   * Page menu slug
   * @since   1.0.0
   * @var     string
   */
  protected $menu_slug;

  /**
   * Page submenu slug
   * @since   1.0.0
   * @var     string
   */
  protected $submenu_slug;

  /**
   * Array of setting sections in current page
   * @since   1.0.0
   * @var     array
   */
  protected $sections = [];

  /**
   * Constructor
   *
   * @since   1.0.0
   *
   * @param   string      $menu_slug
   * @param   string      $submenu_slug
   */
  public function __construct( $menu_slug = '', $submenu_slug = '' ) {
    $this->menu_slug    = $menu_slug ?: $this->menu_slug;
    $this->submenu_slug = $submenu_slug ?: $this->menu_slug;
    if ( !empty( $this->option_group ) && !empty( $this->option_name ) ) {
      register_setting( $this->option_group, $this->option_name );
    }
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
    $this->page_title = $page_title;
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
    $this->page_title = $page_title;
    add_submenu_page( $this->menu_slug, $page_title, $menu_title, $capability, $this->submenu_slug, [ $this, 'render_menu_page' ] );
  }

  /**
   * Add a new section to a settings page.
   *
   * @since   1.0.0
   *
   * @param   string         $id
   * @param   string         $title
   */
  public function add_settings_section( $id, $title = '' ) {
    $this->sections[] = $id;
    add_settings_section( $id, $title, '__return_null', $this->submenu_slug );
  }

  /**
   * Render setting page
   *
   * @since 1.0.0
   */
  public function render_menu_page() {
    ?>
    <div class="wrap">

      <h2><?php echo $this->page_title ?></h2>

      <?php
      if ( !empty( $this->page_description ) ) {
        echo apply_filters( 'the_content', $this->page_description );
      }

      global $wp_settings_sections;

      if ( array_key_exists( $this->submenu_slug, $wp_settings_sections ) && count( $wp_settings_sections[$this->submenu_slug] ) > 0 ) {
        ?>
        <form method="POST" action="./options.php">

          <?php
          settings_fields( $this->submenu_slug );
          do_settings_sections( $this->submenu_slug );
          submit_button();
          ?>

        </form>
        <?php
      }
      ?>

    </div>
    <?php
  }

}
