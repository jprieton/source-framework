var formAjaxOptionsJSON;

(function ($) {
  'use strict';

  // Go to url on select change
  $('body').on('change', 'select.goto-url', function () {
    let url = $(this).val();
    window.location.assign(url);
  });

  // Options for ajaxForm default behavior
  formAjaxOptionsJSON = {
    dataType: 'json',
    method: 'post',
    beforeSubmit: function (formData, form, options) {
      let button = form.find('button[type=submit]');
      button.attr('disabled', '').text(SourceFrameworkLocale.messages.sending);
      form.trigger('ajaxFormBeforeSubmit', [form]);
    }
  };

})(jQuery);
