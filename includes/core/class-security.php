<?php

namespace SourceFramework\Core;

defined( 'ABSPATH' ) || exit;

use SourceFramework\Settings\Settings_Group;

/**
 * Security class
 *
 * @package        Core
 * @subpackage     Security
 * @since          2.0.0
 * @author         Javier Prieto
 */
class Security {

  /**
   * Adds Singleton methods and properties
   * 
   * @since     2.0.0
   */
  use Traits\Singleton;

  /**
   * Declared as protected to prevent creating a new instance outside of the class via the new operator.
   *
   * @since     2.0.0
   *
   * @global    Settings_Group     $security_options
   */
  protected function __construct() {
    global $security_options;

    if ( empty( $security_options ) ) {
      $security_options = new Settings_Group( 'security_options' );
    }

    if ( $security_options->get_bool_option( 'remove-wordpress-version' ) ) {
      add_action( 'wp_head', [ $this, 'remove_wordpress_version' ], -1 );
    }

    if ( $security_options->get_bool_option( 'disallow-file-edit' ) && !defined( 'DISALLOW_FILE_EDIT' ) ) {
      define( 'DISALLOW_FILE_EDIT', true );
    }

    if ( $security_options->get_bool_option( 'remove_rsd_link' ) ) {
      add_action( 'wp_head', [ $this, 'remove_rsd_link' ] );
    }

    if ( $security_options->get_bool_option( 'disable_xmlrpc_pingback' ) ) {
      $this->disable_xmlrpc_pingback();
    }

    if ( $security_options->get_bool_option( 'disable_all_xmlrpc' ) ) {
      $this->disable_all_xmlrpc();
    }

    if ( $security_options->get_bool_option( 'htaccess-block-user-enumeration' ) ) {
      $this->block_user_enumeration();
    }

    add_action( 'wp_loaded', [ $this, 'disable_admin_bar' ] );
    add_action( 'wp_loaded', [ $this, 'disable_dashboard' ] );
    add_filter( 'security_mod_rewrite_rules', [ $this, 'mod_rewrite_rules' ] );
  }

  /**
   * Completely remove your WordPress version number from both your head file and RSS feeds.
   *
   * @since     2.0.0
   */
  public function remove_wordpress_version() {
    remove_action( 'wp_head', 'wp_generator' );
    add_filter( 'the_generator', '__return_empty_string' );

    $remove_version = function ( $src ) {
      $src = remove_query_arg( 'ver', $src );
      return $src;
    };

    add_filter( 'style_loader_src', $remove_version, 10, 2 );
    add_filter( 'script_loader_src', $remove_version, 10, 2 );
  }

  /**
   * @since     2.0.0
   */
  public function remove_rsd_link() {
    // Remove the EditURI/RSD link from head
    remove_action( 'wp_head', 'rsd_link' );

    // Remove the Windows Live Writer manifest link from head
    remove_action( 'wp_head', 'wlwmanifest_link' );
  }

  /**
   * @since     2.0.0
   */
  public function disable_all_xmlrpc() {
    // Disable XML-RCP
    add_filter( 'xmlrpc_enabled', '__return_false' );

    // Disable all XML-RCP methods
    add_filter( 'xmlrpc_methods', '__return_empty_array' );

    // Add xmlrpc.php to list to blocked files
    add_filter( 'htaccess_blocked_filenames', function($files) {
      $files[] = 'xmlrpc.php';
      return $files;
    } );
  }

  /**
   * @since     2.0.0
   */
  public function disable_xmlrpc_pingback() {
    // Remove Pingback methods
    add_filter( 'xmlrpc_methods', function ( $methods ) {
      unset( $methods['pingback.ping'] );
      unset( $methods['pingback.extensions.getPingbacks'] );
      return $methods;
    } );

    // Remove Pingback header
    add_filter( 'wp_headers', function ( $headers ) {
      unset( $headers['X-Pingback'] );
      return $headers;
    } );
  }

  /**
   * Disable WordPress Admin Bar in frontend for specific roles.
   *
   * @since     2.0.0
   *
   * @global    Settings_Group     $security_options
   */
  public function disable_admin_bar() {
    global $security_options;

    if ( empty( $security_options ) ) {
      $security_options = new Settings_Group( 'security_options' );
    }

    $disabled_roles = (array) $security_options->get_option( 'admin-bar-disabled', [] );
    $user           = wp_get_current_user();

    // By default is enabled in all roles.
    if ( empty( $disabled_roles ) || !$user ) {
      return;
    }

    foreach ( $user->roles as $user_rol ) {
      if ( in_array( $user_rol, $disabled_roles ) ) {
        add_filter( 'show_admin_bar', '__return_false' );
        break;
      }
    }
  }

  /**
   * Disable access to admin side of WordPress
   *
   * @since 1.0.0
   *
   * @global Settings_Group $advanced_setting_group
   */
  public function disable_dashboard() {
    global $security_options;

    if ( empty( $security_options ) ) {
      $security_options = new Settings_Group( 'security_options' );
    }

    $disabled_roles = (array) $security_options->get_option( 'dashboard-disabled', array() );

    // By default is enabled in all roles.
    if ( empty( $disabled_roles ) || !is_user_logged_in() ) {
      return;
    }

    $user = wp_get_current_user();

    foreach ( $user->roles as $user_rol ) {
      if ( in_array( $user_rol, $disabled_roles ) ) {
        exit( wp_redirect( home_url( '/' ) ) );
        break;
      }
    }
  }

