(function ($) {
  'use strict';

  // Tab navigation
  $('.custom-nav-tab-wrapper > a').click(function (e) {
    e.preventDefault();
    $('.data-tab').hide();
    $('.nav-tab-wrapper a').removeClass('nav-tab-active');
    let tabContent = $(this).data('target');
    $(tabContent).stop().show();
    $(this).addClass('nav-tab-active');
  });
  $('a.nav-tab-active').trigger('click');

  // Toggle featured posts
  $('.toggle-featured').click(function (e) {
    e.preventDefault();
    let postId = $(this).data('id');
    let item = this;
    $(item).addClass('hidden').removeClass('dashicons-star-empty dashicons-star-filled');
    $.post(ajaxurl, {action: 'toggle_featured_post', post_id: postId}, function (response) {
      if (response.data.featured) {
        $(item).addClass('dashicons-star-filled').removeClass('hidden');
      } else {
        $(item).addClass('dashicons-star-empty').removeClass('hidden');
      }
    });
  });

  // Widget class shortcut
  $(document).on('click', '.widget-class-shortcut > a', function (e) {
    e.preventDefault();
    let input = $(this).parents('p').find('input');
    jQuery(input).val($(this).text())
  });

})(jQuery);
