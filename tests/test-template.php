<?php

/**
 * Class SampleTest
 *
 * @package Source_Framework_Rewrite
 */

/**
 * Sample test case.
 */
class TemplateTest extends WP_UnitTestCase {

  /**
   * A single example test.
   */
  function test_html() {
    // Test shorhands
    $shorthands = [
        'div'                  => '<div></div>',
        'div.class1'           => '<div class="class1"></div>',
        'div.class1#id'        => '<div id="id" class="class1"></div>',
        '.class1'              => '<div class="class1"></div>',
        '.class1#id'           => '<div id="id" class="class1"></div>',
        'div.class1.class2'    => '<div class="class1 class2"></div>',
        'div.class1.class2#id' => '<div id="id" class="class1 class2"></div>',
        '.class1.class2'       => '<div class="class1 class2"></div>',
        '.class1.class2#id'    => '<div id="id" class="class1 class2"></div>',
    ];

    foreach ( $shorthands as $shorthand => $result ) {
      $this->assertEquals( $result, SourceFramework\Template\Html::tag( $shorthand ) );
    }

    // Test empty tags
    $empty_tags = [
        'img'  => '<img />',
        'br'   => '<br />',
        'hr'   => '<hr />',
        'link' => '<link />',
    ];

    foreach ( $empty_tags as $tag => $result ) {
      $this->assertEquals( $result, SourceFramework\Template\Html::tag( $tag ) );
    }

    // Test open tags
    $open_tags = [
        'img'                  => '<img />',
        'img.class1'           => '<img class="class1" />',
        'img.class1#id1'       => '<img id="id1" class="class1" />',
        'br'                   => '<br />',
        'hr'                   => '<hr />',
        'div'                  => '<div>',
        'div.class1'           => '<div class="class1">',
        'div.class1#id'        => '<div id="id" class="class1">',
        '.class1'              => '<div class="class1">',
        '.class1#id'           => '<div id="id" class="class1">',
        'div.class1.class2'    => '<div class="class1 class2">',
        'div.class1.class2#id' => '<div id="id" class="class1 class2">',
        '.class1.class2'       => '<div class="class1 class2">',
        '.class1.class2#id'    => '<div id="id" class="class1 class2">',
    ];

    foreach ( $open_tags as $tag => $result ) {
      $this->assertEquals( $result, SourceFramework\Template\Html::open( $tag ) );
    }

    // Test close tags
    $close_tags = [
        'img' => '',
        'br'  => '',
        'div' => '</div>',
        'p'   => '</p>',
    ];

    foreach ( $close_tags as $tag => $result ) {
      $this->assertEquals( $result, SourceFramework\Template\Html::close( $tag ) );
    }

    // test magic methods
    $this->assertEquals( SourceFramework\Template\Html::br(), '<br />' );
    $this->assertEquals( SourceFramework\Template\Html::br( 'content' ), '<br />' );
    $this->assertEquals( SourceFramework\Template\Html::div(), '<div></div>' );
    $this->assertEquals( SourceFramework\Template\Html::div( 'content' ), '<div>content</div>' );
    $this->assertEquals( SourceFramework\Template\Html::div( 'content', [ 'class' => 'class1', 'id' => 'id1' ] ), '<div class="class1" id="id1">content</div>' );

    // Test image tag
    $this->assertEquals( SourceFramework\Template\Html::img( 'pixel' ), '<img src="data:image/gif;base64,R0lGODlhAQABAIAAAP///wAAACH5BAEAAAAALAAAAAABAAEAAAICRAEAOw==" />' );
    $this->assertEquals( SourceFramework\Template\Html::img( 'pixel', [ 'src' => 'http://path.to/image.jpg' ] ), '<img src="data:image/gif;base64,R0lGODlhAQABAIAAAP///wAAACH5BAEAAAAALAAAAAABAAEAAAICRAEAOw==" />' );
    $this->assertEquals( SourceFramework\Template\Html::img( '', [ 'src' => 'http://path.to/image.jpg' ] ), '<img src="http://path.to/image.jpg" />' );

    $simple_list = [
        'red',
        'blue',
        'green',
        'yellow'
    ];
    $nested_list = [
        'colors'  => [
            'red',
            'blue',
            'green',
            'yellow'
        ],
        'numbers' => [
            'one',
            'two',
            'three',
            'four',
        ]
    ];

    $attributes = array(
        'class' => 'class1',
        'id'    => 'id1'
    );
    // Test simple lists
    $this->assertEquals( SourceFramework\Template\Html::ul( $simple_list ), '<ul><li>red</li><li>blue</li><li>green</li><li>yellow</li></ul>' );
    $this->assertEquals( SourceFramework\Template\Html::ul( $simple_list, $attributes ), '<ul class="class1" id="id1"><li>red</li><li>blue</li><li>green</li><li>yellow</li></ul>' );
    $this->assertEquals( SourceFramework\Template\Html::ol( $simple_list ), '<ol><li>red</li><li>blue</li><li>green</li><li>yellow</li></ol>' );
    $this->assertEquals( SourceFramework\Template\Html::ol( $simple_list, $attributes ), '<ol class="class1" id="id1"><li>red</li><li>blue</li><li>green</li><li>yellow</li></ol>' );

    // Test nested lists
    $this->assertEquals( SourceFramework\Template\Html::ul( $nested_list ), '<ul><li>colors<ul><li>red</li><li>blue</li><li>green</li><li>yellow</li></ul></li><li>numbers<ul><li>one</li><li>two</li><li>three</li><li>four</li></ul></li></ul>' );
    $this->assertEquals( SourceFramework\Template\Html::ul( $nested_list, $attributes ), '<ul class="class1" id="id1"><li>colors<ul><li>red</li><li>blue</li><li>green</li><li>yellow</li></ul></li><li>numbers<ul><li>one</li><li>two</li><li>three</li><li>four</li></ul></li></ul>' );
    $this->assertEquals( SourceFramework\Template\Html::ol( $nested_list ), '<ol><li>colors<ol><li>red</li><li>blue</li><li>green</li><li>yellow</li></ol></li><li>numbers<ol><li>one</li><li>two</li><li>three</li><li>four</li></ol></li></ol>' );
    $this->assertEquals( SourceFramework\Template\Html::ol( $nested_list, $attributes ), '<ol class="class1" id="id1"><li>colors<ol><li>red</li><li>blue</li><li>green</li><li>yellow</li></ol></li><li>numbers<ol><li>one</li><li>two</li><li>three</li><li>four</li></ol></li></ol>' );
  }

}
