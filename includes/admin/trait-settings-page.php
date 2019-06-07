<?php

namespace SourceFramework\Admin\Traits;

defined( 'ABSPATH' ) || exit;

/**
 * Singleton trait
 * 
 * @since     2.0.0
 */
trait Settings_Page {

  /**
   * Option group
   * @since   1.0.0
   * @var     string
   */
  protected $option_group = '';

  /**
   * Option group
   * @since   1.0.0
   * @var     string
   */
  protected $option_page = '';

  /**
   *
   * @var Settings_Group_Field
   */
  private $settings_group_field;

}
