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
 * Cron class
 *
 * @package        Core
 * @subpackage     Cron
 * @since          1.5.0
 * @author         Javier Prieto <jprieton@gmail.com>
 */
class Cron extends Singleton {

  /**
   * Static instance of this class
   *
   * @since         1.5.0
   * @var           Cron
   */
  protected static $instance;

  /**
   * Declared as protected to prevent creating a new instance outside of the class via the new operator.
   *
   * @since         1.5.0
   */
  protected function __construct() {
    parent::__construct();

    /**
     * Adds non-default cron schedules
     * @since         1.5.0
     */
    add_filter( 'cron_schedules', array( $this, 'add_cron_schedules' ) );

    /**
     * Delete all non-linked metadata
     * @since         1.5.0
     */
    add_action( 'delete_orphan_metadata', array( 'SourceFramework\Tools\Clean', 'delete_orphan_metadata' ) );

    /**
     * Delete all non-linked comments
     * @since         1.5.0
     */
    add_action( 'delete_orphan_comments', array( 'SourceFramework\Tools\Clean', 'delete_orphan_comments' ) );
  }

  /**
   * Adds non-default cron schedules
   *
   * @since         1.5.0
   *
   * @param array $schedules
   * @return array
   */
  public function add_cron_schedules( $schedules = array() ) {
    return array_merge( $schedules, [ 'weekly'  => [
            'interval' => WEEK_IN_SECONDS,
            'display'  => __( 'Once weekly', \SourceFramework\TEXTDOMAIN ),
        ],
        'monthly' => [
            'interval' => MONTH_IN_SECONDS,
            'display'  => __( 'Once weekly', \SourceFramework\TEXTDOMAIN ),
        ] ] );
  }

  /**
   * Remove all plugin's cron jobs
   *
   * @since 1.5.0
   */
  public static function clear_scheduled() {
    wp_clear_scheduled_hook( 'delete_orphan_metadata' );
    wp_clear_scheduled_hook( 'delete_orphan_comments' );
  }

}
