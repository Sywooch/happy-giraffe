
$(function() {
    // Измененный tag select
    $(".select2__blue").select2({
        width: '100%',
        minimumResultsForSearch: -1,
        containerCssClass: 'select2__blue',
        dropdownCssClass: 'select2-drop__1',
        escapeMarkup: function(m) { return m; }
    });

    // Измененный tag select c инпутом поиска
    $(".select2__blue-searchon").select2({
        width: '100%',
        containerCssClass: 'select2__blue',
        dropdownCssClass: 'select2-drop__1',
        escapeMarkup: function(m) { return m; }
    });

    // Стандартные подсказки
    $('.powertip, .redactor_toolbar li a, [data-tooltip]').tooltipster({
        trigger: 'hover',
        offsetY: -6,
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

    // Подсказки у пкопок около обольшой аватары
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

    // Попапы у кнопок
    $('.tooltip-click-b').click(function(){
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
            content: $this.find('.tooltip-popup')
        });
        
        $this.tooltipster('show');
    })
});

