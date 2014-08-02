/**
* Created by matt on 4/4/14.
*/
InformatixPro.Ajax = (function($, undefined) {
    var _execute = function(requestObj, handleSuccess, handleError) {
        var $ajaxDeferred = $.ajax(requestObj),
            _handleError = handleError || function(xhr, textStatus, error) {
                console.log('xhr.statusText -->' + xhr.statusText);
                console.log('textStatus -->' + textStatus);
                console.log('error  -->' + error);
            };

        $.when($ajaxDeferred).then(handleSuccess, _handleError);
    };

    return {
        execute: _execute
    };
})(jQuery, null);

InformatixPro.Ajax.Request = (function()
{
    var _contactRequest = function(d) {
        return {
            url: '/assets/php/contactHandler.php',
            type: 'post',
            data: d
        };
    };

    return {
        contactRequest : _contactRequest
    };
})();

