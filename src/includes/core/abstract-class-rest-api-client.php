<?php

namespace SourceFramework\Abstracts;

// If this file is called directly, abort.
if ( !defined( 'ABSPATH' ) ) {
  die( 'Direct access is forbidden.' );
}

/**
 * Class to extend to consume remote REST
 *
 * @package        SourceFramework
 * @subpackage     Abstracts
 * @since          2.0.0
 * @author         Javier Prieto
 */
class Rest_Api_Client {

  /**
   * Base URL of API
   *
   * @since   2.0.0
   * @var     string
   */
  public $api_base_url = '';

  /**
   * Default args used in <code>wp_remote_get</code> or <code>wp_remote_post</code>.
   *
   * @see    https://codex.wordpress.org/Function_Reference/wp_remote_get
   * @see    https://codex.wordpress.org/Function_Reference/wp_remote_post
   * @since   2.0.0
   * @var     array
   */
  public $default_args = [
      'method' => 'GET',
  ];

  /**
   * Default params used in <code>wp_remote_get</code> or <code>wp_remote_post</code>.
   *
   * @see    https://codex.wordpress.org/Function_Reference/wp_remote_get
   * @see    https://codex.wordpress.org/Function_Reference/wp_remote_post
   * @since   2.0.0
   * @var     array
   */
  public $default_params = [];

  /**
   * Name of transient to save the last response of API when <code>$transient_cache</code> is set.
   *
   * @since   2.0.0
   * @var     string
   */
  public $transient_name = '';

  /**
   * Use WordPress Transients API to cache, <code>$debug_filepath</code> must be defined to use.
   *
   * @since   2.0.0
   * @var     boolean|integer
   */
  public $transient_cache = false;

  /**
   * Path to save API response when <code>WP_DEBUG</code> is enabled.
   * <code>$transient_name</code> must be defined.
   *
   * @since   2.0.0
   * @var     string
   */
  private $debug_filepath = '';

  /**
   * Class constructor
   *
   * @since   2.0.0
   */
  public function __construct() {
    if ( !empty( $this->transient_name ) ) {
      $upload_dir           = wp_get_upload_dir();
      $this->debug_filepath = $upload_dir['basedir'] . DIRECTORY_SEPARATOR . $this->transient_name . '.json';
    } else {
      $this->transient_name = '';
    }

    if ( $this->transient_cache === true ) {
      $this->transient_cache = 6 * HOUR_IN_SECONDS; // Default cache time
    }
  }

  /**
   * Retrieve the API response
   *
   * @since   2.0.0
   * @param   string    $endpoint
   * @param   array     $params
   * @return  mixed
   */
  public function get_endpoint( $endpoint, $params = [], $args = [], $transient_name = '' ) {
    $args   = wp_parse_args( $args, $this->default_args );
    $params = wp_parse_args( $args, $this->default_params );

    $response = get_transient( $transient_name ?: "{$this->transient_name}_{$endpoint}" );

    // If empty the transient cache make a new request to remote API
    if ( empty( $response ) && !empty( $this->api_base_url ) ) {
      $args['body'] = http_build_query( $params );

      switch ( $args['method'] ) {
        case 'GET':
          $api_response = wp_remote_get( $endpoint, $args );
          break;
        case 'POST':
        default:
          $api_response = wp_remote_post( $endpoint, $args );
          break;
      }

      $response = wp_remote_retrieve_body( $api_response );

      if ( is_wp_error( $response ) ) {
        return $response;
      }

      // Save the last API response to cache if is enabled
      if ( $this->transient_cache && $this->transient_cache > 0 ) {
        set_transient( $transient_name, $response, (int) $this->transient_cache );
      }

      // Save the last API response to file if is enabled
      if ( defined( 'WP_DEBUG' ) && WP_DEBUG && !empty( $this->debug_filepath ) ) {
        file_put_contents( $this->debug_filepath, wp_remote_retrieve_body( $response ) );
      }
    }

    return $response;
  }

}
