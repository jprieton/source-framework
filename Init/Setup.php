<?php

/**
 * If this file is called directly, abort.
 */
if ( !defined( 'ABSPATH' ) ) {
  die( 'Direct access is forbidden.' );
}

/**
 * Aliases
 */
use SourceFramework\Init\SetupInit;

/**
 * Dependencies
 */
if ( !class_exists( 'SetupInit' ) ) {
  require_once SourceFramework\ABSPATH . '/Init/SetupInit.php';
}

/**
 * The code that runs when the plugin is activated.
 * @since 1.0.0
 */
register_activation_hook( SourceFramework\PLUGIN_FILE, [ SetupInit::get_instance(), 'activation_hook' ] );

/**
 * The code that runs when the plugin is deactivated.
 * @since 1.0.0
 */
register_deactivation_hook( SourceFramework\PLUGIN_FILE, [ SetupInit::get_instance(), 'deactivation_hook' ] );

/**
 * The code that runs when the plugin is uninstalled.
 * @since 1.0.0
 */
register_uninstall_hook( SourceFramework\PLUGIN_FILE, [ SetupInit::get_instance(), 'uninstall_hook' ] );
