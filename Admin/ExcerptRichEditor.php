<?php

namespace SourceFramework\Admin;

/**
 * If this file is called directly, abort.
 */
if ( !defined( 'ABSPATH' ) ) {
  die( 'Direct access is forbidden.' );
}

/**
 * Importer class
 *
 * @package        Admin
 * @since          1.0.0
 * @author         Javier Prieto <jprieton@gmail.com>
 */
class ExcerptRichEditor {

  /**
   * Replaces the meta boxes.
   *
   * @since          1.0.0
   *
   * @return void
   */
  public static function switch_metabox() {
    if ( !post_type_supports( $GLOBALS['post']->post_type, 'excerpt' ) ) {
      return;
    }

    remove_meta_box(
            'postexcerpt' // ID
            , ''            // Screen, empty to support all post types
            , 'normal'      // Context
    );

    add_meta_box(
            'postexcerpt2'     // Reusing just 'postexcerpt' doesn't work.
            , __( 'Excerpt' )    // Title
            , array( __CLASS__, 'show' ) // Display function
            , null              // Screen, we use all screens with meta boxes.
            , 'normal'          // Context
            , 'core'            // Priority
    );
  }

  /**
   * Output for the meta box.
   *
   * @since          1.0.0
   *
   * @param  object $post
   * @return void
   */
  public static function show( $post ) {
    ?>
    <label class="screen-reader-text" for="excerpt"><?php _e( 'Excerpt' ) ?></label>
    <?php
    wp_editor(
            self::unescape( $post->post_excerpt ),
            'excerpt',
            array(
                'textarea_rows' => 15
                , 'media_buttons' => false
                , 'teeny'         => true
                , 'tinymce'       => true
            )
    );
  }

  /**
   * The excerpt is escaped usually. This breaks the HTML editor.
   *
   * @since          1.0.0
   *
   * @param  string $str
   * @return string
   */
  public static function unescape( $str ) {
    return str_replace(
            array( '&lt;', '&gt;', '&quot;', '&amp;', '&nbsp;', '&amp;nbsp;' )
            , array( '<', '>', '"', '&', ' ', ' ' )
            , $str
    );
  }

}
