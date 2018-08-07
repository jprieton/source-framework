<div class="bs-helper d-none">

  <div class="bs-breakpoint">
    <div class="d-none d-xl-block">xl</div>
    <div class="d-none d-lg-block d-xl-none">lg</div>
    <div class="d-none d-md-block d-lg-none">md</div>
    <div class="d-none d-sm-block d-md-none">sm</div>
    <div class="d-block d-sm-none">xs</div>
  </div>

  <div class="bs-info-window">
    <div class="bs-info">H:<span class="bs-info-height"></span>px</div>
    <div class="bs-info">W:<span class="bs-info-width"></span>px</div>
  </div>

  <div class="bs-helper-collapse"><span>&raquo;</span><span>&laquo;</span></div>
</div>
<script>
  (function ($) {
    'use strict';

    $('.bs-helper').removeClass('d-none');

    $('.bs-helper-collapse').click(function () {
      $(this).toggleClass('collapsed');

      if ($(this).hasClass('collapsed')) {
        $('.bs-helper').find('.bs-breakpoint, .bs-info-window').addClass('d-none');
      } else {
        $('.bs-helper').find('.bs-breakpoint, .bs-info-window').removeClass('d-none');
      }
    });

    $(window).on('resize scroll', function () {
      $('.bs-helper .bs-info-height').text($(window).height());
      $('.bs-helper .bs-info-width').text($(window).width());
    });

    $(window).trigger('resize');

  })(jQuery);
</script>
