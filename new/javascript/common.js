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
    $('.powertip').tooltipster({
        trigger: 'hover',
        animation: 'fade',
        delay: 200,
        maxWidth: 200,
        arrowColor: '#5C4B86',
        touchDevices: true,
        theme: '.tooltipster-default',
        functionReady: function(origin, continueTooltip) {
            origin.tooltipster('reposition');
        }
    });

    $('.tooltip-click-b').tooltipster({
        trigger: 'click',
        animation: 'fade',
        delay: 0,
        onlyOne: false,
        touchDevices: true,
        interactive: true,
        theme: '.tooltipster-white',
        position: 'bottom',
        functionBefore: function(origin, continueTooltip) {
            var data = 'My new content';
            var d = $('.tooltip-click-b').find(' .tooltip-drop').html();
            console.log(origin.tooltipster());
            origin.tooltipster('update', d);
            continueTooltip(d);
        },
        functionReady: function(origin, continueTooltip) {
            origin.tooltipster('reposition');
        }
    });


});