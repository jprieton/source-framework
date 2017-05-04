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
 */
define( 'SourceFramework\ABSPATH', file_exists( __DIR__ . '/source-framework.phar' ) ? 'phar://' . __DIR__ . '/source-framework.phar' : __DIR__  );
define( 'SourceFramework\VERSION', '1.0.0' );
define( 'SourceFramework\PLUGIN_FILE', __FILE__ );
define( 'SourceFramework\BASENAME', plugin_basename( __FILE__ ) );
define( 'SourceFramework\TEXDOMAIN', 'source-framework' );

/**
 * Activation, Deactivation and Uninstall hooks
 * @since 1.0.0
 */
include_once SourceFramework\ABSPATH . '/Init/Setup.php';

include_once SourceFramework\ABSPATH . '/includes/init.php';

/**
 * CoreInit
 * @since 1.0.0
 */
require_once SourceFramework\ABSPATH . '/core/init.php';

if ( is_admin() ) {
  /**
   * AdminInit
   * @since 1.0.0
   */
  include_once SourceFramework\ABSPATH . '/admin/init.php';
} else {
  /**
   * PublicInit
   * @since 1.0.0
   */
  include_once SourceFramework\ABSPATH . '/public/init.php';
}

