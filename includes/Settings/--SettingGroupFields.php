<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace SourceFramework\Settings;

use SourceFramework\Settings\Settings_Group;
use SourceFramework\Template\Form;

/**
 * Settings_Group class
 *
 * @package       SMGTools
 * @subpackage    Settings
 * @since         2.0.0
 * @author        Javier Prieto
 * @license       http://www.gnu.org/licenses/gpl-3.0.txt
 */
class Settings_Group_Fields extends Settings_Group {

  /**
   * Render a textarea field
   *
   * @since   2.0.0
   *
   * @param   array          $attributes
   */
  public function render_textarea( $attributes ) {
    $defaults = [
        'id'          => '',
        'default'     => '',
        'raw'         => false,
        'desc'        => '',
        'input_class' => '',
    ];

    $attributes          = wp_parse_args( $attributes, $defaults );
    $name                = sprintf( "{$this->setting_group_name}[%s]", $attributes['id'] );
    $attributes['class'] = $attributes['input_class'];
    $text                = $this->get_option( $attributes['id'], $attributes['default'] );
    $description         = str_replace( '<p>', '<p class="description">', apply_filters( 'the_content', $attributes['desc'] ) );

    if ( !$attributes['raw'] ) {
      $text = esc_textarea( $text );
    }

    unset( $attributes['input_class'], $attributes['default'], $attributes['raw'], $attributes['desc'] );

    $textarea = Form::textarea( $name, $text, $attributes );

    echo $textarea . $description;
  }

  /**
   * Render a input field
   *
   * @since   2.0.0
   *
   * @param   array          $attributes
   */
  public function render_input( $attributes ) {
    $defaults = [
        'type'        => 'text',
        'id'          => '',
        'default'     => '',
        'desc'        => '',
        'input_class' => '',
    ];

    $attributes          = wp_parse_args( $attributes, $defaults );
    $attributes['name']  = sprintf( "{$this->setting_group_name}[%s]", $attributes['id'] );
    $attributes['class'] = $attributes['input_class'];
    $attributes['value'] = $this->get_option( $attributes['id'], $attributes['default'] );
    $description         = str_replace( '<p>', '<p class="description">', apply_filters( 'the_content', $attributes['desc'] ) );

    unset( $attributes['name'], $attributes['value'], $attributes['input_class'], $attributes['default'], $attributes['desc'] );
    $input = Form::input( $attributes );
    echo $input . $description;
  }

}
