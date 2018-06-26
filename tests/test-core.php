<?php

/**
 * Class SampleTest
 *
 * @package Source_Framework_Rewrite
 */

/**
 * Sample test case.
 */
class CoreTest extends WP_UnitTestCase {

  /**
   * A single example test.
   */
  function test_constants_defined() {
    // 9 tests
    $items = [
        'SF_VERSION',
        'SF_FILENAME',
        'SF_BASENAME',
        'SF_BASEDIR',
        'SF_BASEURL',
        'SF_TEXTDOMAIN',
        'SF_ABSPATH',
    ];

    foreach ( $items as $item ) {
      $this->assertTrue( defined( $item ) );
    }
  }

}
