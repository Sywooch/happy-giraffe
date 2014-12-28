define('waitUntilExists', ['jquery'], function ($) {
    var waitUntilExists = function (handler, shouldRunHandlerOnce, isChild) {
        var found      = 'found';
        var thisEl     = $(this.selector);
        var elements   = thisEl.not(function () { return $(this).data(found); }).each(handler).data(found, true);
        if (!isChild)
        {
            (window.waitUntilExists_Intervals = window.waitUntilExists_Intervals || {})[this.selector] =
                window.setInterval(function () { thisEl.waitUntilExists(handler, shouldRunHandlerOnce, true); }, 500)
            ;
        }
        else if (shouldRunHandlerOnce && elements.length)
        {
            window.clearInterval(window.waitUntilExists_Intervals[this.selector]);
        }
        return thisEl;
   }

   return waitUntilExists;
});