/* global SourceFrameworkLocale */

(function ($) {
  'use strict';

  /**
   * Get Default submit button text
   */
  $('.ajax-form').find('button[type=submit]').each(function () {
    var text = $(this).attr('data-default') ? $(this).attr('data-default') : $(this).html();
    $(this).attr('data-default', text);
    $(this).removeAttr('disabled');
  });

  /**
   * Default ajaxForm elements focus behavior
   */
  $('.ajax-form').each(function () {
    var form = $(this);
    $(form).find('select,textarea,input').on('focus', function () {
      var button = form.find('button[type=submit]');
      button.html(button.attr('data-default'));
    });
  });

  /**
   * Default ajaxForm behavior
   */
  $('.ajax-form').ajaxForm({
    url: SourceFrameworkLocale.ajaxUrl,
    dataType: 'json',
    method: 'post',
    beforeSubmit: function (formData, form, options) {
      var button = form.find('button[type=submit]');
      button.attr('disabled', '').text(SourceFrameworkLocale.messages.sending);
      form.trigger('ajaxFormBeforeSubmit', [form]);
    },
    success: function (response, statusText, xhr, form) {
      var button = form.find('button[type=submit]');
      button.removeAttr('disabled');
      if (response.success) {
        var textSuccess = button.attr('data-success') ? button.attr('data-success') : SourceFrameworkLocale.messages.success;
        button.text(textSuccess);
        form.find('.ajax-cleanable').find('select,textarea,input[type=text],input[type=email]').val('');
        form.find('.ajax-cleanable').find('input[type=checkbox]').prop('checked', false);
        /**
         * Trigger on success
         */
        form.trigger('ajaxFormSuccess', [response, form]);
      } else {
        var textError = button.attr('data-success') ? button.attr('data-success') : SourceFrameworkLocale.messages.error;
        button.text(textError);
        /**
         * Trigger on error
         */
        form.trigger('ajaxFormError', [response, form]);
      }
    }
  });

})(jQuery);
