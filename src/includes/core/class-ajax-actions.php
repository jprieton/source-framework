<?php

namespace SourceFramework\Core;

// If this file is called directly, abort.
if ( !defined( 'ABSPATH' ) ) {
  die( 'Direct access is forbidden.' );
}

use SourceFramework\Abstracts\Singleton;

/**
 * Ajax Actions class
 *
 * @package        SourceFramework
 * @subpackage     Core
 * @since          1.0.0
 * @author         Javier Prieto
 */
class Ajax_Actions extends Singleton {

  /**
   * Single instance of this class
   *
   * @since     2.0.0
   * @var       Assets
   */
  protected static $instance;

  /**
   * Declared as protected to prevent creating a new instance outside of the class via the new operator.
   *
   * @since     2.0.0
   */
  protected function __construct() {
    parent::__construct();

    $this->add_user_actions();
  }

  /**
   * Adds the ajax actions for users
   *
   * @since 2.0.0
   */
  public function add_user_actions() {
    add_action( 'wp_ajax_user_change_password', [ 'SourceFramework\Ajax\User_Actions', 'change_password' ] );
    add_action( 'wp_ajax_nopriv_user_authenticate', [ 'SourceFramework\Ajax\User_Actions', 'authenticate' ] );
  }

}
