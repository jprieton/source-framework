<?php

namespace SourceFramework\Abstracts;

/**
 * If this file is called directly, abort.
 */
if ( !defined( 'ABSPATH' ) ) {
  die( 'Direct access is forbidden.' );
}

/**
 * Singleton abstract class
 *
 * @package        Core
 * @subpackage     Abstracts
 *
 * @since          0.5.0
 *
 * @author         Javier Prieto <jprieton@gmail.com>
 */
abstract class Singleton {

  /**
   * @since         1.0.0
   * @return  static
   */
  public static function &get_instance() {
    if ( !isset( static::$instance ) ) {
      static::$instance = new static;
    }
    return static::$instance;
  }

  /**
   * @since         1.0.0
   */
  protected function __construct() {

  }

  /**
   * @since         1.0.0
   */
  protected function __clone() {

  }

  /**
   * @since         1.0.0
   */
  protected function __wakeup() {

  }

  /**
   * @since         1.0.0
   */
  protected function __sleep() {

  }

}
