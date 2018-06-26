<?php

namespace SourceFramework\Admin;

// If this file is called directly, abort.
if ( !defined( 'ABSPATH' ) ) {
  die( 'Direct access is forbidden.' );
}

use SourceFramework\Abstracts\Singleton;
use WP_Customize_Manager;
use WP_Customize_Color_Control;
use WP_Customize_Image_Control;

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

    add_action( 'customize_register', [ $this, 'login_page' ] );
    add_action( 'customize_register', [ $this, 'development' ] );
  }

  /**
   * Adds the development menu to theme customizer
   *
   * @since     2.0.0
   *
   * @param WP_Customize_Manager $wp_customize
   */
  public function development( $wp_customize ) {
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

  /**
   * Adds the login page menu to theme customizer
   *
   * @since     2.0.0
   *
   * @param WP_Customize_Manager $wp_customize
   */
  public function login_page( $wp_customize ) {
    $section_id = 'login_page_customizer_section';

    $wp_customize->add_section( 'login_page_customizer_section', [
        'title'    => __( 'Login Page', SF_TEXTDOMAIN ),
        'priority' => 1000,
    ] );

    $wp_customize->add_setting( 'login-page-background-image' );
    $wp_customize->add_control(
            new WP_Customize_Image_Control( $wp_customize, 'logo', [
        'label'    => __( 'Background image', SF_TEXTDOMAIN ),
        'section'  => $section_id,
        'settings' => 'login-page-background-image',
            ] )
    );

    $wp_customize->add_setting( 'login-page-background-color', [ 'default' => '#f1f1f1', ] );
    $wp_customize->add_control(
            new WP_Customize_Color_Control( $wp_customize, 'login-page-background-color', [
        'label'    => __( 'Background color', SF_TEXTDOMAIN ),
        'section'  => $section_id,
        'settings' => 'login-page-background-color',
            ] )
    );

    $wp_customize->add_setting( 'login-page-font-color', [ 'default' => '#555d66', ] );
    $wp_customize->add_control(
            new WP_Customize_Color_Control( $wp_customize, 'login-page-font-color', [
        'label'    => __( 'Font color', SF_TEXTDOMAIN ),
        'section'  => $section_id,
        'settings' => 'login-page-font-color',
            ] )
    );

    $wp_customize->add_setting( 'login-page-header-image' );
    $wp_customize->add_control(
            new WP_Customize_Image_Control( $wp_customize, 'logo', [
        'label'       => __( 'Header image', SF_TEXTDOMAIN ),
        'section'     => $section_id,
        'settings'    => 'login-page-header-image',
        'description' => __( 'The custom header is centered and contained in a 320 x 60 pixels block', SF_TEXTDOMAIN ),
            ] )
    );

    $wp_customize->add_setting( 'login-page-link-url' );
    $wp_customize->add_control( 'login-page-link-url', [
        'label'    => __( 'Link URL', SF_TEXTDOMAIN ),
        'section'  => 'login_page_customizer_section',
        'settings' => 'login-page-link-url',
        'type'     => 'text',
    ] );

    $wp_customize->add_setting( 'login-page-link-caption' );
    $wp_customize->add_control( 'login-page-linkcaption', [
        'label'    => __( 'Link Caption', SF_TEXTDOMAIN ),
        'section'  => 'login_page_customizer_section',
        'settings' => 'login-page-link-caption',
        'type'     => 'text',
    ] );
  }

}
