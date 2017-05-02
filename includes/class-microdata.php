<?php

namespace SourceFramework\Template;

/**
 * If this file is called directly, abort.
 */
if ( !defined( 'ABSPATH' ) ) {
  die( 'Direct access is forbidden.' );
}

use SourceFramework\Template\Tag;

/**
 * Microdata class
 *
 * @package Template
 *
 * @since   1.0.0
 * @see     http://schema.org/docs/schemas.html
 *
 * @author         Javier Prieto <jprieton@gmail.com>
 */
class Microdata {

  /**
   * Display the microdata for the body element.
   *
   * @since 1.0.0
   * @see   http://schema.org/WebPage
   */
  public static function body() {
    $default = [
        'itemscope',
        'itemtype' => 'http://schema.org/WebPage'
    ];
    $attributes = apply_filters( 'microdata_body_attributes', $default );

    $tag = Tag::get_instance();
    echo $tag->parse_attributes( $attributes );
  }

  /**
   * Display the microdata for the search results page.
   *
   * @since 1.0.0
   * @see   http://schema.org/SearchResultsPage
   */
  public static function search_results_page() {
    $default = [
        'itemscope',
        'itemtype' => 'http://schema.org/SearchResultsPage'
    ];
    $attributes = apply_filters( 'microdata_search_results_page_attributes', $default );

    $tag = Tag::get_instance();
    echo $tag->parse_attributes( $attributes );
  }

  /**
   * Display the microdata for the about page.
   *
   * @since 1.0.0
   * @see   http://schema.org/AboutPage
   */
  public static function about_page() {
    $default = [
        'itemscope',
        'itemtype' => 'http://schema.org/AboutPage'
    ];
    $attributes = apply_filters( 'microdata_about_page_attributes', $default );

    $tag = Tag::get_instance();
    echo $tag->parse_attributes( $attributes );
  }

  /**
   * Display the microdata for the contact page.
   *
   * @since 1.0.0
   * @see   http://schema.org/ContactPage
   */
  public static function contact_page() {
    $default = [
        'itemscope',
        'itemtype' => 'http://schema.org/ContactPage'
    ];
    $attributes = apply_filters( 'microdata_contact_page_attributes', $default );

    $tag = Tag::get_instance();
    echo $tag->parse_attributes( $attributes );
  }

  /**
   * Display the microdata for the frequently asked questions page.
   *
   * @since 1.0.0
   * @see   http://schema.org/QAPage
   */
  public static function faq_page() {
    $default = [
        'itemscope',
        'itemtype' => 'http://schema.org/QAPage'
    ];
    $attributes = apply_filters( 'microdata_faq_page_attributes', $default );

    $tag = Tag::get_instance();
    echo $tag->parse_attributes( $attributes );
  }

  /**
   * Display the microdata for the header section of the page.
   *
   * @since 1.0.0
   * @see   http://schema.org/WPHeader
   */
  public static function web_page_header() {
    $default = [
        'itemscope',
        'itemtype' => 'http://schema.org/WPHeader'
    ];
    $attributes = apply_filters( 'microdata_web_page_header_attributes', $default );

    $tag = Tag::get_instance();
    echo $tag->parse_attributes( $attributes );
  }

  /**
   * Display the microdata for the  footer section of the page.
   *
   * @since 1.0.0
   * @see   http://schema.org/WPFooter
   */
  public static function web_page_footer() {
    $default = [
        'itemscope',
        'itemtype' => 'http://schema.org/WPFooter'
    ];
    $attributes = apply_filters( 'microdata_web_page_footer_attributes', $default );

    $tag = Tag::get_instance();
    echo $tag->parse_attributes( $attributes );
  }

  /**
   * Display the microdata for the sidebar section of the page.
   *
   * @since 1.0.0
   * @see   http://schema.org/WPSideBar
   */
  public static function web_page_sidebar() {
    $default = [
        'itemscope',
        'itemtype' => 'http://schema.org/WPSideBar'
    ];
    $attributes = apply_filters( 'microdata_web_page_sidebar_attributes', $default );

    $tag = Tag::get_instance();
    echo $tag->parse_attributes( $attributes );
  }

