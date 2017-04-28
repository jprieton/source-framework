<?php

/**
 * Plugin Name:    SourceFramework
 * Description:    An extensible framework for WordPress themes and plugins
 * Version:        1.0.0-dev
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
 */
define( 'SourceFramework\ABSPATH', file_exists( __DIR__ . '/source-framework.phar' ) ? 'phar://' . __DIR__ . '/source-framework.phar' : __DIR__  );
define( 'SourceFramework\VERSION', '1.0.0' );
define( 'SourceFramework\PLUGIN_FILE', __FILE__ );
define( 'SourceFramework\BASENAME', plugin_basename( __FILE__ ) );
define( 'SourceFramework\TEXDOMAIN', 'source-framework' );

include_once SourceFramework\ABSPATH . '/includes/init.php';

/**
 * The code that runs when the plugin is activated.
 * @since 1.0.0
 */
register_activation_hook( __FILE__, [ 'SourceFramework\Core\Setup', 'activation_hook' ] );

/**
 * The code that runs when the plugin is deactivated.
 * @since 1.0.0
 */
register_deactivation_hook( __FILE__, [ 'SourceFramework\Core\Setup', 'deactivation_hook' ] );

/**
 * The code that runs when the plugin is uninstalled.
 * @since 1.0.0
 */
register_uninstall_hook( __FILE__, [ 'SourceFramework\Core\Setup', 'uninstall_hook' ] );
