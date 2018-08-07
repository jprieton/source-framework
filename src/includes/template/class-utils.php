<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of class-template
 *
 * @author perseo
 */
class Utils {

  /**
   *
   * @param string $slug
   * @param string $name
   */
  public static function get_template_part( $slug, $name = null ) {

    /**
     * Fires before the specified template part file is loaded.
     *
     * The dynamic portion of the hook name, `$slug`, refers to the slug name
     * for the generic template part.
     *
     * @since 2.0.0
     *
     * @param string      $slug The slug name for the generic template.
     * @param string|null $name The name of the specialized template.
     */
    do_action( "sf_get_template_part_{$slug}", $slug, $name );

    $templates = [];
    $name      = (string) $name;
    if ( '' !== $name ) {
      $templates[] = STYLESHEETPATH . "/sf_templates/{$slug}-{$name}.php";
      $templates[] = SF_ABSPATH . "/templates/{$slug}-{$name}.php";
    }
    $templates[] = STYLESHEETPATH . "/sf_templates/{$slug}.php";
    $templates[] = SF_ABSPATH . "/templates/{$slug}.php";

    $located = '';
    foreach ( $templates as $template ) {
      if ( file_exists( $template ) ) {
        $located = $template;
        break;
      }
    }

    if ( '' != $located ) {
      load_template( $located, false );
    }
  }

}
