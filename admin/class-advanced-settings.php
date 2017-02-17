<?php

namespace SourceFramework\Admin;

use SourceFramework\Abstracts\Option_Page;

class Advanced_Settings extends Option_Page {

  public function __construct() {

    $this->add_options_page(__('Advanced Settings', \SourceFramework\TEXDOMAIN), __('Advanced Settings', \SourceFramework\TEXDOMAIN), 'manage_options', 'source-advanced')
  }

}
