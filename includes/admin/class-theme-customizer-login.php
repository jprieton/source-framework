<?php

namespace SourceFramework\Admin;

// If this file is called directly, abort.
if ( !defined( 'ABSPATH' ) ) {
  die( 'Direct access is forbidden.' );
}

use SourceFramework\Abstracts\Singleton;

/**
 * Theme_Customizer_Login class
 *
 * @package        SourceFramework
 * @subpackage     Admin
 * @since          2.0.0
 * @author         Javier Prieto
 */
class Theme_Customizer_Login extends Singleton {

  /**
   * Single instance of this class
   *
   * @since     2.0.0
   * @var       Theme_Customizer_Login
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

    add_filter( 'login_headerurl', [ $this, 'login_header_url' ], 99 );
    add_filter( 'login_headertitle', [ $this, 'login_header_title' ], 99 );
    add_action( 'login_enqueue_scripts', [ $this, 'login_header_image' ], 99 );
    add_action( 'login_enqueue_scripts', [ $this, 'login_font_color' ], 99 );
    add_action( 'login_enqueue_scripts', [ $this, 'login_background_color' ], 99 );
    add_action( 'login_enqueue_scripts', [ $this, 'login_background' ], 99 );
  }

  /**
   * Replace the header url with custom url
   *
   * @since   2.0.0
   *
   * @param   string $url
   * @return  string
   */
  public function login_header_url( $url ) {
    $custom_url = get_theme_mod( 'login_header_url' );
    return $custom_url ?: $url;
  }

  /**
   * Replace the header title with custom string
   *
   * @since   2.0.0
   *
   * @param   string $title
   * @return  string
   */
  public function login_header_title( $title ) {
    $custom_title = get_theme_mod( 'login_header_title' );
    return $custom_title ?: $title;
  }

  /**
   * Replace the header WordPress logo with custom image
   *
   * @since   2.0.0
   *
   * @return  string
   */
  public function login_header_image() {
    $custom_image = get_theme_mod( 'login_header_image' );

    if ( !empty( $custom_image ) ) {
      ?>
      <style type="text/css">
        #login h1 a {
          background-image: url(<?php echo $custom_image ?>);
          background-position: center;
          background-size: contain;
          height: 84px;
          width: 320px;
        }
      </style>
      <?php
    }
  }

  /**
   * Replace the font color of WordPress login page
   *
   * @since   2.0.0
   *
   * @return  string
   */
  public function login_font_color() {
    $custom_font_color = get_theme_mod( 'login_font_color' );

    if ( !empty( $custom_font_color ) ) {
      ?>
      <style type="text/css">
        body.login #backtoblog a, body.login #nav a, body.login a.privacy-policy-link {
          color: <?php echo $custom_font_color ?>;
          text-decoration: none;
        }
        body.login #backtoblog a:hover, body.login #nav a:hover, body.login a.privacy-policy-link:hover {
          color: #00a0d2;
        }
      </style>
      <?php
    }
  }

  /**
   * Replace the background color of WordPress login page
   *
   * @since   2.0.0
   *
   * @return  string
   */
  public function login_background_color() {
    $custom_background_color = get_theme_mod( 'login_background_color' );

    if ( !empty( $custom_background_color ) ) {
      ?>
      <style type="text/css">
        body.login  {
          background-color: <?php echo $custom_background_color ?>;
        }
      </style>
      <?php
    }
  }

  /**
   * Sets the background position of WordPress login page
   *
   * @since   2.0.0
   *
   * @return  string
   */
  public function login_background() {
    $background_position = get_theme_mod( 'login_background_position' );
    $background_image    = get_theme_mod( 'login_background_image' );

    $position = 'center';
    $size     = 'auto';
    $repeat   = 'no-repeat';

    switch ( $background_position ) {
      case 'contain':
        $size = 'contain';
        break;

      case 'cover':
        $size = 'cover';
        break;

      case 'repeat':
        $repeat = 'repeat';
        break;
    }

    if ( !empty( $background_image ) ) {
      ?>
      <style type="text/css">
        body.login  {
          background-image: url(<?php echo $background_image ?>);
          background-position: <?php echo $position ?>;
          background-size:  <?php echo $size ?>;
          background-repeat:  <?php echo $repeat ?>;
        }
      </style>
      <?php
    }
  }

}
