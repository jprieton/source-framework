<?php

namespace SourceFramework\Api;

/**
 * If this file is called directly, abort.
 */
if ( !defined( 'ABSPATH' ) ) {
  die( 'Direct access is forbidden.' );
}

use SourceFramework\Settings\SettingGroup;

/**
 * Wrapper for Instagram API
 * @since 1.0.0
 *
 */
class Instagram {

  private $client_id;
  private $access_token;
  private $api_url = 'https://api.instagram.com/v1';

  /**
   * @since         1.0.0
   * @var           SettingGroup
   */
  private $setting_group;

  /**
   * Class constructor
   *
   * @since 1.0.0
   *
   * @param array $args
   */
  public function __construct( $args = array() ) {
    $this->setting_group = new SettingGroup( 'api' );

    $defaults = [
        'client_id'    => $this->setting_group->get_option( 'instagram-client-id' ),
        'access_token' => $this->setting_group->get_option( 'instagram-token' ),
        'cache'        => $this->setting_group->get_int_option( 'instagram-timeout-cache', 3600 ),
    ];
    $args     = wp_parse_args( $args, $defaults );

    $this->set_client_id( $args['client_id'] );
    $this->set_access_token( $args['access_token'] );
    $this->set_cache( $args['cache'] );
  }

  /**
   * Sets the Client ID
   *
   * @since 1.0.0
   *
   * @param string $client_id
   */
  public function set_client_id( $client_id ) {
    $this->client_id = trim( $client_id );
  }

  /**
   * Sets the Access Token
   *
   * @since 1.0.0
   *
   * @param string $access_token
   */
  public function set_access_token( $access_token ) {
    $this->access_token = trim( $access_token );
  }

  /**
   * Sets the data cache
   *
   * @since 1.0.0
   *
   * @param int $cache
   */
  public function set_cache( $cache ) {
    $this->cache = intval( $cache );
    if ( $this->cache < (5 * MINUTE_IN_SECONDS) ) {
      $this->cache = 5 * MINUTE_IN_SECONDS;
    }
  }

  /**
   * Retrieve the API Response without caching
   *
   * @since 1.0.0
   *
   * @param string $endpoint
   * @param array $args
   * @return object|boolean
   */
  function get_endpoint_response( $endpoint, $args = array() ) {
    if ( empty( $this->access_token ) ) {
      return false;
    }
    $url = $this->_get_endpoint_url( $endpoint, $args );

    $response = wp_remote_retrieve_body( wp_remote_get( $url ) );
    $json     = json_decode( $response );
    return $json ? $json : false;
  }

  /**
   * Retrieve the API Response cached
   *
   * @since 1.0.0
   *
   * @param string $endpoint
   * @param array $args
   * @param int $expiration
   * @return object|boolean
   */
  function get_endpoint_transient( $endpoint, $args = array(), $expiration = NULL ) {

    if ( empty( $expiration ) ) {
      $expiration = 12 * HOUR_IN_SECONDS;
    }

    $transient = 'instagram_' . md5( $this->_get_endpoint_url( $endpoint, $args ) );

    $response = get_transient( $transient );

    if ( !$response ) {
      $response = $this->get_endpoint_response( $endpoint, $args );
			set_transient( $transient, $response, $expiration );
    }

    return $response;
  }

  /**
   * Retrieve the Authorize url to get access token
   *
   * @since 1.0.0
   *
   * @return boolean|string
   */
  function get_authorize_url() {

    if ( empty( $this->client_id ) ) {
      return false;
    }

    $url = 'https://instagram.com/oauth/authorize/?client_id=' . $this->client_id . '&redirect_uri=' . get_site_url() . '&response_type=token';
    return $url;
  }

  /**
   * Generate the endponit url
   *
   * @since 1.0.0
   *
   * @param string $endpoint
   * @param array $args
   * @return boolean|string
   */
  private function _get_endpoint_url( $endpoint, $args = array() ) {

    if ( empty( $this->access_token ) ) {
      return false;
    }

    $defaults = array(
        'access_token' => $this->access_token,
    );
    $args     = wp_parse_args( $args, $defaults );

    $start    = (int) ( $endpoint[0] == '/' );
    $length   = ( substr( $endpoint, -1 ) == '/' ) ? -1 : strlen( $endpoint );
    $endpoint = substr( $endpoint, $start, $length );
    substr( $endpoint, $start, $length );

    $query_string = build_query( $args );
    $url          = "{$this->api_url}/{$endpoint}/?{$query_string}";

    return $url;
  }

}
