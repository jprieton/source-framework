<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace SourceFramework\Core;

use SourceFramework\Abstracts\Singleton;

/**
 * Description of Ajax_Actions
 *
 * @author perseo
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
    add_action( 'wp_ajax_user_change_password', [ 'SourceFramework\Ajax\UserActions', 'change_password' ] );
    add_action( 'wp_ajax_nopriv_user_authenticate', [ 'SourceFramework\Ajax\UserActions', 'authenticate' ] );
  }

}
