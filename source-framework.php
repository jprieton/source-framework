<?php

/**
 * Plugin Name:    SourceFramework
 * Description:    An extensible framework for WordPress themes and plugins
 * Version:        1.0.0
 * Author:         Javier Prieto <jprieton@gmail.com>
 * License:        GPL3
 * License URI:    http://www.gnu.org/licenses/gpl-3.0.txt
 * Text Domain:    source-framework
 * Domain Path:    /languages
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
 */
/**
 * If this file is called directly, abort.
 */
if ( !defined( 'ABSPATH' ) ) {
  die( 'Direct access is forbidden.' );
}

/**
 * Define plugin constants
 * @since 1.0.0
 */
if ( file_exists( plugin_dir_path( __FILE__ ) . 'source-framework.phar' ) ) {
  define( 'SourceFramework\ABSPATH', 'phar://' . plugin_dir_path( __FILE__ ) . 'source-framework.phar' );
} else {
  define( 'SourceFramework\ABSPATH', plugin_dir_path( __FILE__ ) );
}
define( 'SourceFramework\VERSION', '1.0.0' );
define( 'SourceFramework\PLUGIN_FILE', __FILE__ );
define( 'SourceFramework\BASENAME', plugin_basename( __FILE__ ) );
define( 'SourceFramework\TEXDOMAIN', 'source-framework' );


/**
 * Registering an autoload implementation
 * @since 1.0.0
 */
spl_autoload_register( function($class_name) {

  $namespace = explode( '\\', $class_name );

  if ( $namespace[0] != 'SourceFramework' ) {
    return false;
  }

  $namespace[0] = SourceFramework\ABSPATH;
  $filename     = implode( DIRECTORY_SEPARATOR, $namespace ) . '.php';

  if ( file_exists( $filename ) ) {
    include $filename;
  }
} );

/**
 * Core Init
 * @since 1.0.0
 */
SourceFramework\Init\CoreInit::get_instance();

if ( is_admin() ) {
  
} else {
  /**
   * Public Init
   * @since 1.0.0
   */
  SourceFramework\Init\PublicInit::get_instance();
}