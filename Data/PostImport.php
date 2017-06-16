<?php

namespace SourceFramework\Data;

/**
 * If this file is called directly, abort.
 */
if ( !defined( 'ABSPATH' ) ) {
  die( 'Direct access is forbidden.' );
}

/**
 * CSV PostImport class
 *
 * @package        Data
 * @since          1.0.0
 * @author         Javier Prieto <jprieton@gmail.com>
 */
class PostImport {

  private $default = [
      'ID'                    => 0,
      'post_author'           => '',
      'post_date'             => '0000-00-00 00:00:00',
      'post_date_gmt'         => '0000-00-00 00:00:00',
      'post_content'          => '',
      'post_title'            => '',
      'post_excerpt'          => '',
      'post_status'           => 'publish',
      'comment_status'        => 'open',
      'ping_status'           => 'open',
      'post_password'         => '',
      'post_name'             => '',
      'to_ping'               => '',
      'pinged'                => '',
      'post_modified'         => '0000-00-00 00:00:00',
      'post_modified_gmt'     => '0000-00-00 00:00:00',
      'post_content_filtered' => '',
      'post_parent'           => 0,
      'guid'                  => '',
      'menu_order'            => 0,
      'post_type'             => 'post',
      'post_mime_type'        => '',
      'comment_count'         => 0,
      'tax_input'             => [],
      'meta_input'            => [],
  ];

  public function __construct() {

  }

}
