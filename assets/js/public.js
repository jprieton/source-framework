(function ($) {
  'use strict';

  /**
   * Autofill alternative nonce fields
   * @since 1.0.0
   */
  $('form input[data-nonce]').each(function () {
    $(this).val($(this).attr('data-nonce'));
    $(this).removeAttr('data-nonce');
  });

  /**
   * Get Default submit button text
   * @since 1.0.0
   */
  $('.ajax-form').find('button[type=submit]').each(function () {
    var text = $(this).attr('data-default') ? $(this).attr('data-default') : $(this).html();
    $(this).attr('data-default', text);
    $(this).removeAttr('disabled');
  });

  /**
   * Default ajaxForm elements focus behavior
   * @since 1.0.0
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
   * @since 1.0.0
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
        form.find('.ajax-cleanable').find('input[type=checkbox],input[type=radio]').prop('checked', false);
        /**
         * Trigger on success
         * @since 1.0.0
         */
        form.trigger('ajaxFormSuccess', [response, form]);
      } else {
        var textError = button.attr('data-success') ? button.attr('data-success') : SourceFrameworkLocale.messages.error;
        button.text(textError);
        /**
         * Trigger on error
         * @since 1.0.0
         */
        form.trigger('ajaxFormError', [response, form]);
      }
    }
  });

  /**
   * Go to url on select change
   * @since 1.0.0
   */
  $('.select-to-url').on('change', function () {
    let url = $(this).val();
    window.location = url;
  });

})(jQuery);
