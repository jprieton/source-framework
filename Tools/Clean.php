<?php

namespace SourceFramework\Tools;

/**
 * If this file is called directly, abort.
 */
if ( !defined( 'ABSPATH' ) ) {
  die( 'Direct access is forbidden.' );
}

use wpdb;

/**
 * Clean class
 *
 * @package        SourceFramework
 * @subpackage     Tools
 * @since          1.0.0
 * @author         Javier Prieto <jprieton@gmail.com>
 */
class Clean {

  /**
   * Delete all non-linked metadata
   *
   * @global wpdb $wpdb
   */
  public function delete_orphan_metadata() {
    global $wpdb;

    // postmeta
    $wpdb->query( "DELETE FROM {$wpdb->postmeta} WHERE post_id NOT IN ( SELECT ID AS post_id FROM {$wpdb->posts} )" );

    // usermeta
    $wpdb->query( "DELETE FROM {$wpdb->usermeta} WHERE user_id NOT IN ( SELECT ID AS user_id FROM {$wpdb->users} )" );

    // termmeta
    $wpdb->query( "DELETE FROM {$wpdb->termmeta} WHERE term_id NOT IN ( SELECT term_id FROM {$wpdb->terms} )" );

    // commentmeta
    $wpdb->query( "DELETE FROM {$wpdb->commentmeta} WHERE comment_id NOT IN ( SELECT comment_ID AS comment_id FROM {$wpdb->comments} )" );
  }

  /**
   * Delete all non-linked comments
   *
   * @global wpdb $wpdb
   */
  public function delete_orphan_comments() {
    global $wpdb;

    // comments
    $wpdb->query( "DELETE FROM {$wpdb->comments} WHERE comment_post_ID NOT IN ( SELECT ID AS comment_post_ID FROM {$wpdb->posts} )" );

    // commentmeta
    $wpdb->query( "DELETE FROM {$wpdb->commentmeta} WHERE comment_id NOT IN ( SELECT comment_ID as comment_id FROM {$wpdb->comments} )" );
  }

}
