(function() {
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
	
	// стэк, наполняется элементами при прокрутке скриптами, в случае, когда окно не активно
	// когда окно получает фокус, то события из стека триггерятся, а стек очищается
	var stack = new Array();
	// Реализуем задержку для событий,
	// т.к. событие scroll срабатывает
	// слишком часто.
	var timer = false;
	var delay = 500;
	// Активность окна
	var windowActive = false;
	$(window).blur(function() {
		windowActive = false;
	}).focus(function() {
		windowActive = true;
		while(stack.length > 0) {
			$(stack.shift()).trigger('show');
		}
	});
	$(window).scroll(function(e) {
		var self = $(e.target);
		self.scrollEventPos = self.scrollEventPos ? [0,0] : self.scrollEventPos;
		if(!timer) {
			// тут задержка.
			timer = setTimeout(function() {
				// Расчитываем видимую область
				/** @todo если в self попадёт window, то нужно применить другие методы */
				var offset = self.offset();
				offset.bottom = offset.top + self.innerHeight();
				offset.right = offset.left + self.innerWidth();
				// Новая позиция скролла
				var newScrollPos = [];
				// Бежим по элементам
				self.find('*:visible').each(function() {
					var element = $(this);
					var elementOffset = element.offset();
					elementOffset.bottom = elementOffset.top + element.outerHeight();
					elementOffset.right = elementOffset.left + element.outerWidth();
					// Условие попадания хотя бы части элемента в область видимости
					if(
						// Входит хоть один угол
						checkIn([elementOffset.left,elementOffset.top,elementOffset.left,elementOffset.top], [offset.left,offset.top,offset.right,offset.bottom]) ||
						checkIn([elementOffset.right,elementOffset.top,elementOffset.right,elementOffset.top], [offset.left,offset.top,offset.right,offset.bottom]) ||
						checkIn([elementOffset.right,elementOffset.bottom,elementOffset.right,elementOffset.bottom], [offset.left,offset.top,offset.right,offset.bottom]) ||
						checkIn([elementOffset.left,elementOffset.bottom,elementOffset.left,elementOffset.bottom], [offset.left,offset.top,offset.right,offset.bottom]) ||
						// Пересекается хоть одна сторона
						checkIn([offset.left,offset.top,offset.left,offset.top], [elementOffset.left,elementOffset.top,elementOffset.right,elementOffset.bottom]) ||
						checkIn([offset.right,offset.top,offset.right,offset.top], [elementOffset.left,elementOffset.top,elementOffset.right,elementOffset.bottom]) ||
						checkIn([offset.right,offset.bottom,offset.right,offset.bottom], [elementOffset.left,elementOffset.top,elementOffset.right,elementOffset.bottom]) ||
						checkIn([offset.left,offset.bottom,offset.left,offset.bottom], [elementOffset.left,elementOffset.top,elementOffset.right,elementOffset.bottom])
					) {
						// Условие полного попадания
						if(checkIn([elementOffset.left,elementOffset.top,elementOffset.right,elementOffset.bottom], [offset.left,offset.top,offset.right,offset.bottom])) {
							if(windowActive) {
								$(this).trigger('show');
							} else {
								if($.inArray(this,stack)) {
									stack.push(this);
								}
							}
						}
					} else {
						// Для остальных элементов триггерим событие скрытия
						if(windowActive) {
							$(this).trigger('hide');
						}
						// и убираем их из стека, если они там есть
						var index = $.inArray(this,stack);
						if(index !== -1) {
							stack.splice(index, 1);
						}
					}
					
				});
				
				self.scrollEventPos = [self.scrollLeft(), self.scrollTop()];
				clearTimeout(timer);
				timer = false;
			}, delay);
		}
	});
})();

$(document).on('show', '.im-user-list_i', function(event) {
	if($(event.target).hasClass('im-user-list_i')) {
		console.log(event.target);
	}
});
$(function() {

	function addBaron(el) {
		$(el).each(function() {
			if (this.baron) {
				this.baron.update();
			} else {
				this.baron = $(this).baron({
					scroller: '.scroll_scroller',
					barOnCls: 'scroll__on',
					container: '.scroll_cont',
					track: '.scroll_bar-hold',
					bar: '.scroll_bar'
				});
				// Т.к. по спецификации у события onScroll нет bubbling'а,
				// то обработчик надо вешать на каждый конкретный элемент
				$('.scroll_scroller', this).scroll(function(e) {
					// стриггерим jquery событие, у которого есть bubbling,
					// но, что бы не уйти в цикл, проверим флаг.
					if(!e.fake) {
						e.fake = true;
						$(this).trigger(e);
					}
				});
			}
		});
	}
	
	
	$(document).on('koUpdate', '.im-message', function(event, elements) {
		// Перекроем событие обновления сообщения, потом отработает событие обновления всего блока foreach
		event.stopPropagation();
		$('.powertip, .redactor_toolbar li a', event.target).tooltipster({
			trigger: 'hover',
			offsetY: -6,
			delay: 200,
			maxWidth: 200,
			arrowColor: '#5C4B86',
			onlyOne: false,
			touchDevices: true,
			theme: '.tooltipster-default',
			functionReady: function(origin, continueTooltip) {}
		});
	});

	$(document).on('koUpdate', function(event, elements) {
		var self = event.target;
		addBaron('.scroll');

		$('.powertip, .redactor_toolbar li a', self).tooltipster({
			trigger: 'hover',
			offsetY: -6,
			delay: 200,
			maxWidth: 200,
			arrowColor: '#5C4B86',
			onlyOne: false,
			touchDevices: true,
			theme: '.tooltipster-default',
			functionReady: function(origin, continueTooltip) {}
		});
		
		$('.tooltip-click-b', self).tooltipster({
			trigger: 'click',
			delay: 0,
			onlyOne: false,
			touchDevices: true,
			interactive: true,
			interactiveAutoClose: false,
			theme: '.tooltipster-white',
			position: 'bottom',
			functionBefore: function(origin, continueTooltip) {
				$('.tooltip-click-b').tooltipster('hide');
				var d = $(origin.context).find(' .tooltip-drop').html();
				origin.tooltipster('update', d);
				continueTooltip(d);
			}
		});
		
	});
	$(document).on('koElementAdded', function(event) {
		event.target;
	});
});