  /**
   * Display the microdata for the advertising section of the page.
   *
   * @since 1.0.0
   * @see   http://schema.org/WPAdBlock
   */
  public static function web_page_ad_block() {
    $default = [
        'itemscope',
        'itemtype' => 'http://schema.org/WPAdBlock'
    ];
    $attributes = apply_filters( 'microdata_web_page_ad_block_attributes', $default );

    $tag = Tag::get_instance();
    echo $tag->parse_attributes( $attributes );
  }

  /**
   * Display the microdata for the web page element.
   *
   * @since 1.0.0
   * @see   http://schema.org/WebPageElement
   */
  public static function web_page_element() {
    $default = [
        'itemscope',
        'itemtype' => 'http://schema.org/WebPageElement'
    ];
    $attributes = apply_filters( 'microdata_web_page_element_attributes', $default );

    $tag = Tag::get_instance();
    echo $tag->parse_attributes( $attributes );
  }

  /**
   * Display the microdata for the navigation element of the page.
   *
   * @since 1.0.0
   * @see   http://schema.org/SiteNavigationElement
   */
  public static function site_navigation_element() {
    $default = [
        'itemscope',
        'itemtype' => 'http://schema.org/SiteNavigationElement'
    ];
    $attributes = apply_filters( 'microdata_site_navigation_element_attributes', $default );

    $tag = Tag::get_instance();
    echo $tag->parse_attributes( $attributes );
  }

  /**
   * Display the microdata that indicates if this web page element is the main subject of the page.
   *
   * @since 1.0.0
   * @see   http://schema.org/mainContentOfPage
   */
  public static function main_content() {
    $default = [
        'itemscope',
        'itemtype' => 'http://schema.org/mainContentOfPage'
    ];
    $attributes = apply_filters( 'microdata_main_content_attributes', $default );

    $tag = Tag::get_instance();
    echo $tag->parse_attributes( $attributes );
  }

  /**
   * Display the microdata for the page devoted to a single item.
   *
   * @since 1.0.0
   * @see   http://schema.org/ItemPage
   */
  public static function item_page() {
    $default = [
        'itemscope',
        'itemtype' => 'http://schema.org/ItemPage'
    ];
    $attributes = apply_filters( 'microdata_item_page_attributes', $default );

    $tag = Tag::get_instance();
    echo $tag->parse_attributes( $attributes );
  }

  /**
   * Display the microdata for the potential action.
   *
   * @since 1.0.0
   * @see   http://schema.org/SearchAction
   */
  public static function search_action() {
    $default = [
        'itemprop' => 'potentialAction',
        'itemscope',
        'itemtype' => 'http://schema.org/SearchAction'
    ];
    $attributes = apply_filters( 'microdata_search_action_attributes', $default );

    $tag = Tag::get_instance();
    echo $tag->parse_attributes( $attributes );
  }

  /**
   * Display the microdata for the potential action.
   *
   * @since 1.0.0
   * @see   http://schema.org/SubscribeAction
   */
  public static function subscribe_action() {
    $default = [
        'itemprop' => 'potentialAction',
        'itemscope',
        'itemtype' => 'http://schema.org/SubscribeAction'
    ];
    $attributes = apply_filters( 'microdata_subscribe_action_attributes', $default );

    $tag = Tag::get_instance();
    echo $tag->parse_attributes( $attributes );
  }

  /**
   * Display the microdata for the potential action.
   *
   * @since 1.0.0
   * @see   http://schema.org/RegisterAction
   */
  public static function register_action() {
    $default = [
        'itemprop' => 'potentialAction',
        'itemscope',
        'itemtype' => 'http://schema.org/RegisterAction'
    ];
    $attributes = apply_filters( 'microdata_register_action_attributes', $default );

    $tag = Tag::get_instance();
    echo $tag->parse_attributes( $attributes );
  }

}
