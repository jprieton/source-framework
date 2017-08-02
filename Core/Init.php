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
use SourceFramework\Tools\FrontendHelper;

/**
 * Init class
 *
 * @package     SourceFramework
 * @subpackage  Core
 *
 * @author      Javier Prieto <jprieton@gmail.com>
 * @copyright	  Copyright (c) 2017, Javier Prieto
 * @since       1.0.0
 * @license     http://www.gnu.org/licenses/gpl-3.0.txt
 */
final class Init extends Singleton {

  /**
   * Static instance of this class
   *
   * @since         1.0.0
   * @var           Init
   */
  protected static $instance;

  /**
   * @since         1.0.0
   * @var           SettingGroup
   */
  private $setting_group;

  /**
   * Declared as protected to prevent creating a new instance outside of the class via the new operator.
   *
   * @since         1.0.0
   */
  protected function __construct() {
    parent::__construct();

    /**
     * This hook is called once any activated plugins have been loaded
     * @since 1.0.0
     */
    add_action( 'plugins_loaded', [ $this, 'load_plugin_textdomain' ] );

    /**
     * This hook check if is enabled cli and filter hook action
     * @since 1.0.0
     */
    $this->enable_cli_commands();

    /**
     * This hook check if is enabled front end helper
     * @since 1.0.0
     */
    $this->enable_frontend_helper();

    /**
     * Add shortcodes
     * @since 1.0.0
     */
    $this->add_shortcodes();

    if ( is_admin() ) {
      /**
       * Initialize admin
       * @since   1.0.0
       */
      Admin::get_instance();
    } else {
      /**
       * Initialize public
       * @since   1.0.0
       */
      SourceFrameworkPublic::get_instance();
    }
  }

  /**
   * This hook is called once any activated plugins have been loaded
   *
   * @since 1.0.0
   */
  public function load_plugin_textdomain() {
    /**
     * Load plugin textdomain
     * @since 1.0.0
     */
    load_plugin_textdomain( \SourceFramework\TEXTDOMAIN, FALSE, basename( dirname( \SourceFramework\BASENAME ) ) . '/languages/' );
  }

  /**
   * Check if is enabled CLI and filter hook action
   *
   * Shell example usage<br>
   * <code>
   * php /wordpress-path/wp-admin/admin-ajax.php --my_option
   * </code>
   *
   * @since 1.0.0
   * @return boolean
   */
  private function enable_cli_commands() {
    // Check if SettingGroup is instanciated
    if ( empty( $this->setting_group ) ) {
      $this->setting_group = new SettingGroup( 'source-framework' );
    }

    // Check if is enabled
    if ( !$this->setting_group->get_bool_option( 'cli_commands_enabled' ) ) {
      return false;
    }

    // CLI only
    if ( !defined( 'STDERR' ) ) {
      return false;
    }

    add_filter( 'allowed_http_origin', [ $this, 'allowed_http_origin' ] );
    return true;
  }

  /**
   * Set $_REQUEST param for use of CLI
   *
   * @since 1.0.0
   * @param array $origin
   */
  public function allowed_http_origin( $origin ) {
    $GLOBALS['_REQUEST']['action'] = 'source_framework_cli';
    return $origin;
  }

  public function add_shortcodes() {
    /**
     * Add an ofuscate mailto link to prevent spam-bots from sniffing it.
     * @since 1.0.0
     */
    add_shortcode( 'mailto', [ 'SourceFramework\Template\Shortcode', 'mailto' ] );
  }

  /**
   *
   */
  public function enable_frontend_helper() {
    // Check if SettingGroup is instanciated
    if ( empty( $this->setting_group ) ) {
      $this->setting_group = new SettingGroup( 'source-framework' );
    }

    // Check if is enabled
    if ( !$this->setting_group->get_bool_option( 'frontend-helper-enabled' ) ) {
      return false;
    }

    new FrontendHelper();
  }

}
