<?php

namespace SourceFramework\Core;

/**
 * If this file is called directly, abort.
 */
if ( !defined( 'ABSPATH' ) ) {
  die( 'Direct access is forbidden.' );
}

use SourceFramework\Abstracts\Singleton;
use SourceFramework\Admin\Importer;
use SourceFramework\Admin\GeneralPage;
use SourceFramework\Admin\SocialPage;
use SourceFramework\Admin\AboutPage;
use SourceFramework\Admin\ApiPage;
use SourceFramework\Admin\AdvancedPage;
use SourceFramework\Admin\ToolsPage;
use SourceFramework\Admin\AnalyticsPage;

/**
 * Admin class
 *
 * @package        Core
 * @subpackage     Init
 * @since          1.0.0
 * @author         Javier Prieto <jprieton@gmail.com>
 */
final class Admin extends Singleton {

  /**
   * Static instance of this class
   *
   * @since         1.0.0
   * @var           PublicInit
   */
  protected static $instance;

  /**
   * Declared as protected to prevent creating a new instance outside of the class via the new operator.
   *
   * @since         1.0.0
   */
  protected function __construct() {
    parent::__construct();

    /**
     * Enable csv importer
     * @since 1.0.0
     */
    add_action( 'admin_init', [ $this, 'register_csv_importer' ] );

    /**
     * Add menu/submenu pages to admin panel's menu structure.
     * @since   1.0.0
     */
    add_action( 'admin_menu', [ $this, 'admin_menus' ], 25 );
  }

  /**
   * Register CSV Import
   *
   * @since   1.0.0
   */
  public function register_csv_importer() {
    Importer::get_instance();
  }

  /**
   * Add menu/submenu pages to admin panel's menu structure.
   *
   * @since   1.0.0
   */
  public function admin_menus() {
    new GeneralPage();
    new SocialPage();
    new AnalyticsPage();
    new ToolsPage();
    new ApiPage();
    new AdvancedPage();
    new AboutPage();
  }

}
