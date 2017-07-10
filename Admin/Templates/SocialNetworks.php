<div class="wrap">
  <h2><?php echo $this->title ?></h2>

  <?php if ( !empty( filter_input( INPUT_GET, 'settings-updated', FILTER_SANITIZE_STRING ) ) ) { ?>
    <div id="message" class="updated"><p><strong><?php _e( 'Settings saved.' ) ?></strong></p></div>
  <?php } ?>  


  <form method="post" action="options.php">
    <?php
    settings_fields( 'social-links' );
    do_settings_sections( 'social-links' );
    ?>
    <div class="data-tab" id="tab-general">
      <table class="form-table">
        <tr valign="top">
          <th scope="row">Facebook</th>
          <td>
            <input type="text" class="regular-text" name="social-links['social-facebook']" value="<?php echo esc_attr( get_option( 'social-facebook' ) ); ?>" />
          </td>
        </tr>
      </table>
    </div>

    <?php submit_button(); ?>

  </form>
</div>