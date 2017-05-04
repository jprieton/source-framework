<?php

namespace SourceFramework\Init;

/**
 * If this file is called directly, abort.
 */
if ( !defined( 'ABSPATH' ) ) {
  die( 'Direct access is forbidden.' );
}

/**
 * Aliases
 */
use SourceFramework\Abstracts\Singleton;

/**
 * Dependencies
 */
if ( !class_exists( 'Singleton' ) ) {
  require_once SourceFramework\ABSPATH . '/Abstracts/Singleton.php';
}

/**
 * SetupInit class
 *
 * @package        Init
 * @since          1.0.0
 * @author         Javier Prieto <jprieton@gmail.com>
 */
class SetupInit extends Singleton {

  /**
   * Static instance of this class
   *
   * @since         1.0.0
   * @var           CoreInit
   */
  protected static $instance;

  /**
   * The code that runs when the plugin is activated.
   * @since 1.0.0
   */
  public function activation_hook() {
    
  }

  /**
   * The code that runs when the plugin is deactivated.
   * @since 1.0.0
   */
  public function deactivation_hook() {
    
  }

  /**
   * The code that runs when the plugin is uninstalled.
   * @since 1.0.0
   */
  public function uninstall_hook() {
    
  }

}
