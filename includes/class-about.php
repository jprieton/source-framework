<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace SourceFramework\Core;

/**
 * Description of About
 *
 * @author perseo
 */
class About extends Admin_Page {

  public function __construct() {
    $this->page_title = __( 'About', SourceFramework\TEXTDOMAIN );
    $this->menu_title = 'SourceFramework';
    $this->capability = 'manage_options';
    $this->menu_slug  = 'source-framework-about';
    $this->icon       = 'dashicons-admin-tools';
    $this->callable   = [ $this, 'render_page' ];
    $this->position   = 76;
  }

  public function render_page() {
    ?>
    <div class="wrap">
      <h2><?php echo $this->page_title ?></h2>
    </div>
    <?php
  }

}
