<?php

namespace SourceFramework\Admin;

/**
 * If this file is called directly, abort.
 */
if ( !defined( 'ABSPATH' ) ) {
  die( 'Direct access is forbidden.' );
}

use SourceFramework\Abstracts\Settings_Page;
use SourceFramework\Settings\Settings_Group_Field;

/**
 * Social_Page class
 *
 * @package        SourceFramework
 * @subpackage     Admin
 * @since          2.0.0
 * @author         Javier Prieto
 */
final class Social_Page extends Settings_Page {

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
   * @since 1.0.0
   */
  public function __construct() {
    $this->option_page          = 'social-links';
    $this->option_group         = 'social-links';
    $this->option_name          = 'social_links';
    $this->settings_group_field = new Settings_Group_Field( $this->option_name );

    parent::__construct( 'options-general.php', $this->option_page );

    add_action( 'admin_menu', [ $this, 'add_social_page' ] );
    add_action( 'admin_init', [ $this, 'add_social_links_section' ] );
  }

  /**
   * Add Security page to Settings menu
   *
   * @since 2.0.0
   */
  public function add_social_page() {
    parent::add_submenu_page( __( 'Social Networks Links', SF_TEXTDOMAIN ), __( 'Social', SF_TEXTDOMAIN ), 'activate_plugins' );
  }

  /**
   * Add social networks links tab
   *
   * @since 1.0.0
   */
  public function add_social_links_section() {
    $this->add_settings_section( 'social_settings_section_links' );

    // Filter to allow to plugins/themes add more social networks
    $social_links = apply_filters( 'social_networks', [] );

    foreach ( $social_links as $key => $label ) {
      $this->settings_group_field->add_settings_field( $this->submenu_slug, 'social_settings_section_links', [
          'title'       => $label,
          'id'          => $key,
          'type'        => 'text',
          'input_class' => 'regular-text code',
      ] );
    }
  }

}
