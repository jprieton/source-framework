<?php

use SourceFramework\Data\Input;

/**
 * Sample test case.
 */
class InputTest extends WP_UnitTestCase {

  /**
   * A single example test.
   */
  function test_int_get() {

    $_GET['field-number'] = '020';
    $this->assertEquals( Input::get( 'field-number', 0, 'int' ), 20 );

    $_GET['field-number'] = '030.5';
    $this->assertEquals( Input::get( 'field-number', 0, 'int' ), 30 );

    $_GET['field-number'] = '25';
    $this->assertEquals( Input::get( 'field-number', 0, 'int' ), 25 );

    $_GET['field-number'] = '0.25';
    $this->assertEquals( Input::get( 'field-number', 0, 'int' ), 0 );

    $_GET['field-number'] = 'abcd1234';
    $this->assertEquals( Input::get( 'field-number', 0, 'int' ), 0 );

    $_GET['field-number'] = '1+2';
    $this->assertEquals( Input::get( 'field-number', 0, 'int' ), 1 );

    $_GET['field-number'] = '123abc';
    $this->assertEquals( Input::get( 'field-number', 0, 'int' ), 123 );
  }

}
