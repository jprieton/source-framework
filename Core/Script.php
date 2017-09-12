<?php

namespace SourceFramework\Core;

/**
 * If this file is called directly, abort.
 */
if ( !defined( 'ABSPATH' ) ) {
  die( 'Direct access is forbidden.' );
}

use SourceFramework\Abstracts\Singleton;
use SourceFramework\Settings\SettingGroup;
use SourceFramework\Template\Tag;

/**
 * Script class
 *
 * @package        Core
 * @subpackage     Init
 * @since          1.0.0
 * @author         Javier Prieto <jprieton@gmail.com>
 */
class Script extends Singleton {

  /**
   * Static instance of this class
   *
   * @since         1.0.0
   * @var           SourceFrameworkPublic
   */
  protected static $instance;

  /**
   * Array of handlers of scritps to add <code>async</code> property;
   * @var array
   */
  private $scripts = [];

  /**
   * Array of handlers of scritps to add <code>integrity</code> property;
   * @var array
   */
  private $script_integrity_handles = [];

  /**
   * Array of handlers of scritps to add <code>async</code> property;
   * @var array
   */
  private $script_async_handles = [];

  /**
   * Array of handlers of scritps to add <code>defer</code> property;
   * @var array
   */
  private $script_defer_handles = [];

  /**
   * Declared as protected to prevent creating a new instance outside of the class via the new operator.
   *
   * @since         1.0.0
   */
  protected function __construct() {
    parent::__construct();

    /**
     * Register and enqueue scripts
     * @since   1.0.0
     */
    add_action( 'wp_enqueue_scripts', [ $this, 'enqueue_scripts' ] );
    add_action( 'admin_enqueue_scripts', [ $this, 'enqueue_scripts' ] );

    /**
     * Register and enqueue scripts
     * @since   1.0.0
     */
    add_action( 'wp_enqueue_scripts', [ $this, 'localize_scripts' ] );

    /**
     * Check handle names to add <code>integrity</code>, <code>async</code> and/or <code>defer</code> attributes;
     * @since   1.0.0
     */
    add_action( 'wp_print_scripts', [ $this, 'print_scripts' ], 1 );

    /**
     * Add <code>async</code> and/or <code>defer</code> attributes to tag if is enabled
     * @since   1.0.0
     */
    add_action( 'script_loader_tag', [ $this, 'script_loader_tag' ], 20, 2 );
  }

  /**
   * Register admin scripts
   *
   * @since 1.0.0
   */
  private function register_admin_scripts() {
    $scripts = [
        'source-framework-admin' => [
            'local'     => plugins_url( 'assets/js/admin.js', \SourceFramework\PLUGIN_FILE ),
            'deps'      => [ 'jquery' ],
            'ver'       => \SourceFramework\VERSION,
            'in_footer' => true,
            'autoload'  => true,
            'defer'     => true,
        ]
    ];

    return apply_filters( 'register_admin_scripts', $scripts );
  }

  /**
   * Register public scripts
   *
   * @since 1.0.0
   */
  private function register_scripts() {
    global $tools_setting_group, $api_setting_group;

    if ( empty( $tools_setting_group ) ) {
      $tools_setting_group = new SettingGroup( 'tools_settings' );
    }

    if ( empty( $api_setting_group ) ) {
      $api_setting_group = new SettingGroup( 'api_settings' );
    }

    $scripts = [
        'source-framework'             => [
            'local'     => plugins_url( 'assets/js/public.js', \SourceFramework\PLUGIN_FILE ),
            'deps'      => [ 'jquery', 'jquery-form' ],
            'ver'       => \SourceFramework\VERSION,
            'in_footer' => true,
            'autoload'  => !is_admin(),
            'defer'     => true,
        ],
        'modernizr'                    => [
            'remote'    => '//cdn.jsdelivr.net/modernizr/3.3.1/modernizr.min.js',
            'integrity' => 'sha256-65rhSmwPSQGe83K1p6cudTQxfiMNutuHCIB0n8CqvF4=',
            'ver'       => '3.3.1',
            'autoload'  => $tools_setting_group->get_bool_option( 'frontend-helper-enabled' ),
        ],
        'recaptcha'                    => [
            'remote'    => '//www.google.com/recaptcha/api.js',
            'in_footer' => true,
            'autoload'  => !empty( $api_setting_group->get_option( 'recaptcha-site-key' ) ),
            'async'     => true,
            'defer'     => true,
        ],
        'bootstrap3'                   => [
            'remote'    => '//maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js',
            'integrity' => 'sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa',
            'deps'      => [ 'jquery' ],
            'ver'       => '3.3.7',
        ],
        'popper'                       => [
            'remote'    => '//cdnjs.cloudflare.com/ajax/libs/popper.js/1.11.0/umd/popper.min.js',
            'integrity' => 'sha384-b/U6ypiBEHpOf/4+1nzFpr53nxSS+GLCkfwBdFNTxtclqqenISfwAzpKaMNFNmj4',
            'deps'      => [ 'jquery' ],
            'ver'       => '1.11.0',
        ],
        'bootstrap4'                   => [
            'remote'    => '//maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta/js/bootstrap.min.js',
            'integrity' => 'sha384-h0AbiXch4ZDo7tp9hKZ4TsHbi047NrKGLO3SEJAg45jXxnGIfYzk4Si90RDIqNm1',
            'deps'      => [ 'jquery', 'popper' ],
            'ver'       => '4.0.0-beta',
        ],
        'jquery-appear'                => [
            'remote'    => '//cdnjs.cloudflare.com/ajax/libs/jquery.appear/0.3.3/jquery.appear.min.js',
            'integrity' => 'sha256-VjbcbgNl0a7ldRQNPhmkEpW0GxCHnr52pGVkVjpnfSM=',
            'deps'      => [ 'jquery' ],
            'ver'       => '0.3.3',
            'in_footer' => true,
        ],
        'geodatasource-country-region' => [
            'remote'    => '//cdnjs.cloudflare.com/ajax/libs//1.1.1/geodatasource-cr.min.js',
            'integrity' => 'sha256-eGxmJXzH1UokaWuz4VhNlo4VeHPKf/XSJkagNdm4GFo=',
            'ver'       => '1.1.1',
            'in_footer' => true,
            'defer'     => true,
        ]
    ];

    return apply_filters( 'register_scripts', $scripts );
  }

