<?php

namespace SourceFramework\Tools;

/**
 * If this file is called directly, abort.
 */
if ( !defined( 'ABSPATH' ) ) {
  die( 'Direct access is forbidden.' );
}

use SourceFramework\Settings\SettingGroup;

/**
 *
 */
class FrontendHelper {

  /**
   *
   */
  public function __construct() {
    add_filter( 'source_framework_styles', [ $this, 'register_styles' ] );
    add_filter( 'source_framework_scripts', [ $this, 'register_scripts' ] );
    add_action( 'wp_footer', [ $this, 'load_template' ], 999 );
  }

  /**
   *
   * @param array $styles
   * @return array
   */
  public function register_styles( $styles ) {
    $styles['frontend-helper']['autoload'] = true;
    return $styles;
  }

  /**
   *
   * @param array $scripts
   * @return array
   */
  public function register_scripts( $scripts ) {
    $scripts['modernizr']['autoload'] = true;
    return $scripts;
  }

  /**
   * 
   */
  public function load_template() {
    include_once \SourceFramework\ABSPATH . '/partials/frontend-helper.php';
  }

}
