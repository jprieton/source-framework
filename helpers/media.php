<?php

/**
 * If this file is called directly, abort.
 */
if ( !defined( 'ABSPATH' ) ) {
  die( 'Direct access is forbidden.' );
}

/**
 * Returns an array with original image size used in imagecopyresampled
 *
 * @since   1.0.0
 *
 * @package Helper
 * @subpackage Media
 *
 * @param   int            $orig_w
 * @param   int            $orig_h
 * @return  array
 */
function image_resize_dimensions_default( $orig_w, $orig_h ) {
  return array( $orig_w, $orig_h, 0, 0, $orig_w, $orig_h, $orig_w, $orig_h );
}
