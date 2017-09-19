<?php

namespace SourceFramework\Widgets;

/**
 * If this file is called directly, abort.
 */
if ( !defined( 'ABSPATH' ) ) {
  die( 'Direct access is forbidden.' );
}

use WP_Widget;

/**
 * @since 1.0.0
 */
class FeaturedPostsWidget extends WP_Widget {

  /**
   * Sets up the widgets name etc
   */
  public function __construct() {
    parent::__construct(
            // id_base
            'featured_posts',
            // name
            'Featured Posts',
            // widget_options
            array( 'description' => 'Featured post' ),
            // control_options
            array() );
  }

}
