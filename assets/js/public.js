(function ($) {
  'use strict';

  // Go to url on select change
  $('body').on('change', 'select.goto-url', function () {
    let url = $(this).val();
    window.location.assign(url);
  });

})(jQuery);
