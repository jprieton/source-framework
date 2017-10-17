<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace SourceFramework\Tools;

use SourceFramework\Template\Tag;
use SourceFramework\Settings\SettingGroup;
use PHPMailer;

if ( !class_exists( 'PHPMailer' ) ) {
  require_once ABSPATH . WPINC . '/class-phpmailer.php';
}

/**
 * Description of Mail
 *
 * @author perseo
 */
class Mail extends PHPMailer {

  private $mail_logo    = false;
  private $mail_header  = false;
  private $mail_content = false;
  private $mail_social  = false;
  private $mail_powered = false;
  private $mail_subject = false;

  /**
   * @since 1.0.0
   *
   * @param bool $disabled
   */
  public function setContentLogo( $disabled = false ) {
    if ( $disabled ) {
      $this->mail_logo = '';
      return;
    }

    $logo_url = apply_filters( 'mail_custom_logo', '' );

    if ( empty( $logo_url ) && has_custom_logo() ) {
      $logo     = wp_get_attachment_image_src( get_theme_mod( 'custom_logo' ), 'full' );
      $logo_url = $logo[0];
    }

    if ( empty( $logo_url ) ) {
      $this->mail_logo = '';
      return;
    }

    $image           = Tag::img( $logo_url, [ 'style' => 'max-width: 600px; max-height: 75px; width:auto; height:auto', 'alt' => 'Logo' ] );
    $link            = Tag::a( get_home_url(), $image );
    $this->mail_logo = Tag::html( 'div', $link, [ 'style' => 'max-width: 600px; margin: auto; text-align: center; padding-top: 30px;' ] );
  }

  /**
   * @since 1.0.0
   *
   * @param string $text
   * @param string $background_color
   * @param string $font_color
   */
  public function setContentHeader( $text = '', $background_color = 'default', $font_color = 'white' ) {
    $background_colors = [
        'primary' => '#337ab7',
        'success' => '#5cb85c',
        'info'    => '#5bc0de',
        'warning' => '#f0ad4e',
        'danger'  => '#d9534f',
        'default' => '#999999'
    ];

    if ( array_key_exists( $background_color, $background_colors ) ) {
      $background_color = $background_colors[$background_color];
    }

    $attr = [
        'style' => "background-color: {$background_color}; color:{$font_color};  padding: 15px; border-radius: 5px 5px 0px 0px; text-align: center"
    ];

    $this->mail_header = Tag::html( 'div', $text, $attr );
  }

  /**
   * @since 1.0.0
   *
   * @param bool $disabled
   */
  public function setContentSocial( $disabled = false ) {
    if ( $disabled ) {
      $this->mail_social = '';
      return;
    }

    global $social_links_group;

    if ( empty( $social_links_group ) ) {

      $social_links_group = new SettingGroup( 'social_links' );
    }

    $social_networks = (array) apply_filters( 'social_networks', [] );
    $icon_path       = plugins_url( 'assets/images/social/', \SourceFramework\PLUGIN_FILE );

    $social_links = '';
    foreach ( $social_networks as $key => $label ) {
      $link = $social_links_group->get_option( $key );
      if ( empty( $link ) ) {
        continue;
      }

      $icon  = apply_filters( "{$key}-icon-path", $icon_path . str_replace( 'social-', '', $key ) . '.svg' );
      $image = Tag::img( $icon, [ 'height' => '25', 'width' => '25', 'style' => 'margin: 0px 4px;', 'alt' => $label ] );

      $social_links .= Tag::a( $link, $image, [ 'title' => $label ] );
    }

    if ( !empty( $social_links ) ) {
      $this->mail_social = Tag::html( 'div', $social_links, [ 'style' => 'padding: 30px 15px; text-align: center' ] );
    } else {
      $this->mail_social = '';
    }
  }

  /**
   * @since 1.0.0
   *
   * @param string $text
   */
  public function setContentPowered( $text = '' ) {
    if ( !empty( $text ) ) {
      $this->mail_powered = Tag::html( 'div', $text, [ 'style' => 'text-align: center; padding: 0 0 5px 0; font-weight: bold; font-size: 0.6em; color: #888888;' ] );
    }
  }

  /**
   * @since 1.0.0
   *
   * @param string $content
   */
  public function setContentBody( $content = '' ) {
    $content            = apply_filters( 'the_content', $content );
    $this->mail_content = Tag::html( 'div', $content, [ 'style' => 'background-color: white; padding: 15px 15px 30px 15px; border-radius: 0px 0px 5px 5px; color: #666666' ] );
  }

  public function renderBody( $template_name = 'default' ) {
    $path     = apply_filters( "mail_{$template_name}_template", plugin_dir_path( \SourceFramework\PLUGIN_FILE ) . "partials/mail-{$template_name}.php" );
    $template = file_get_contents( $path );

    if ( $this->mail_social === false ) {
      $this->setContentSocial();
    }

    if ( $this->mail_logo === false ) {
      $this->setContentLogo();
    }

    if ( $this->mail_powered === false ) {
      $this->setContentPowered();
    }

    $mail_data = [
        '{subject}' => $this->Subject,
        '{logo}'    => $this->mail_logo,
        '{header}'  => $this->mail_header,
        '{content}' => $this->mail_content,
        '{social}'  => $this->mail_social,
        '{powered}' => $this->mail_powered,
    ];

    $this->Body = str_replace( array_keys( $mail_data ), array_values( $mail_data ), $template );
  }

  /**
   * @since 1.0.0
   *
   * @return bool
   */
  public function send() {
    if ( empty( $this->Body ) ) {
      $this->renderBody();
    }

    $this->isHTML();
    $this->Subject = $this->mail_subject;
    $this->CharSet = 'utf-8';

    if ( empty( $this->From ) ) {
      $this->From = 'noreply@' . $this->Host;
    }

    return parent::send();
  }

}
