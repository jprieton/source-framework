<?php

namespace SourceFramework\Core;

// If this file is called directly, abort.
if ( !defined( 'ABSPATH' ) ) {
  die( 'Direct access is forbidden.' );
}

use SourceFramework\Abstracts\Singleton;
use SourceFramework\Core\Cron;
use SourceFramework\Admin\Security_Page;
use SourceFramework\Admin\Advanced_Page;
use SourceFramework\Admin\Media_Page;
use SourceFramework\Admin\Featured_Post;
use SourceFramework\Admin\Theme_Customizer;
use SourceFramework\Admin\Theme_Customizer_Login;

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
    Cron::init();

    // Initialize assets
    Assets::init();

    // Initialize ajax actions
    Ajax_Actions::init();

    // Initialize security
    Security::init();

    // Theme Customizer
    Theme_Customizer::init();

    // Theme Customizer
    Theme_Customizer_Login::init();

    // Initialize admin menus
    add_action( 'init', [ $this, 'add_admin_pages' ] );

    // Add theme supports
    add_action( 'after_setup_theme', [ $this, 'add_theme_supports' ], 25 );

    // Add an ofuscate mailto shortcode to prevent spam-bots from sniffing it.
    add_shortcode( 'mailto', [ 'SourceFramework\Shortcode\General', 'mailto' ] );

    // Add additional mod_rewrite rules
    add_filter( 'mod_rewrite_rules', [ $this, 'mod_rewrite_rules' ] );

    // Add the Bootstrap Breakpoint Helper to footer
    add_action( 'wp_footer', [ $this, 'bootstrap_breakpoint_helper' ], 99 );
  }

  /**
   * Add menu/submenu pages to admin panel's menu structure.
   *
   * @since   2.0.0
   */
  public function add_admin_pages() {
    new Advanced_Page();
    new Security_Page();
    new Media_Page();
    new Featured_Post();
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

  /**
   * Adds additional rules to .htaccess
   *
   * @since     2.0.0
   *
   * @param     sring     $rules
   * @return    string
   */
  public function mod_rewrite_rules( $rules ) {
    $security = apply_filters( 'security_mod_rewrite_rules', '' );
    return $security . $rules;
  }

  /**
   * Adds the Bootstrap Breakpoint Helper to footer
   *
   * @since     2.0.0
   */
  public function bootstrap_breakpoint_helper() {
    if ( get_theme_mod( 'bootstrap_breakpoint_helper', false ) ) {
      include_once SF_ABSPATH . '/partials/bootstrap-breakpoint-helper.php';
    }
  }

}
