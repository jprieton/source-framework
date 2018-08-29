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

  /**
   * Class constructor
   * Declared as protected to prevent creating a new instance outside of the class via the new operator.
   *
   * @since   2.0.0
   */
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
    $wp_customize->add_setting( 'bootstrap_breakpoint_helper' );
    $wp_customize->add_section( 'development_customizer_section', [
        'title'    => __( 'Development', SF_TEXTDOMAIN ),
        'priority' => 1000,
    ] );
    $wp_customize->add_control( 'bootstrap-helper', [
        'label'    => __( 'Bootstrap 4.x Breakpoint Helper', SF_TEXTDOMAIN ),
        'section'  => 'development_customizer_section',
        'settings' => 'bootstrap_breakpoint_helper',
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
    $section_id = 'login_customizer_section';

    $wp_customize->add_section( $section_id, [
        'title'    => __( 'Login Page', SF_TEXTDOMAIN ),
        'priority' => 1000,
    ] );

    $wp_customize->add_setting( 'login_background_color', [ 'default' => '#f1f1f1', ] );
    $wp_customize->add_control(
            new WP_Customize_Color_Control( $wp_customize, 'login_background_color', [
        'label'    => __( 'Background color', SF_TEXTDOMAIN ),
        'section'  => $section_id,
        'settings' => 'login_background_color',
            ] )
    );

    $wp_customize->add_setting( 'login_background_image' );
    $wp_customize->add_control(
            new WP_Customize_Image_Control( $wp_customize, 'login_background_image', [
        'label'    => __( 'Background image', SF_TEXTDOMAIN ),
        'section'  => $section_id,
        'settings' => 'login_background_image',
            ] )
    );

    $wp_customize->add_setting( 'login_background_position' );
    $wp_customize->add_control( 'login_background_position', [
        'label'    => __( 'Background position', SF_TEXTDOMAIN ),
        'section'  => $section_id,
        'settings' => 'login_background_position',
        'type'     => 'select',
        'choices'  => [
            ''        => 'Auto',
            'contain' => 'Contain',
            'cover'   => 'Cover',
            'repeat'  => 'Repeat',
        ]
    ] );

    $wp_customize->add_setting( 'login_font_color', [ 'default' => '#555d66', ] );
    $wp_customize->add_control(
            new WP_Customize_Color_Control( $wp_customize, 'login_font_color', [
        'label'    => __( 'Font color', SF_TEXTDOMAIN ),
        'section'  => $section_id,
        'settings' => 'login_font_color',
            ] )
    );

    $wp_customize->add_setting( 'login_header_image' );
    $wp_customize->add_control(
            new WP_Customize_Image_Control( $wp_customize, 'login_header_image', [
        'label'       => __( 'Header image', SF_TEXTDOMAIN ),
        'section'     => $section_id,
        'settings'    => 'login_header_image',
        'description' => __( 'The custom header is centered and contained in a 320 x 84 pixels block', SF_TEXTDOMAIN ),
            ] )
    );

    $wp_customize->add_setting( 'login_header_url' );
    $wp_customize->add_control( 'login_header_url', [
        'label'    => __( 'Header URL', SF_TEXTDOMAIN ),
        'section'  => $section_id,
        'settings' => 'login_header_url',
        'type'     => 'text',
    ] );

    $wp_customize->add_setting( 'login_header_title' );
    $wp_customize->add_control( 'login_header_title', [
        'label'    => __( 'Header Title', SF_TEXTDOMAIN ),
        'section'  => $section_id,
        'settings' => 'login_header_title',
        'type'     => 'text',
    ] );
  }

}
