<?php

namespace SourceFramework\Misc;

/**
 * If this file is called directly, abort.
 */
if ( !defined( 'ABSPATH' ) ) {
  die( 'Direct access is forbidden.' );
}

/**
 * Media helper class
 *
 * @package     SourceFramework
 * @subpackage  Misc
 *
 * @author      Javier Prieto <jprieton@gmail.com>
 * @copyright	  Copyright (c) 2017, Javier Prieto
 * @since       1.0.0
 * @license     http://www.gnu.org/licenses/gpl-3.0.txt
 */
class Media {

  /**
   * Returns an array with original image size used in imagecopyresampled
   *
   * @since   1.0.0
   *
   * @param   int            $orig_w
   * @param   int            $orig_h
   * @return  array
   */
  public static function image_resize_dimensions_default( $orig_w, $orig_h ) {
    return array( $orig_w, $orig_h, 0, 0, $orig_w, $orig_h, $orig_w, $orig_h );
  }

}
