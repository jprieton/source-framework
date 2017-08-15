(function ($) {
  'use strict';

  $(function () {
    
    // Tab navigation
    $('.custom-nav-tab-wrapper > a').click(function (e) {
      e.preventDefault();
      $('.data-tab').hide();
      $('.nav-tab-wrapper a').removeClass('nav-tab-active');
      var tabContent = $(this).data('target');
      $(tabContent).stop().show();
      $(this).addClass('nav-tab-active');
    });
    $('a.nav-tab-active').trigger('click');

  });

})(jQuery);
