$(document).on('show', '.im-user-list_i', function(event) {
	if(event.target == this) {
		//console.log('show', event.target);
	}
}).on('hide', '.im-user-list_i', function(event) {
	if(event.target == this) {
		//console.log('hide', event.target);
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
	
	    // tooltip
    $('.no-touch .powertip, .no-touch .redactor_toolbar li a, .mfp-close').tooltipster({
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

    // tooltip
    // попап у иконки
    $('.tooltip-click-b').tooltipster({
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
            console.log(origin.context.className);
            origin.tooltipster('update', d);
            continueTooltip(d);
        }
    });

    $('.popup-a').magnificPopup({
        type: 'inline',
        overflowY: 'auto',
        tClose: 'Закрыть',
        fixedBgPos: true,
        
        // When elemened is focused, some mobile browsers in some cases zoom in
        // It looks not nice, so we disable it:
        callbacks: {
            open: function() {
                $('html').addClass('mfp-html');
            },
            close: function() {
                $('html').removeClass('mfp-html');
            }
        }
    });
});