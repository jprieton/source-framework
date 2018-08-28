/* global ajaxurl */

(function ($) {
  'use strict';

  // Toggle featured posts
  $('.toggle-featured').click(function (e) {
    e.preventDefault();

    var postID = $(this).data('id');
    var item = this;
    var parent = $(this).parent();

    $('<div class="spinner is-active">').appendTo(parent);
    $(item).addClass('hidden');

    $.post(ajaxurl, {
      action: 'toggle_featured_post',
      post_id: postID
    }, function (response) {
      $(parent).find('div').remove();
      if (response.data.featured) {
        $(item).addClass('dashicons-star-filled').removeClass('dashicons-star-empty hidden');
      } else {
        $(item).addClass('dashicons-star-empty').removeClass('dashicons-star-filled hidden');
      }
    });
  });

})(jQuery);
