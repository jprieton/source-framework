<?php

namespace SourceFramework\Core;

/**
 * If this file is called directly, abort.
 */
if ( !defined( 'ABSPATH' ) ) {
  die( 'Direct access is forbidden.' );
}

use SourceFramework\Abstracts\Singleton;

/**
 * SourceFrameworkPublic class
 *
 * @package        Core
 * @subpackage     Init
 * @since          1.0.0
 * @author         Javier Prieto <jprieton@gmail.com>
 */
final class SourceFrameworkPublic extends Singleton {

  /**
   * Static instance of this class
   *
   * @since         1.0.0
   * @var           SourceFrameworkPublic
   */
  protected static $instance;

  /**
   * Declared as protected to prevent creating a new instance outside of the class via the new operator.
   *
   * @since         1.0.0
   */
  protected function __construct() {
    parent::__construct();

    /**
     * Shows a custom code in header of the singular template
     * @since 1.0.0
     */
    add_action( 'wp_head', [ $this, 'singular_custom_code_header_script' ] );

    /**
     * Shows a custom code on top of body
     * @since 1.0.0
     */
    add_action( 'before_main_content', [ $this, 'singular_before_main_content' ] );

    /**
     * Shows a custom code in footer of the singular template
     * @since 1.0.0
     */
    add_action( 'after_main_content', [ $this, 'singular_after_main_content' ] );

    /**
     * Add shortcodes
     * @since 1.0.0
     */
    $this->add_shorcodes();
  }

  /**
   * Add shortcodes
   *
   * @since 1.0.0
   */
  public function add_shorcodes() {
    /**
     * Add an ofuscate mailto link to prevent spam-bots from sniffing it.
     * @since 1.0.0
     */
    add_shortcode( 'mailto', [ 'SourceFramework\Template\Shortcode', 'mailto' ] );
  }

  /**
   * Shows a custom code in header of the singular template
   *
   * @since 1.0.0
   *
   * @global WP_Post $post
   */
  public function singular_custom_code_header_script() {
    if ( !(is_singular() && get_bool_option( 'enabled_singular_custom_code' )) ) {
      return;
    }

    global $post;

    $script = get_post_meta( $post->ID, '_header_custom_code', true );

    if ( !empty( $script ) ) {
      echo (string) $script;
    }
  }

  /**
   * Shows a custom code in footer of the singular template
   *
   * @since 1.0.0
   *
   * @global WP_Post $post
   */
  public function singular_after_main_content() {
    if ( !(is_singular() && get_bool_option( 'enabled_singular_custom_code' )) ) {
      return;
    }

    global $post;

    $script = get_post_meta( $post->ID, '_after_main_content', true );

    if ( !empty( $script ) ) {
      echo (string) $script;
    }
  }

  /**
   * Shows a custom code in top of body of the singular template
   *
   * @since 1.0.0
   *
   * @global WP_Post $post
   */
  public function singular_before_main_content() {
    if ( !(is_singular() && get_bool_option( 'enabled_singular_custom_code' )) ) {
      return;
    }

    global $post;

    $script = get_post_meta( $post->ID, '_before_main_content', true );

    if ( !empty( $script ) ) {
      echo (string) $script;
    }
  }

}
