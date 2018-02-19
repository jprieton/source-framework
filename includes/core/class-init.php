<?php

namespace SourceFramework\Core;

// If this file is called directly, abort.
if ( !defined( 'ABSPATH' ) ) {
  die( 'Direct access is forbidden.' );
}

use SourceFramework\Abstracts\Singleton;
use SourceFramework\Core\Cron;
use SourceFramework\Admin\Security_Page;

/**
 * Class to initialize plugin
 *
 * @package       SourceFramework
 * @subpackage    Core
 * @since         1.0.0
 * @author        Javier Prieto
 */
final class Init extends Singleton {

  /**
   * Single instance of this class
   *
   * @since     1.0.0
   * @var       Init
   */
  protected static $instance;

  /**
   * Declared as protected to prevent creating a new instance outside of the class via the new operator.
   *
   * @since     1.0.0
   */
  protected function __construct() {
    parent::__construct();

    // Initialize cron events
    Cron::instance();

    // Initialize assets
    Assets::instance();

    // Initialize ajax actions
    Ajax_Actions::instance();

    // Initialize security
    Security::instance();

    // Initialize admin menus
    add_action( 'init', [ $this, 'add_admin_pages' ] );

    // Add theme supports
    add_action( 'after_setup_theme', [ $this, 'add_theme_supports' ], 25 );
  }

  /**
   * Add menu/submenu pages to admin panel's menu structure.
   *
   * @since   2.0.0
   */
  public function add_admin_pages() {
    new Security_Page();
  }

  /**
   * Add Theme supports
   *
   * @since   1.0.0
   */
  public function add_theme_supports() {
    // Enables plugins and themes to manage the document title tag.
    add_theme_support( 'title-tag' );

    // Enable support for Post Thumbnails on posts and pages.
    add_theme_support( 'post-thumbnails' );
  }

}
