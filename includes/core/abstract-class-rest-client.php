<?php

namespace SourceFramework\Core\Abstracts;

defined( 'ABSPATH' ) || exit;

/**
 * Class to extend to consume remote REST
 *
 * @package        SourceFramework
 * @subpackage     Api\Abstracts
 * @since          1.0.0
 * @author         Javier Prieto
 */
abstract class Rest_Client {

  /**
   * Class constructor
   *
   * @since   1.0.0
   */
  public function __construct( $args = [] ) {
    if ( !empty( $args['transient_cache'] ) && $args['transient_cache'] > 0) {
      $this->transient_cache = $args['transient_cache'];
    }    
  }

  /**
   * Retrieves the URL for the current API.
   *
   * @since   1.0.0
   * @param   string  $endpoint
   * @return  string  URL with endpoint appended.
   */
  public function get_endpoint_url( $endpoint ) {
    return trailingslashit( $this->api_base_url ) . $endpoint;
  }

  /**
   * Retrieve the API response
   *
   * @since   1.0.0
   * @param   string    $endpoint
   * @param   array     $params
   * @param   array     $args
   * @return  mixed
   */
  public function request( $endpoint, $params = [], $args = [] ) {
    $params = wp_parse_args( $params, $this->default_params );
    $args   = wp_parse_args( $args, $this->default_args );

    $endpoint     = $this->get_endpoint_url( $endpoint );
    $args['body'] = $params;

    $this->last_request = compact( 'endpoint', 'args' );

    $api_response = false;

    // Check if response cache is enabled and exists
    if ( $this->transient_cache ) {
      $transient    = self::get_transient_name( $endpoint, $params );
      $api_response = get_transient( $transient );
    }

    if ( $api_response ) {
      return $api_response;
    }

    switch ( $args['method'] ) {
      case 'GET':
        $api_response = wp_remote_get( $endpoint, $args );
        break;
      case 'POST':
        $api_response = wp_remote_post( $endpoint, $args );
        break;
    }

    if ( !is_wp_error( $api_response ) && !empty( $api_response ) ) {
      $api_response = wp_remote_retrieve_body( $api_response );

      // Check if response cache is enabled stores in db
      if ( $this->transient_cache ) {
        set_transient( $transient, $api_response, $this->transient_cache );
      }
    } elseif ( is_wp_error( $api_response ) ) {
      $api_response = $api_response;
    }

    return $api_response;
  }

  /**
   * Retrieve the transient name
   *
   * @since   1.0.0
   * @param   string        $endpoint
   * @param   string|array  $params
   * @return  string
   */
  public static function get_transient_name( $endpoint, $params ) {
    $parts = [
        'rest_response',
        md5( $endpoint ),
        md5( http_build_query( $params ) )
    ];

    $transient_name = implode( '_', $parts );
    return $transient_name;
  }

  /**
   * Deletes transients manually, used in case of API error response
   *
   * @since   1.0.0
   * @param   string        $endpoint
   * @param   string|array  $params
   * @return  string
   */
  public static function delete_transient( $endpoint, $params ) {
    $transient_name = self::get_transient_name( $endpoint, $params );
    delete_transient( $transient_name );
  }

}
