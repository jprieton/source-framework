<?php

namespace SourceFramework\Core\Traits;

defined( 'ABSPATH' ) || exit;

/**
 * Traits to extend to consume remote REST
 *
 * @package        SourceFramework
 * @subpackage     Api\Traits
 * @since          2.0.0
 * @author         Javier Prieto
 */
trait Rest_Client {

  /**
   * Base URL of API
   *
   * @since   1.0.0
   * @var     string
   */
  public $api_base_url = '';

  /**
   * Use WordPress Transients API to cache.
   *
   * @since   1.0.0
   * @var     boolean|integer
   */
  public $transient_cache = false;

  /**
   * Path to save API response when <code>WP_DEBUG</code> is enabled.
   * <code>$transient_cache</code> must be defined.
   *
   * @since   1.0.0
   * @var     boolean|string
   */
  public $debug_filepath = false;

  /**
   * Default args used in <code>wp_remote_get</code> or <code>wp_remote_post</code>.
   *
   * @see     https://codex.wordpress.org/Function_Reference/wp_remote_get
   * @see     https://codex.wordpress.org/Function_Reference/wp_remote_post
   * @since   1.0.0
   * @var     array
   */
  public $default_args = [];

  /**
   * Default params used in <code>wp_remote_get</code> or <code>wp_remote_post</code>.
   *
   * @see     https://codex.wordpress.org/Function_Reference/wp_remote_get
   * @see     https://codex.wordpress.org/Function_Reference/wp_remote_post
   * @since   1.0.0
   * @var     array
   */
  public $default_params = [];

  /**
   * Stores the last request for debug purposes.
   *
   * @since   1.0.0
   * @var     array
   */
  public $last_request = [
      'endpoint' => '',
      'args'     => '',
  ];

}
