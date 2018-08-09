(function ($) {
  'use strict';

  // Go to url on select change
  $('body').on('change', 'select.goto-url', function () {
    var url = $(this).val();
    window.location.assign(url);
  });

  // Set anchor in navbar
  $('.menu-anchor > a').addClass('anchor');

  // Smooth Anchor Scroll
  $('html').on('click', 'a.anchor', function (e) {
    var target = $(this.hash).selector;

    if (target.length && $(target).length) {
      e.preventDefault();

      // If link is in navbar closes the menu
      if ($(e.currentTarget).hasClass('nav-link') && $(e.currentTarget).parents('nav.navbar')) {
        var navbar = $(e.currentTarget).parents('nav.navbar');
        $(navbar).find('.navbar-toggler').trigger('click');
      }

      var position = parseInt($(target).offset().top);

      // To set an offset when is scrolled add 'data-offset' attribute with offset in px
      var offset = parseInt($(target).attr('data-offset'));

      if (isNaN(offset)) {
        offset = 0;
      }

      $('html, body').animate({scrollTop: position + offset}, 750);
    }
  });

})(jQuery);
