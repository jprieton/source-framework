<?php

namespace SourceFramework\Admin;

/**
 * If this file is called directly, abort.
 */
if ( !defined( 'ABSPATH' ) ) {
  die( 'Direct access is forbidden.' );
}

use SourceFramework\Abstracts\SettingGroupPage;

/**
 * SocialPage class
 *
 * @package        Admin
 * @subpackage     SettingPages
 * @since          1.0.0
 * @author         Javier Prieto <jprieton@gmail.com>
 */
final class SocialPage extends SettingGroupPage {

  /** Default networks */
  private $social_links = [
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
    parent::__construct( 'source-framework', 'source-framework-social' );
    $this->add_submenu_page( __( 'Social', \SourceFramework\TEXTDOMAIN ), __( 'Social', \SourceFramework\TEXTDOMAIN ), 'activate_plugins' );
  }

  public function add_social_links_section() {
    /** Filter to add more networks */
    $social_links = apply_filters( 'social_links', $this->social_links );
  }

  public function render_setting_page() {
    include_once \SourceFramework\ABSPATH . '/Admin/Templates/SocialNetworks.php';
  }

  /**
   * social_network_links
   */
}
