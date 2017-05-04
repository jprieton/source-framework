<?php

/**
 * If this file is called directly, abort.
 */
if ( !defined( 'ABSPATH' ) ) {
  die( 'Direct access is forbidden.' );
}


/**
 * Register and optionally enqueue scripts
 * @since   1.0.0
 */
add_action( 'source_framework_register_scripts', function( $scripts ) {
  $defaults = [
      'local'     => '',
      'remote'    => '',
      'deps'      => [],
      'ver'       => null,
      'in_footer' => false,
      'autoload'  => false
  ];

  $use_cdn = get_bool_option( 'use_cdn' );

  foreach ( $scripts as $handle => $script ) {
    $script = wp_parse_args( $script, $defaults );

    if ( ($use_cdn && !empty( $script['remote'] )) || empty( $script['local'] ) ) {
      $src = $script['remote'];
    } elseif ( (!$use_cdn && !empty( $script['local'] )) || empty( $script['remote'] ) ) {
      $src = $script['local'];
    } else {
      continue;
    }

    $deps      = $script['deps'];
    $ver       = $script['ver'];
    $in_footer = $script['in_footer'];

    /* Register admin scripts */
    wp_register_script( $handle, $src, (array) $deps, $ver, (bool) $in_footer );

    if ( $script['autoload'] ) {
      /* Enqueue scripts if autolad in enabled */
      wp_enqueue_script( $handle );
    }
  }

  /**
   * Filter localize scripts
   *
   * @since   1.0.0
   * @param   array   $localize_script
   */
  $localize_script = apply_filters( 'source_framework_localize_scripts', [] );

  wp_localize_script( 'source-framework-admin', 'SourceFrameworkLocale', $localize_script );
} );


/**
 * Register and optionally enqueue styles
 * @since   1.0.0
 */
add_action( 'source_framework_register_styles', function( $styles ) {

  $defaults = [
      'local'    => '',
      'remote'   => '',
      'deps'     => [],
      'ver'      => null,
      'media'    => 'all',
      'autoload' => false
  ];

  $use_cdn = get_bool_option( 'use_cdn' );

  foreach ( $styles as $handle => $style ) {
    $style = wp_parse_args( $style, $defaults );

    if ( ($use_cdn && !empty( $style['remote'] )) || empty( $style['local'] ) ) {
      $src = $style['remote'];
    } elseif ( (!$use_cdn && !empty( $style['local'] )) || empty( $style['remote'] ) ) {
      $src = $style['local'];
    } else {
      continue;
    }

    $deps  = $style['deps'];
    $ver   = $style['ver'];
    $media = $style['media'];

    // Register styles
    wp_register_style( $handle, $src, (array) $deps, $ver, $media );

    if ( $style['autoload'] ) {
      // Enqueue styles if autolad in enabled
      wp_enqueue_style( $handle );
    }
  }
} );


/**
 * Localize script
 * @since 1.0.0
 */
add_filter( 'source_framework_localize_scripts', function() {
  $localize_script = array(
      'ajaxUrl'  => admin_url( 'admin-ajax.php' ),
      'messages' => array(
          'success'   => __( 'Success!', \SourceFramework\TEXDOMAIN ),
          'fail'      => __( 'Fail!', \SourceFramework\TEXDOMAIN ),
          'error'     => __( 'Error!', \SourceFramework\TEXDOMAIN ),
          'send'      => __( 'Send', \SourceFramework\TEXDOMAIN ),
          'submit'    => __( 'Submit', \SourceFramework\TEXDOMAIN ),
          'submiting' => __( 'Submiting...', \SourceFramework\TEXDOMAIN ),
          'sending'   => __( 'Sending...', \SourceFramework\TEXDOMAIN ),
          'sent'      => __( 'Sent!', \SourceFramework\TEXDOMAIN ),
      )
  );
  return $localize_script;
}, 0 );
