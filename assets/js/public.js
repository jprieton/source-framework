(function ($) {
  'use strict';

  // Go to url on select change
  $('body').on('change', 'select.goto-url', function () {
    var url = $(this).val();
    window.location.assign(url);
  });

  // Smooth Anchor Scroll
  $('html').on('click', 'a.anchor', function (e) {
    e.preventDefault();
    var target = $(this.hash).selector;

    if (target.length) {
      var position = parseInt($(target).offset().top);
      var offset = parseInt($(target).attr('data-offset'));

      if (isNaN(offset)) {
        offset = 0;
      }

      $('html, body').animate({scrollTop: position + offset}, 750 );
    }
  });

})(jQuery);
