<?php

namespace SourceFramework\Core;

// If this file is called directly, abort.
if ( !defined( 'ABSPATH' ) ) {
  die( 'Direct access is forbidden.' );
}

use SourceFramework\Abstracts\Singleton;

/**
 * Cron class
 *
 * @package        SourceFramework
 * @subpackage     Cron
 * @since          1.5.0
 * @author         Javier Prieto
 */
final class Cron extends Singleton {

  /**
   * Static instance of this class
   *
   * @since     1.5.0
   * @var       Cron
   */
  protected static $instance;

  /**
   * Declared as protected to prevent creating a new instance outside of the class via the new operator.
   *
   * @since     1.5.0
   */
  protected function __construct() {
    parent::__construct();

    // Adds non-default cron schedules
    add_filter( 'cron_schedules', [ $this, 'add_cron_schedules' ] );

    // Delete all non-linked metadata
    add_action( 'delete_orphan_metadata', [ 'SourceFramework\Tools\Clean', 'delete_orphan_metadata' ] );

    // Delete all non-linked comments
    add_action( 'delete_orphan_comments', [ 'SourceFramework\Tools\Clean', 'delete_orphan_comments' ] );

    // Schedules an cron event to clean orphan data
    register_activation_hook( SF_FILENAME, [ __CLASS__, 'add_schedule' ] );

    // Un-schedule all cron events to clean orphan data
    register_deactivation_hook( SF_FILENAME, [ __CLASS__, 'remove_schedule' ] );
  }

  /**
   * Adds non-default cron schedules
   *
   * @since     1.5.0
   * @param     array     $schedules
   * @return    array
   */
  public function add_cron_schedules( $schedules = array() ) {
    return array_merge( $schedules, [ 'weekly'  => [
            'interval' => WEEK_IN_SECONDS,
            'display'  => __( 'Once weekly', SF_TEXTDOMAIN ),
        ],
        'monthly' => [
            'interval' => MONTH_IN_SECONDS,
            'display'  => __( 'Once monthly', SF_TEXTDOMAIN ),
        ] ] );
  }

  /**
   * Schedules an cron event to clean orphan data
   *
   * @since     2.0.0
   */
  public static function add_schedule() {
    $current_timestamp = current_time( 'timestamp' );
    if ( !wp_next_scheduled( 'delete_orphan_metadata' ) ) {
      wp_schedule_event( $current_timestamp, 'monthly', 'delete_orphan_metadata' );
    }
    if ( !wp_next_scheduled( 'delete_orphan_comments' ) ) {
      wp_schedule_event( $current_timestamp, 'monthly', 'delete_orphan_comments' );
    }
  }

  /**
   * Un-schedules all hooked cron events to clean orphan data
   *
   * @since     2.0.0
   */
  public static function remove_schedule() {
    wp_clear_scheduled_hook( 'delete_orphan_metadata' );
    wp_clear_scheduled_hook( 'delete_orphan_comments' );
  }

}
