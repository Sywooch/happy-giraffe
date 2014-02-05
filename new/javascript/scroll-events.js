/* 
 * Библиотека добалвяет события показа/скрытия элементов
 */
//$.fn.scrollEvent
(function( $ ){
    // стэк, наполняется элементами при прокрутке скриптами, в случае, когда окно не активно
    // когда окно получает фокус, то события из стека триггерятся, а стек очищается
    var stack = new Array();

    function log() {
        if (window.debugScroll) {
            console.log.apply(console, arguments);
        }
    }

    // Активность окна
    var windowActive = false;
    log('Окно не активно');
    $(window).blur(function() {
        log('Окно не активно');
        windowActive = false;
    }).focus(function() {
        log('Окно активно');
        windowActive = true;
        while (stack.length > 0) {
            var e = $(stack.shift()).trigger('show');
            log('Событие из стека: показ элемента', e);
        }
    });

/**
     * Функция проверки входит ли один прямоугольник в другой.
     * 
     * (x1,y1) - координаты левой верхней точки;
     * (x2,y2) - координаты правой нижней точки.
     * 
     * @param {[x1,y1,x2,y2]} rect1 прямоугольник, проверямый на вхождение
     * @param {[x1,y1,x2,y2]} rect2 прямоугольник, для которого производится проверка
     * @return bool true - если входит, иначе - false
     */
    function checkIn(rect1, rect2) {
        return rect2[0] <= rect1[0] && rect2[1] <= rect1[1] && rect2[2] >= rect1[2] && rect2[3] >= rect1[3];
    }

    /**
     * Функция обработчика события прокрутки элемента, и связанных с ним.
     * 
     * Данная функция стриггерит события show и hide для элементов, попавших, и не попавших в область видимости,
     * или отправит их в стек.
     * 
     * @param {jQuery} self JQuery объект, соответствующий DOM-элементу, на котором сработало событие
     * @param {jQuery} elements JQuery объект, содержащий элементы, которые необходимо проверить на вхождение
     * @returns {undefined}
     */
    function eventCallback(self, elements) {
        // Расчитываем видимую область
        /** @todo если в self попадёт window, то нужно применить другие методы */
        if (self.length > 0) {
            log('Проверка вхождений в элемент', self);
            var offset = self.offset();
            offset.bottom = offset.top + self.innerHeight();
            offset.right = offset.left + self.innerWidth();
            // Бежим по элементам
            elements.filter(':visible').each(function() {
                var element = $(this);
                log('------------------------------------------------------');
                log('Проверка элемента', $(this));
                var elementOffset = element.offset();
                elementOffset.bottom = elementOffset.top + element.outerHeight();
                elementOffset.right = elementOffset.left + element.outerWidth();
                // Условие попадания хотя бы части элемента в область видимости
                if (
                        // Входит хоть один угол
                        checkIn([elementOffset.left, elementOffset.top, elementOffset.left, elementOffset.top], [offset.left, offset.top, offset.right, offset.bottom]) ||
                        checkIn([elementOffset.right, elementOffset.top, elementOffset.right, elementOffset.top], [offset.left, offset.top, offset.right, offset.bottom]) ||
                        checkIn([elementOffset.right, elementOffset.bottom, elementOffset.right, elementOffset.bottom], [offset.left, offset.top, offset.right, offset.bottom]) ||
                        checkIn([elementOffset.left, elementOffset.bottom, elementOffset.left, elementOffset.bottom], [offset.left, offset.top, offset.right, offset.bottom]) ||
                        // Пересекается хоть одна сторона
                        checkIn([offset.left, offset.top, offset.left, offset.top], [elementOffset.left, elementOffset.top, elementOffset.right, elementOffset.bottom]) ||
                        checkIn([offset.right, offset.top, offset.right, offset.top], [elementOffset.left, elementOffset.top, elementOffset.right, elementOffset.bottom]) ||
                        checkIn([offset.right, offset.bottom, offset.right, offset.bottom], [elementOffset.left, elementOffset.top, elementOffset.right, elementOffset.bottom]) ||
                        checkIn([offset.left, offset.bottom, offset.left, offset.bottom], [elementOffset.left, elementOffset.top, elementOffset.right, elementOffset.bottom])
                        ) {
                    var mid = [(elementOffset.left + elementOffset.right) / 2, (elementOffset.top + elementOffset.bottom) / 2];
                    // Условие полного попадания
                    //if(checkIn([elementOffset.left,elementOffset.top,elementOffset.right,elementOffset.bottom], [offset.left,offset.top,offset.right,offset.bottom])) {
                    // Условие попадания центра
                    if (checkIn([mid[0], mid[1], mid[0], mid[1]], [offset.left, offset.top, offset.right, offset.bottom])) {
                        log('Полное попадание');
                        if (windowActive) {
                            $(this).trigger('show');
                        } else {
                            if ($.inArray(this, stack)) {
                                stack.push(this);
                            }
                        }
                    } else {
                        log('Частичное попадание');
                    }
                } else {
                    log('За областью видимости');
                    // Для остальных элементов триггерим событие скрытия
                    if (windowActive) {
                        $(this).trigger('hide');
                    }
                    // и убираем их из стека, если они там есть
                    var index = $.inArray(this, stack);
                    if (index !== -1) {
                        stack.splice(index, 1);
                    }
                }
                log('------------------------------------------------------');
            });
        }
    }
    
    // Добавляем JQuery плагин
    $.fn.scrollEvent = function() {
        var elements = this;
        var selector = false;
        var showCallback = false;
        var hideCallback = false;
        if(typeof(arguments[0]) == 'string') {
            selector = arguments[0];
            arguments = Array.prototype.slice.call(arguments, 1);
        }
        if(arguments[0] && typeof(arguments[0]) == 'function') {
            showCallback = arguments[0];
            if(arguments[1] && typeof(arguments[1]) == 'function') {
                hideCallback = arguments[1];
            }
        } else if(arguments[0]) {
            if(arguments[0].show) {
                showCallback = arguments[0].show;
            }
            if(arguments[0].hide) {
                hideCallback = arguments[0].hide;
            }
        }
        if(showCallback || hideCallback) {
            // Подписываемся на события
            
            // Реализуем задержку для событий,
            // т.к. события scroll и resize срабатывает
            // слишком часто.
            var timer = false;
            var delay = 500;
            elements.scroll(function(e) {
                if (!timer) {
                    // тут задержка.
                    timer = setTimeout(function() {
                        eventCallback(elements, elements.find(selector));
                        clearTimeout(timer);
                        timer = false;
                    }, delay);
                }
            });
            elements.on('koUpdate', function(event) {
                var self = $(this);
                if (self.hasClass('scroll_scroller')) {
                    $(this).trigger('scroll');
                }
            });
            // изменение размеров в результате ресайза
            $(window).on('resize', function(event) {
                var self = $('*', event.target).filter(elements);
                self.trigger('scroll');
            });
            // подпишемся на show и hide
            if(showCallback)
                $(elements).on('show', selector, showCallback);
            if(hideCallback)
                $(elements).on('hide', selector, hideCallback);
        }
    };
})( jQuery );

