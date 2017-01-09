<?php

namespace SourceFramework\Core;

/**
 * If this file is called directly, abort.
 */
if ( !defined( 'ABSPATH' ) ) {
  die( 'Direct access is forbidden.' );
}

/**
 * PublicInit class
 *
 * @package        Core
 * @subpackage     Init
 * @since          1.0.0
 * @author         Javier Prieto <jprieton@gmail.com>
 */
final class PublicInit extends \SourceFramework\Abstracts\Singleton {

  /**
   * Static instance of this class
   *
   * @since         1.0.0
   * @var           PublicInit
   */
  protected static $instance;

}
