/**!
 * Bootstrap Alerts v2.0.0, jQuery plugin
 *
 * Copyright(c) 2015, Javier Prieto
 * http://jprieton.github.io/bootstrap-alerts/
 *
 * A jQuery plugin for displaying Bootstrap alerts.
 * Licensed under the MIT License
 */
(function ($) {
    'use strict';
    $.fn.bootstrap_alert = function (options) {
        let settings = $.extend({
            type: 'info',
            dismiss: true,
            content: '',
            clear: true,
            timeout: false
        }, options);
        if (settings.type.length === 0) {
            console.error('bootstrap_alert: type is empty');
            return false;
        }
        if (settings.content.length === 0) {
            console.error('bootstrap_alert: content is empty');
            return false;
        }
        let div = $('<div class="alert fade show" role="alert">');
        div.addClass('alert-' + settings.type + (settings.dismiss ? '' : ' alert-dismissible'));
        div.append(settings.content);
        let button = $('<button type="button" class="close" data-dismiss="alert" aria-label="Close">');
        $('<span aria-hidden="true">').html('&times;').appendTo(button);
        if (settings.dismiss && typeof (settings.timeout) === 'number') {
            setTimeout(function () {
                button.trigger('click');
            }, settings.timeout);
        }
        if (settings.dismiss) {
            button.appendTo(div);
        }
        if (settings.clear) {
            this.empty();
        }
        div.appendTo(this);
    };
})(jQuery);
