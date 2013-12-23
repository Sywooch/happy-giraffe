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
    $('.powertip').powerTip({
        placement: 'n',
        smartPlacement: true,
        offset: 8
    });
    
});