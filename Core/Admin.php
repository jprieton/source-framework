<?php

namespace SourceFramework\Core;

/**
 * If this file is called directly, abort.
 */
if ( !defined( 'ABSPATH' ) ) {
  die( 'Direct access is forbidden.' );
}

use SourceFramework\Abstracts\Singleton;
use SourceFramework\Settings\SettingGroup;
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
   * @since         1.0.0
   * @var           SettingGroup
   */
  private $advanced_setting_group;

  /**
   * Declared as protected to prevent creating a new instance outside of the class via the new operator.
   *
   * @since         1.0.0
   */
  protected function __construct() {
    parent::__construct();

    $this->advanced_setting_group = new SettingGroup( 'advanced' );

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

    /**
     * Add  featured posts backend funcionality.
     * @since   1.0.0
     */
    add_action( 'current_screen', [ $this, 'featured_posts_column' ] );
    add_action( 'wp_ajax_toggle_featured_post', [ 'SourceFramework\Admin\FeaturedPost', 'toggle_featured_post' ] );
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

  /**
   * Init featured posts backend funcionality
   *
   * @since 0.5.0
   */
  public function featured_posts_column() {
    $post_types_enabled = $this->advanced_setting_group->get_option( 'featured-posts' );
    $screen             = get_current_screen();
    if ( !empty( $post_types_enabled ) && in_array( $screen->post_type, $post_types_enabled ) ) {

      if ( function_exists( 'WC' ) && 'product' == $screen->post_type ) {
        return;
      }

      add_action( 'manage_posts_custom_column', [ 'SourceFramework\Admin\FeaturedPost', 'manage_custom_columns' ], 10, 2 );
      add_action( 'manage_pages_custom_column', [ 'SourceFramework\Admin\FeaturedPost', 'manage_custom_columns' ], 10, 2 );
      add_action( 'manage_posts_columns', [ 'SourceFramework\Admin\FeaturedPost', 'manage_columns' ], 10, 2 );
      add_action( 'manage_pages_columns', [ 'SourceFramework\Admin\FeaturedPost', 'manage_columns' ], 10, 2 );
    }
  }

}
