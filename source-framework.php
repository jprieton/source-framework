<?php

/**
 * Plugin Name:    Source Framework
 * Description:    An extensible framework for WordPress themes based on Bootstrap v3.x
 * Version:        1.0.0-dev
 * Author:         Javier Prieto <jprieton@gmail.com>
 * License:        GPL3
 * License URI:    http://www.gnu.org/licenses/gpl-3.0.txt
 * Text Domain:    source-framework
 * Domain Path:    /languages
 *
 * Source Framework is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * any later version.
 *
 * Source Framework is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with Source Framework. If not, see http://www.gnu.org/licenses/gpl-3.0.txt.
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
define( 'SourceFramework\ABSPATH', dirname( __FILE__ ) );
define( 'SourceFramework\VERSION', '1.0.0' );
define( 'SourceFramework\PLUGIN_FILE', __FILE__ );
define( 'SourceFramework\BASENAME', plugin_basename( __FILE__ ) );

/**
 * Load dependencies
 */
include_once __DIR__ . '/core/init.php';
include_once __DIR__ . '/helpers/init.php';
include_once __DIR__ . '/Builders/Init.php';

if ( is_admin() ) {
  /**
   * Load admin dependencies
   */
  include_once __DIR__ . '/admin/init.php';
} else {
  /**
   * Load public dependencies
   */
  include_once __DIR__ . '/public/init.php';
}

/**
 * The code that runs during plugin activation.
 */
register_activation_hook( __FILE__, function() {
  require_once __DIR__ . '/includes/class-activator.php';
  SourceFramework\Activator::activate();
} );

/**
 * The code that runs during plugin activation.
 */
register_deactivation_hook( __FILE__, function() {
  require_once __DIR__ . '/includes/class-activator.php';
  SourceFramework\Activator::deactivate();
} );
