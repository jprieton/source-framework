<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace SourceFramework\Abstracts;

/**
 * If this file is called directly, abort.
 */
if ( !defined( 'ABSPATH' ) ) {
  die( 'Direct access is forbidden.' );
}

/**
 * SettingGroupPage abstract class
 *
 * @package     SourceFramework
 * @subpackage  Abstracts
 *
 * @author      Javier Prieto <jprieton@gmail.com>
 * @copyright	  Copyright (c) 2017, Javier Prieto
 * @since       1.0.0
 * @license     http://www.gnu.org/licenses/gpl-3.0.txt
 */
abstract class SettingGroupPage extends SettingPage {

  /**
   * Constructor
   *
   * @since   1.0.0
   *
   * @param   string         $setting_group
   * @param   string         $menu_slug
   * @param   string         $submenu_slug
   */
  public function __construct( $menu_slug, $submenu_slug = '' ) {
    parent::__construct( $menu_slug, $submenu_slug );
  }


}
