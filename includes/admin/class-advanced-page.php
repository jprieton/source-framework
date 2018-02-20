<?php

namespace SourceFramework\Admin;

// If this file is called directly, abort.
if ( !defined( 'ABSPATH' ) ) {
  die( 'Direct access is forbidden.' );
}

use SourceFramework\Abstracts\Settings_Page;
use SourceFramework\Settings\Settings_Group_Field;

/**
 * Advanced_Page class
 *
 * @package        SourceFramework
 * @subpackage     Admin
 * @since          2.0.0
 * @author         Javier Prieto
 */
final class Advanced_Page extends Settings_Page {

  /**
   * Option group
   * @since   1.0.0
   * @var     string
   */
  protected $option_group = '';

  /**
   * Option group
   * @since   1.0.0
   * @var     string
   */
  protected $option_page = '';

  /**
   *
   * @var Settings_Group_Field
   */
  private $settings_group_field;

  /**
   * Constructor
   *
   * @since 2.0.0
   */
  public function __construct() {
    $this->option_page          = 'advanced-options';
    $this->option_group         = 'advanced-options';
    $this->option_name          = 'advanced_options';
    $this->settings_group_field = new Settings_Group_Field( $this->option_name );

    parent::__construct( 'options-general.php', $this->option_page );

    add_action( 'admin_menu', [ $this, 'add_advanced_page' ] );
    add_action( 'admin_init', [ $this, 'add_cdn_settings_section' ] );
  }

  /**
   * Add Advanced page to Settings menu
   *
   * @since 2.0.0
   */
  public function add_advanced_page() {
    parent::add_submenu_page( __( 'Advanced', SF_TEXTDOMAIN ), __( 'Advanced', SF_TEXTDOMAIN ), 'activate_plugins' );
  }

  /**
   *
   * @since 2.0.0
   */
  public function add_cdn_settings_section() {
    $this->add_settings_section( 'section-advanced-cdn' );

    $fields = [
        'title'   => __( 'CDN', SF_TEXTDOMAIN ),
        'type'    => 'checkbox',
        'options' => [
            [
                'id'    => 'cdn-enabled',
                'desc'  => __( 'Enables the <strong>Content Distribution Network (CDN)</strong> for scripts/styles registered with <code>remote</code> attribute defined.', SF_TEXTDOMAIN ),
                'label' => __( 'Enable CDN', SF_TEXTDOMAIN ),
            ],
            [
                'id'    => 'sri-enabled',
                'desc'  => __( 'Enables the <strong>Subresource Integrity (SRI)</strong> for scripts/styles registered with <code>integrity</code> attribute defined.', SF_TEXTDOMAIN ),
                'label' => __( 'Enable SRI', SF_TEXTDOMAIN ),
            ],
        ],
    ];

    $this->settings_group_field->add_settings_field( $this->submenu_slug, 'section-advanced-cdn', $fields );
  }

}
