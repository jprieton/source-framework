<?php

namespace SourceFramework\Data;

/**
 * If this file is called directly, abort.
 */
if ( !defined( 'ABSPATH' ) ) {
  die( 'Direct access is forbidden.' );
}

/**
 * Ajax CSV PostImport class
 *
 * @package        Data
 * @since          1.0.0
 * @author         Javier Prieto <jprieton@gmail.com>
 */
class AjaxPostImport extends PostImport {

  public function __construct() {
    parent::__construct();
  }

}
