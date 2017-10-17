<?php

namespace SourceFramework\Tools;

/**
 * If this file is called directly, abort.
 */
if ( !defined( 'ABSPATH' ) ) {
  die( 'Direct access is forbidden.' );
}

use SourceFramework\Settings\SettingGroup;

/**
 * @since 1.0.0
 */
class FrontendHelper {

  private $version;

  /**
   * @since 1.0.0
   */
  public function __construct() {
    add_filter( 'register_styles', [ $this, 'registerStyles' ] );
    add_filter( 'register_scripts', [ $this, 'registerScripts' ] );
    add_action( 'wp_footer', [ $this, 'loadTtemplate' ], 999 );
  }

  /**
   * @since 1.0.0
   *
   * @param array $styles
   * @return array
   */
  public function registerStyles( $styles ) {
    $styles['frontend-helper']['autoload'] = true;
    return $styles;
  }

  /**
   * @since 1.0.0
   *
   * @param array $scripts
   * @return array
   */
  public function registerScripts( $scripts ) {
    $scripts['modernizr']['autoload'] = true;
    $this->version                    = $scripts['modernizr']['ver'];
    return $scripts;
  }

  /**
   * Load FrontEnd Helper template
   * @since 1.0.0
   */
  public function loadLemplate() {
    global $tools_setting_group;

    if ( empty( $tools_setting_group ) ) {
      $tools_setting_group = new SettingGroup( 'tools_settings' );
    }

    $variant = $tools_setting_group->get_option( 'frontend-helper-enabled' );
    ?>

    <div class="frontend-helper">
      <pre class="modernizr-features hidden"></pre>
      <div>
        <div class="bs-breakpoint" title="Boostrap breakpoint">
          <?php if ( 'bootstrap3x' == $variant ) { ?>
            <div class="visible-lg">lg</div>
            <div class="visible-md">md</div>
            <div class="visible-sm">sm</div>
            <div class="visible-xs">xs</div>
          <?php } elseif ( 'bootstrap4x' == $variant ) { ?>
            <div class="d-none d-xl-block">xl</div>
            <div class="d-none d-lg-block">lg</div>
            <div class="d-none d-md-block">md</div>
            <div class="d-none d-sm-block">sm</div>
            <div class="d-block">none</div>
          <?php } ?>
        </div>
        <div class="modernizr-btn" title="moderinzr features">modernizr v<?php echo $this->version ?></div>
        <div class="info-window" title="Window height & width">
          <div class="info2">H:<span class="fh-height"></span></div>
          <div class="info2">W:<span class="fh-width"></span></div>
        </div>
        <div class="fh-collapse"><span>&raquo;</span><span>&laquo;</span></div>
      </div>
    </div>
    <script>
      (function ($) {
        'use strict';

        $('.modernizr-btn').click(function (e) {
          e.preventDefault();
          let features = $('html').attr('class');
          $('.modernizr-features').text(features);
          $('.modernizr-features').toggleClass('hidden');
        });

        $('.fh-collapse').click(function () {
          $(this).toggleClass('fh-collapsed');
          if ($('.fh-collapsed').length > 0) {
            $('.frontend-helper').find('.modernizr-features, .bs-breakpoint, .modernizr-btn, .info-window').addClass('hidden');
          } else {
            $('.frontend-helper').find('.bs-breakpoint, .modernizr-btn, .info-window').removeClass('hidden');
          }
        });

        $('.fh-collapse').trigger('click');

        $(window).on('resize scroll', function () {
          $('.frontend-helper .info-window .fh-height').text($(window).height());
          $('.frontend-helper .info-window .fh-width').text($(window).width());
        });

        $(window).trigger('resize');
      })(jQuery);
    </script>

    <?php
  }

}