  /**
   * Block user enumeration when htaccess is disabled
   *
   * @since 2.0.0
   */
  public function block_user_enumeration() {
    if ( !is_admin() && isset( $_REQUEST['author'] ) && is_numeric( $_REQUEST['author'] ) ) {
      wp_die( Error_Message::user_not_authorized() );
    }
  }

  /**
   * Add custom rules to .htaccess
   *
   * @since 2.0.0
   *
   * @global    Settings_Group    $security_options
   * @param     string            $rules
   * @return    string
   * @link      https://perishablepress.com/6g/     Source of most of the rules applied here
   */
  public function mod_rewrite_rules( $rules ) {
    global $security_options;

    if ( empty( $security_options ) ) {
      $security_options = new Settings_Group( 'security_options' );
    }

    $new_rules = '';

    if ( $security_options->get_bool_option( 'htaccess-disable-indexes' ) ) {
      $new_rules .= '# [DISABLE INDEXES]
Options All -Indexes

';
    }

    if ( $security_options->get_bool_option( 'htaccess-block-request-methods' ) ) {
      $new_rules .= '# [BLOCK REQUEST METHODS]
<IfModule mod_rewrite.c>
RewriteCond %{REQUEST_METHOD} ^(connect|debug|move|put|trace|track) [NC]
RewriteRule .* - [F]
</IfModule>

';
    }

    if ( $security_options->get_bool_option( 'htaccess-block-query-strings' ) ) {
      $new_rules .= '# [BLOCK QUERY STRINGS]
<IfModule mod_rewrite.c>
RewriteEngine On
RewriteCond %{QUERY_STRING} (eval\() [NC,OR]
RewriteCond %{QUERY_STRING} (127\.0\.0\.1) [NC,OR]
RewriteCond %{QUERY_STRING} ([a-z0-9]{2000,}) [NC,OR]
RewriteCond %{QUERY_STRING} (javascript:)(.*)(;) [NC,OR]
RewriteCond %{QUERY_STRING} (base64_encode)(.*)(\() [NC,OR]
RewriteCond %{QUERY_STRING} (GLOBALS|REQUEST)(=|\[|%) [NC,OR]
RewriteCond %{QUERY_STRING} (<|%3C)(.*)script(.*)(>|%3) [NC,OR]
RewriteCond %{QUERY_STRING} (\\|\.\.\.|\.\./|~|`|<|>|\|) [NC,OR]
RewriteCond %{QUERY_STRING} (boot\.ini|etc/passwd|self/environ) [NC,OR]
RewriteCond %{QUERY_STRING} (thumbs?(_editor|open)?|tim(thumb)?)\.php [NC,OR]
RewriteCond %{QUERY_STRING} (\'|\")(.*)(drop|insert|md5|select|union) [NC]
RewriteRule .* - [F]
</IfModule>

';
    }

    if ( $security_options->get_bool_option( 'htaccess-block-request-strings' ) ) {
      $new_rules .= '# [BLOCK REQUEST STRINGS]
<IfModule mod_alias.c>
RedirectMatch 403 (?i)([a-z0-9]{2000,})
RedirectMatch 403 (?i)(https?|ftp|php):/
RedirectMatch 403 (?i)(base64_encode)(.*)(\()
RedirectMatch 403 (?i)(=\\\'|=\\%27|/\\\'/?)\.
RedirectMatch 403 (?i)/(\$(\&)?|\*|\"|\.|,|&|&amp;?)/?$
RedirectMatch 403 (?i)(\{0\}|\(/\(|\.\.\.|\+\+\+|\\\"\\\")
RedirectMatch 403 (?i)(~|`|<|>|:|;|,|%|\\|\s|\{|\}|\[|\]|\|)
RedirectMatch 403 (?i)/(=|\$&|_mm|cgi-|etc/passwd|muieblack)
RedirectMatch 403 (?i)(&pws=0|_vti_|\(null\)|\{\$itemURL\}|echo(.*)kae|etc/passwd|eval\(|self/environ)
RedirectMatch 403 (?i)\.(aspx?|bash|bak?|cfg|cgi|dll|exe|git|hg|ini|jsp|log|mdb|out|sql|svn|swp|tar|rar|rdf)$
RedirectMatch 403 (?i)/(^$|(wp-)?config|mobiquo|phpinfo|shell|sqlpatch|thumb|thumb_editor|thumbopen|timthumb|webshell)\.php
</IfModule>

';
    }

    if ( $security_options->get_bool_option( 'htaccess-block-user-enumeration' ) ) {
      $new_rules .= '# [BLOCK USER ENUMERATION]
<IfModule mod_rewrite.c>
RewriteEngine On
RewriteRule ^([_0-9a-zA-Z-]+/)?(wp-admin.*) $2 [L]
RewriteCond %{QUERY_STRING} author=\d
RewriteRule .* - [F]
</IfModule>

';
    }

    $files = apply_filters( 'htaccess_blocked_filenames', [ 'license.txt', '.htaccess', 'wp-config.php', 'wp-config-sample.php', 'readme.html' ] );

    if ( !empty( $files ) && $security_options->get_bool_option( 'htaccess-block-direct-access' ) ) {
      $new_rules .= sprintf( '# [BLOCK DIRECT ACCESS]
<FilesMatch %s>
Order Deny,Allow
Deny from all
</FilesMatch>

', implode( '|', $files ) );
    }

    return $new_rules . $rules;
  }

}
