/**
 * Created by matt on 4/3/14.
 */

var InformatixPro = InformatixPro || {};

InformatixPro.PageManager = (function($, undefined) {
    // Private Members
    var _getQsFromCleanUrl = function(obj) {
            if (typeof(obj) !== 'undefined') {
                if (obj.hasOwnProperty('regex') && obj.hasOwnProperty('qs')) {
                    var match = location.pathname.match(obj.regex).slice(1), i=0;
                    $.each(obj.qs, function(k, v) {
                        obj.qs[k] = match[i++];
                    })
                    return obj.qs;
                } else {
                    throw Error('obj must contain at least regex: and qs:');
                }
            }
        },
        _highlightMenu = function() {
            var $menu = $('.nav');

            switch(location.pathname) {
                case '/About/Tori':
                    menuItem = 'about'; break;
                case '/Tori/Features':
                    menuItem = 'features'; break;
                case '/Tori/Portfolio':
                    menuItem = 'portfolio'; break;
                case '/Blog/About/Tori':
                    menuItem = 'blog'; break;
                case '/ContactUs/About/Tori':
                    menuItem = 'contact'; break;
                case '/Tori':
                default:
                    menuItem = 'home'; break;
            };

            $.each($menu.children(), function() {
                var $elem = $(this);
                if ($elem.hasClass('active')) $elem.removeClass('active');
            });

            $menu.find('*[data-menuitem="'+ menuItem + '"]').addClass('active');
        };

    // Public API Interface
    return {
        GetQs : _getQsFromCleanUrl,
        HighlightMenu: _highlightMenu
    };
})(jQuery, null);