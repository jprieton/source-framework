<?php

namespace SourceFramework\Admin;

/**
 * If this file is called directly, abort.
 */
if ( !defined( 'ABSPATH' ) ) {
  die( 'Direct access is forbidden.' );
}

use SourceFramework\Data\PostImport;
use SourceFramework\Abstracts\Singleton;

/**
 * Importer class
 *
 * @package        Admin
 * @since          1.0.0
 * @author         Javier Prieto <jprieton@gmail.com>
 */
class Importer extends Singleton {

  /**
   * Static instance of this class
   *
   * @since         1.0.0
   * @var           Importer
   */
  protected static $instance;

  protected function __construct() {
    parent::__construct();
    $this->register_csv_importer();
  }

  private function register_csv_importer() {
    $id          = 'source_framework_csv_importer';
    $name        = __( 'SourceFramework CSV Import', \SourceFramework\TEXTDOMAIN );
    $description = __( 'Import data via CSV file.', \SourceFramework\TEXTDOMAIN );
    register_importer( $id, $name, $description, [ $this, 'csv_import_callback' ] );
  }

  public function csv_import_callback() {
    // Load Importer API
    require_once ABSPATH . 'wp-admin/includes/class-wp-importer.php';

    $post_import = new PostImport();
    $post_import->dispatch();
  }

}
