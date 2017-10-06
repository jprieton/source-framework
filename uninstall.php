<?php

/**
 * Fired when the plugin is uninstalled.
 *
 * @package     SourceFramework\Uninstall
 * @author      Javier Prieto <jprieton@gmail.com>
 * @since       1.3.0
 */

/**
 * If uninstall, not called from WordPress, abort.
 */
if ( !defined( 'WP_UNINSTALL_PLUGIN' ) ) {
  die( 'Direct access is forbidden.' );
}

// TODO: Define uninstall functionality
