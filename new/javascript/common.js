document.domain = document.domain;

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

$(function() {

    $(document).ajaxError(function() {
        if(arguments[3] !== '' && arguments[3] !== 'abort') {
            $(".error-serv").removeClass('display-n');
        }
    });

	$(document).on('koUpdate', function(event, elements) {
		var self = event.target;
		addBaron('.scroll');
		$('.powertip, .redactor_toolbar li a, [data-tooltip]', self).tooltipster({
			trigger: 'hover',
			offsetY: -6,
			delay: 200,
			maxWidth: 200,
			arrowColor: '#5C4B86',
			onlyOne: false,
			touchDevices: true,
			theme: '.tooltipster-default',
			functionReady: function(origin, continueTooltip) {},
			functionInit: function(origin, content) {
				return origin.data('tooltip');
			}
		});

        // Подсказки у иконок действий поверх большой аватары
        $('.b-ava-large_bubble').tooltipster({
            trigger: 'hover',
            offsetY: -18,
            delay: 200,
            maxWidth: 200,
            arrowColor: '#5C4B86',
            onlyOne: false,
            touchDevices: false,
            theme: '.tooltipster-default',
            functionReady: function(origin, continueTooltip) {},
            functionInit: function(origin, content) {
                return origin.data('tooltip');
            }
        });
        
		/*$('.tooltip-click-b', self).tooltipster({
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
		});*/
		
	});

    /* Для работы select2 в magnificPopup */
    $.magnificPopup.instance._onFocusIn = function(e) {
              // Do nothing if target element is select2 input
              if( $(e.target).hasClass('select2-input') ) {
                return true;
              } 
              // Else call parent method
              $.magnificPopup.proto._onFocusIn.call(this,e);
    };

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

    // Измененный tag select
    $(".select-cus__search-off").select2({
        width: '100%',
        minimumResultsForSearch: -1,
        dropdownCssClass: 'select2-drop__search-off',
        escapeMarkup: function(m) { return m; }
    });

    // Измененный tag select c инпутом поиска
    $(".select-cus__search-on").select2({
        width: '100%',
        dropdownCssClass: 'select2-drop__search-on',
        searchInputPlaceholder: "Начните вводить",
        escapeMarkup: function(m) { return m; }
    });

    $(document).on('click', '.tooltip-click-b', function() {
        var $this = $(this);
        $this.tooltipster({
            trigger: 'click',
            delay: 0,
            onlyOne: false,
            touchDevices: true,
            interactive: true,
            interactiveAutoClose: false,
            theme: '.tooltipster-white',
            position: 'bottom',
            content: $this.find(' .tooltip-popup')
        });

        $this.tooltipster('show');
    });

    $.fn.wysiwygHG = function() {
        new HgWysiwyg(this);
    };
});

function declOfNum(number, titles) {
    cases = [2, 0, 1, 1, 1, 2];
    return titles[ (number % 100 > 4 && number % 100 < 20) ? 2 : cases[(number % 10 < 5) ? number % 10 : 5] ];
}
