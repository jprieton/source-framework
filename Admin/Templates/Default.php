<div class="wrap">
  <h2><?php echo $this->title ?></h2>

  <?php if ( !empty( filter_input( INPUT_GET, 'settings-updated', FILTER_SANITIZE_STRING ) ) ) { ?>
    <div id="message" class="updated"><p><strong><?php _e( 'Settings saved.' ) ?></strong></p></div>
  <?php } ?>  

</div>