  /**
   * Enqueue scripts
   *
   * @since 1.0.0
   */
  public function enqueue_scripts() {
    $defaults = [
        'local'       => '',
        'remote'      => '',
        'integrity'   => '',
        'crossorigin' => 'anonymous',
        'deps'        => [],
        'ver'         => null,
        'in_footer'   => false,
        'autoload'    => false,
        'async'       => false,
        'defer'       => false,
    ];

    global $advanced_setting_group;

    if ( empty( $advanced_setting_group ) ) {
      $advanced_setting_group = new SettingGroup( 'advanced_settings' );
    }

    $use_cdn = $advanced_setting_group->get_bool_option( 'cdn-enabled' );

    $this->scripts = is_admin() ? $this->register_admin_scripts() : $this->register_scripts();

    foreach ( $this->scripts as $handle => &$script ) {
      $script = wp_parse_args( $script, $defaults );

      if ( ($use_cdn && !empty( $script['remote'] )) || empty( $script['local'] ) ) {
        $src = $script['remote'];
      } elseif ( (!$use_cdn && !empty( $script['local'] )) || empty( $script['remote'] ) ) {
        $src = $script['local'];
      } else {
        continue;
      }

      if ( $script['async'] ) {
        $this->script_async_handles[] = $handle;
      }

      if ( $script['defer'] ) {
        $this->script_defer_handles[] = $handle;
      }

      if ( !empty( $script['integrity'] ) ) {
        $this->script_integrity_handles[] = $handle;
      }

      wp_register_script( $handle, $src, (array) $script['deps'], $script['ver'], (bool) $script['in_footer'] );

      if ( $script['autoload'] ) {
        wp_enqueue_script( $handle );
      }
    }
    unset( $script );
  }

  /**
   * Localize script
   *
   * @since 1.0.0
   */
  public function localize_scripts() {
    $data   = array(
        'ajaxUrl'  => admin_url( 'admin-ajax.php' ),
        'messages' => array(
            'success'   => __( 'Success!', \SourceFramework\TEXTDOMAIN ),
            'fail'      => __( 'Fail!', \SourceFramework\TEXTDOMAIN ),
            'error'     => __( 'Error!', \SourceFramework\TEXTDOMAIN ),
            'send'      => __( 'Send', \SourceFramework\TEXTDOMAIN ),
            'submit'    => __( 'Submit', \SourceFramework\TEXTDOMAIN ),
            'submiting' => __( 'Submiting...', \SourceFramework\TEXTDOMAIN ),
            'sending'   => __( 'Sending...', \SourceFramework\TEXTDOMAIN ),
            'sent'      => __( 'Sent!', \SourceFramework\TEXTDOMAIN ),
        )
    );
    $handle = is_admin() ? 'source-framework-admin' : 'source-framework';

    wp_localize_script( $handle, 'SourceFrameworkLocale', apply_filters( 'source_framework_localize_scripts', $data ) );
  }

  /**
   * Filter handle names to add <code>integrity</code>, <code>async</code> and/or <code>defer</code> attributes
   *
   * @since   1.0.0
   */
  public function print_scripts() {
    /**
     * Filter handle names of scripts to add <code>integrity</code> attribute;
     * @since   1.0.0
     */
    $script_integrity_handles       = (array) apply_filters( 'filter_integrity_scripts', $this->script_integrity_handles );
    $this->script_integrity_handles = array_unique( $script_integrity_handles );

    /**
     * Filter handle names of scripts to add <code>async</code> attribute;
     * @since   1.0.0
     */
    $script_async_handles       = (array) apply_filters( 'filter_async_scripts', $this->script_async_handles );
    $this->script_async_handles = array_unique( $script_async_handles );

    /**
     * Filter handle names of scripts to add <code>defer</code> attribute;
     * @since   1.0.0
     */
    $script_defer_handles       = (array) apply_filters( 'filter_defer_scripts', $this->script_defer_handles );
    $this->script_defer_handles = array_unique( $script_defer_handles );
  }

  /**
   * Adds <code>async</code> and/or <code>defer</code> attributes to tag if is enabled
   *
   * @since   1.0.0
   *
   * @param   string    $tag
   * @param   string    $handle
   * @return  string
   */
  public function script_loader_tag( $tag, $handle ) {
    if ( in_array( $handle, $this->script_integrity_handles ) ) {
      $attr = [
          'integrity'   => $this->scripts[$handle]['integrity'],
          'crossorigin' => $this->scripts[$handle]['crossorigin'],
      ];
      $tag  = str_replace( '></script>', ' ' . Tag::parse_attributes( $attr ) . '></script>', $tag );
    }

    if ( in_array( $handle, $this->script_async_handles ) ) {
      $tag = str_replace( '></script>', ' async></script>', $tag );
    }

    if ( in_array( $handle, $this->script_defer_handles ) ) {
      $tag = str_replace( '></script>', ' defer></script>', $tag );
    }
    return $tag;
  }

}
