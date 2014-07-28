(function($) { 

    var defaults = { 
        flyTo:'', /* К какому элементу лететь, по-умолчанию '', следите за position:absolut/relative/fixed у элементов */
        flyToX: 0, /* Конечная позиция по оси Х, по-умолчанию 0 */
        flyToY: 0, /* Конечная позиция по оси У, по-умолчанию 0 */
        flyCopy: true, /* Копировать елемент для анимации движения, по-умолчанию true */
        flyIn: 'body', /* По какому элементу лететь, летящий элемент вставиться в него, по-умолчанию 'body', работает только совместно с flyCopy */
        flyRemove: true, /* Удалять елемент после анимации, по-умолчанию true */
        flyAddClass: 'flydiv', /* Class добавляющийся к анимированному элементу, по-умолчанию 'flydiv' */
        pos: 'fixed', /* Летящий элемент позиционируется,  по-умолчанию 'fixed' */
        opacityEnd: 0.2, /* opacity на конец полета, по-умолчанию 0.2  */
        flySpeed: 1000, /* длительность анимации, по-умолчанию 1000 */
        fadeSpeed: 200, /* время ищезновения после полета, по-умолчанию 200 */
        callback: function() {}
    };
     
    // актуальные настройки, глобальные

    $.fn.flydiv = function(params, callback){

        var options = $.extend({}, defaults, options, params);
        /*var $this = $(this).clone(true).appendTo(options.flyIn).addClass('flydiv active');*/ 
        var $this = $(this);
        var flyOffset = $this.offset();

        if(options.flyTo !== '') {
            var flyTo = $(options.flyTo);
            if(flyTo.length == 0)
                return;
            options.flyToX = flyTo.offset().top + flyTo.height()/2 - $this.height()/2;
            options.flyToY = flyTo.offset().left + flyTo.width()/2 - $this.width()/2;
        }

        if(options.flyCopy == true) {
            $this = $(this).clone(true).appendTo(options.flyIn);
        } 

        $this.addClass(options.flyAddClass);
        
        $this.css({
                position : options.pos, 
                top: flyOffset.top, 
                left: flyOffset.left
            })
            .animate({
                top: options.flyToX, 
                left: options.flyToY,
                opacity: options.opacityEnd
            },options.flySpeed,function(){
                $this.fadeOut(options.fadeSpeed);
                if(options.flyRemove == true) {
                    $this.remove();
                }
                if (typeof options.callback == 'function') { 
                    options.callback.call(this);
                }
            });

        return this;
    };
})(jQuery);