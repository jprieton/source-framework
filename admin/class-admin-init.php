<?php

namespace SourceFramework\Core;

/**
 * If this file is called directly, abort.
 */
if ( !defined( 'ABSPATH' ) ) {
  die( 'Direct access is forbidden.' );
}

/**
 * AdminInit class
 *
 * @package        Core
 * @subpackage     Init
 * @since          1.0.0
 * @author         Javier Prieto <jprieton@gmail.com>
 */
final class AdminInit extends \SourceFramework\Abstracts\Singleton {

  /**
   * Static instance of this class
   *
   * @since         1.0.0
   * @author        Javier Prieto <jprieton@gmail.com>
   * @var           AdminInit
   */
  protected static $instance;

}
