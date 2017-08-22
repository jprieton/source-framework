<?php

namespace SourceFramework\Admin;

/**
 * If this file is called directly, abort.
 */
if ( !defined( 'ABSPATH' ) ) {
  die( 'Direct access is forbidden.' );
}

use SourceFramework\Abstracts\SettingGroupPage;
use SourceFramework\Settings\SettingField;

/**
 * SocialPage class
 *
 * @package        Admin
 * @subpackage     SettingPages
 * @since          1.0.0
 * @author         Javier Prieto <jprieton@gmail.com>
 */
final class SocialPage extends SettingGroupPage {

  /**
   * Default social networks
   * @var type
   */
  private $social_networks = [
      'social-email'       => 'Email',
      'social-facebook'    => 'Facebook',
      'social-dribbble'    => 'Dribble',
      'social-google-plus' => 'Google+',
      'social-instagram'   => 'Instagram',
      'social-linkedin'    => 'LinkedIn',
      'social-pinterest'   => 'Pinterest',
      'social-rss'         => 'RSS',
      'social-twitter'     => 'Twitter',
      'social-yelp'        => 'Yelp',
      'social-youtube'     => 'YouTube',
  ];

  /**
   * Constructor
   *
   * @since 1.0.0
   */
  public function __construct() {
    $this->title = __( 'Social Settings', \SourceFramework\TEXTDOMAIN );

    /**
     * Allow override menu slug
     * @since 1.0.0
     */
    $menu_slug = apply_filters( 'source_framework_social_menu_slug', 'source-framework' );

    parent::__construct( $menu_slug, 'source-framework-social' );
    $this->add_submenu_page( __( 'Social', \SourceFramework\TEXTDOMAIN ), __( 'Social', \SourceFramework\TEXTDOMAIN ), 'activate_plugins' );

    $this->fields = new SettingField( 'social_links', 'social_links' );
    $this->add_social_links_section();
  }

  /**
   * Add social networks links tab
   *
   * @since 1.0.0
   */
  public function add_social_links_section() {
    $this->add_setting_section( 'social_settings_section_links', __( 'Links', \SourceFramework\TEXTDOMAIN ) );

    // Filter to allow to plugins/themes add more social networks
    $social_links = apply_filters( 'social_networks', $this->social_networks );

    foreach ( $social_links as $key => $label ) {
      $this->fields->add_field( array(
          'name'        => $label,
          'id'          => $key,
          'type'        => 'text',
          'input_class' => 'regular-text code',
      ) );
    }

    do_action( 'add_social_links_section', $this );
  }

}
