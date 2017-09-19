<div class="frontend-helper">
  <pre class="modernizr-features hidden"></pre>
  <div>
    <div class="bs-breakpoint" title="Boostrap breakpoint">
      <div class="visible-lg">lg</div>
      <div class="visible-md">md</div>
      <div class="visible-sm">sm</div>
      <div class="visible-xs">xs</div>
    </div>
    <div class="modernizr-btn" title="moderinzr features">modernizr</div>
    <div class="info-window" title="Window height & width">
      <div class="info2">H:<span class="fh-height"></span></div>
      <div class="info2">W:<span class="fh-width"></span></div>
    </div>
    <div class="fh-collapse"><span>&raquo;</span><span>&laquo;</span></div>
  </div>
</div>
<script>
  (function ($) {
    'use strict';
    $('.modernizr-btn').click(function (e) {
      e.preventDefault();
      var features = $('html').attr('class');
      $('.modernizr-features').text(features);
      $('.modernizr-features').toggleClass('hidden');
    });
    $('.fh-collapse').click(function () {
      $(this).toggleClass('fh-collapsed');
      if ($('.fh-collapsed').length > 0) {
        $('.frontend-helper').find('.modernizr-features, .bs-breakpoint, .modernizr-btn, .info-window').addClass('hidden');
      } else {
        $('.frontend-helper').find('.bs-breakpoint, .modernizr-btn, .info-window').removeClass('hidden');
      }
    });
    $(window).on('resize scroll', function () {
      $('.frontend-helper .info-window .fh-height').text($(window).height());
      $('.frontend-helper .info-window .fh-width').text($(window).width());
    });

    $(window).trigger('resize');
  })(jQuery);
</script>
