<?php

namespace SourceFramework\Core\Traits;

defined( 'ABSPATH' ) || exit;

/**
 * Singleton trait
 * 
 * @since     2.0.0
 */
trait Singleton {

  /**
   * Single instance of this class
   *
   * @since     2.0.0
   * @var       self
   */
  protected static $instance;

  /**
   * Main instance
   * Ensures only one instance of this class is loaded or can be loaded.
   *
   * @since   2.0.0
   * @static
   */
  public static function get_instance() {
    if ( empty( self::$instance ) ) {
      self::$instance = new self;
    }
    return self::$instance;
  }

  /**
   * Declared as private to prevent cloning of an instance of the class via the clone operator.
   *
   * @since   2.0.0
   */
  private function __clone() {
    
  }

  /**
   * Declared as private to prevent unserializing of an instance of the class via the global function unserialize().
   *
   * @since   2.0.0
   */
  private function __wakeup() {
    
  }

  /**
   * Declared as protected to prevent serializg of an instance of the class via the global function serialize().
   *
   * @since   2.0.0
   */
  protected function __sleep() {
    
  }

  /**
   * PHP5 style destructor and will run when object is destroyed.
   *
   * @since   2.0.0
   */
  public function __destruct() {
    self::$instance = null;
  }

}
