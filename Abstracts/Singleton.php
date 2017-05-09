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
 * @package     SourceFramework
 * @subpackage  Abstracts
 *
 * @author      Javier Prieto <jprieton@gmail.com>
 * @copyright	  Copyright (c) 2017, Javier Prieto
 * @since       1.0.0
 * @license     http://www.gnu.org/licenses/gpl-3.0.txt
 */
abstract class Singleton {

  /**
   * @since   1.0.0
   *
   * @return  static
   */
  public static function &get_instance() {
    if ( !isset( static::$instance ) ) {
      static::$instance = new static;
    }

    return static::$instance;
  }

  /**
   * Declared as protected to prevent creating a new instance outside of the class via the new operator.
   *
   * @since         1.0.0
   */
  protected function __construct() {

  }

  /**
   * Declared as private to prevent cloning of an instance of the class via the clone operator.
   *
   * @since         1.0.0
   */
  private function __clone() {

  }

  /**
   * declared as private to prevent unserializing of an instance of the class via the global function unserialize().
   *
   * @since         1.0.0
   */
  private function __wakeup() {

  }

  /**
   * Declared as protected to prevent serializg of an instance of the class via the global function serialize().
   *
   * @since         1.0.0
   */
  protected function __sleep() {

  }

  /**
   * PHP5 style destructor and will run when object is destroyed.
   *
   * @since         1.0.0
   */
  public function __destruct() {
    static::$instance = null;
  }

}
