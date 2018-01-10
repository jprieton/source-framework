<?php

namespace SourceFramework\Admin;

/**
 * If this file is called directly, abort.
 */
if ( !defined( 'ABSPATH' ) ) {
  die( 'Direct access is forbidden.' );
}

/**
 * FeaturedPost class
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

    remove_meta_box( 'postexcerpt', '', 'normal' );
    add_meta_box( 'postexcerpt2', __( 'Excerpt' ), array( __CLASS__, 'metabox' ), null, 'normal', 'core' );
  }

  /**
   * Output for the meta box.
   *
   * @since          1.0.0
   *
   * @param  object $post
   * @return void
   */
  public static function metabox( $post ) {
    ?>
    <label class="screen-reader-text" for="excerpt"><?php _e( 'Excerpt' ) ?></label>
    <?php
    wp_editor(
            self::unescape( $post->post_excerpt ),
            'excerpt',
            array(
                'textarea_rows' => 15,
                'media_buttons' => false,
                'teeny'         => true,
                'tinymce'       => true
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
    $search  = array( '&lt;', '&gt;', '&quot;', '&amp;', '&nbsp;', '&amp;nbsp;' );
    $replace = array( '<', '>', '"', '&', ' ', ' ' );

    return str_replace( $search, $replace, $str );
  }

}
