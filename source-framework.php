<?php

/*
 * Plugin Name:   SourceFramework
 * Plugin URI:    https://github.com/jprieton/source-framework
 * Description:   An extensible object-oriented micro-framework for WordPress that helps you to develop themes and plugins.
 * Version:       2.0.0
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

// If this file is called directly, abort.
if ( !defined( 'ABSPATH' ) ) {
  die( 'Direct access is forbidden.' );
}

/**
 * Define plugin constants
 * @since 1.0.0
 */
define( 'SF_VERSION', '2.0.0' );
define( 'SF_FILENAME', __FILE__ );
define( 'SF_BASENAME', plugin_basename( __FILE__ ) );
define( 'SF_TEXTDOMAIN', 'source-framework' );

/**
 * Absolute path to the plugin or phar package
 * @since 1.0.0
 */
if ( file_exists( plugin_dir_path( SF_FILENAME ) . 'includes/source-framework.phar' ) ) {
  define( 'SF_ABSPATH', 'phar://' . plugin_dir_path( SF_FILENAME ) . 'includes/source-framework.phar' );
} else {
  define( 'SF_ABSPATH', plugin_dir_path( SF_FILENAME ) . 'includes' );
}

//Registering an autoload implementation
spl_autoload_register( function($class_name) {
  $namespace = explode( '\\', $class_name );

  if ( $namespace[0] != 'SourceFramework' ) {
    return false;
  }

  $namespace[0] = SF_ABSPATH;
  $filename     = implode( '/', $namespace ) . '.php';

  if ( file_exists( $filename ) ) {
    include $filename;
  }
} );

// This hook load the plugin textdomain
add_action( 'plugins_loaded', [ 'SourceFramework\Core\TextDomain', 'load_plugin_textdomain' ] );

// This hook adds tanslation to plugin description
add_action( 'all_plugins', [ 'SourceFramework\Core\TextDomain', 'modify_plugin_description' ] );

// Check if the minimum requirements are met
if ( version_compare( PHP_VERSION, '5.4.0', '<' ) ) {

  /**
   * Show notice for minimum PHP version required for SourceFramework
   * @since 2.0.0
   */
  function source_framework_min_php_error() {
    $message = __( 'SourceFramework requires PHP version 5.4 or later.', SF_TEXTDOMAIN );
    printf( '<div class="notice notice-error is-dismissible"><p>%s</p></div>', esc_html( $message ) );
  }

  add_action( 'admin_notices', 'source_framework_min_php_error' );
} else {

  // Initialize SourceFramework
  SourceFramework\Core\Init::instance();
}
