<?php

/**
 * Plugin Name:   SourceFramework
 * Plugin URI:    https://github.com/jprieton/source-framework
 * Description:   An extensible object-oriented micro-framework for WordPress that helps you to develop themes and plugins.
 * Version:       2.2.0
 * Author:        Javier Prieto
 * Author URI:    https://github.com/jprieton
 * Text Domain:   source-framework
 * Domain Path:   /languages/
 *
 * SourceFramework is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * any later version.
 *
 * SourceFramework is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with SourceFramework. If not, see http://www.gnu.org/licenses/gpl-3.0.txt.
 *
 * @package SourceFramework
 */

defined( 'ABSPATH' ) || exit;

/**
 * Define plugin constants
 * @since 1.0.0
 */
define( 'SF_VERSION', '2.2.0' );
define( 'SF_FILENAME', __FILE__ );
define( 'SF_BASENAME', plugin_basename( __FILE__ ) );
define( 'SF_BASEDIR', __DIR__ );
define( 'SF_BASEURL', plugin_dir_url( __FILE__ ) );
define( 'SF_TEXTDOMAIN', 'source-framework' );
define( 'SF_ABSPATH', plugin_dir_path( SF_FILENAME ) . 'includes' );

//Registering an autoload implementation
spl_autoload_register( function($class_name) {
  $namespace = explode( '\\', $class_name );

  if ( $namespace[0] != 'SourceFramework' ) {
    return false;
  }

  $namespace = array_map( 'strtolower', $namespace );

  if ( in_array( 'abstracts', $namespace ) ) {
    $class_filename = 'abstract-class-' . str_replace( '_', '-', end( $namespace ) );
    array_pop( $namespace );
    array_pop( $namespace );
  } else if ( in_array( 'traits', $namespace ) ) {
    $class_filename = 'trait-' . str_replace( '_', '-', end( $namespace ) );
    array_pop( $namespace );
    array_pop( $namespace );
  } else {
    $class_filename = 'class-' . str_replace( '_', '-', end( $namespace ) );
    array_pop( $namespace );
  }

  $namespace[0] = SF_ABSPATH;
  $namespace[]  = $class_filename;

  $filename = implode( DIRECTORY_SEPARATOR, $namespace ) . '.php';

  if ( file_exists( $filename ) ) {
    require $filename;
  } else if ( defined( 'WP_DEBUG' ) && WP_DEBUG ) {

    $backtrace = debug_backtrace();

    foreach ( $backtrace as $info ) {
      if ( empty( $info['file'] ) || $info['function'] != 'spl_autoload_call' ) {
        continue;
      }
      break;
    }

    // development
    var_dump( $class_name, $filename, $info['file'] );
    die;
  } else {
    wp_die( sprintf( __( "The class %s could not be loaded", SF_TEXTDOMAIN ), "<b><code>{$class_name}</code></b>" ) );
  }
} );

// This hook load the plugin textdomain
add_action( 'plugins_loaded', [ 'SourceFramework\Core\Textdomain', 'load_plugin_textdomain' ] );

// This hook adds tanslation to plugin description
add_action( 'all_plugins', [ 'SourceFramework\Core\Textdomain', 'modify_plugin_description' ] );

// Check if the minimum requirements are met
if ( version_compare( PHP_VERSION, '5.6.20', '<' ) ) {

  /**
   * Show notice for minimum PHP version required for SourceFramework
   * @since 2.0.0
   */
  add_action( 'admin_notices', function () {
    $message = __( 'SourceFramework requires PHP version 5.6.20 or later.', SF_TEXTDOMAIN );
    printf( '<div class="notice notice-error is-dismissible"><p>%s</p></div>', esc_html( $message ) );
  } );
} else {

  // Initialize SourceFramework
  SourceFramework\Core\Init::get_instance();
}
