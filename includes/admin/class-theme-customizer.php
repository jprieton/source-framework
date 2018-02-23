<?php

namespace SourceFramework\Admin;

// If this file is called directly, abort.
if ( !defined( 'ABSPATH' ) ) {
  die( 'Direct access is forbidden.' );
}

use SourceFramework\Abstracts\Singleton;
use WP_Customize_Manager;

/**
 * Theme_Customizer class
 *
 * @package        SourceFramework
 * @subpackage     Admin
 * @since          2.0.0
 * @author         Javier Prieto
 */
class Theme_Customizer extends Singleton {

  /**
   * Single instance of this class
   *
   * @since     2.0.0
   * @var       Theme_Customizer
   */
  protected static $instance;

  protected function __construct() {
    parent::__construct();

    // Adds the devlopment menu to theme customizer
    add_action( 'customize_register', [ $this, 'devlopment' ] );
  }

  /**
   * Adds the devlopment menu to theme customizer
   * 
   * @since     2.0.0
   * 
   * @param WP_Customize_Manager $wp_customize
   */
  public function devlopment( $wp_customize ) {
    $wp_customize->add_setting( 'bootstrap-breakpoint-helper' );
    $wp_customize->add_section( 'development_customizer_section', [
        'title'    => __( 'Development', SF_TEXTDOMAIN ),
        'priority' => 1000,
    ] );
    $wp_customize->add_control( 'bootstrap-helper', [
        'label'    => __( 'Bootstrap 4.x Breakpoint Helper', SF_TEXTDOMAIN ),
        'section'  => 'development_customizer_section',
        'settings' => 'bootstrap-breakpoint-helper',
        'type'     => 'checkbox',
    ] );
  }

}
