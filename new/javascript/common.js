$(window).load(function() {

    /* custom scroll */
    var scroll = $('.scroll').baron({
        scroller: '.scroll_scroller',
        barOnCls: 'scroll__on',
        container: '.scroll_cont',
        track: '.scroll_bar-hold',
        bar: '.scroll_bar'
    }).fullWidth();

    /* Подсказки при наведении */
    /*$('.powertip').powerTip({
        placement: 'n',
        smartPlacement: true,
        offset: 8
    });*/

    $('.powertip, .redactor_toolbar li a').tooltipster({
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


});