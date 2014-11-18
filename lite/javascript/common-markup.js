
$(function() {

    /* Инициализация скролла */
    addBaron('.scroll');


    // Стандартные подсказки
    // $('.powertip, .redactor_toolbar li a, [data-tooltip]').tooltipster({
    //     trigger: 'hover',
    //     offsetY: -6,
    //     delay: 200,
    //     maxWidth: 200,
    //     arrowColor: '#5C4B86',
    //     onlyOne: false,
    //     touchDevices: false,
    //     theme: '.tooltipster-default',
    //     functionReady: function(origin, continueTooltip) {},
    //     functionInit: function(origin, content) {
    //         return origin.data('tooltip');
    //     }
    // });

    // Фиксация элемента при скролле
    $('.i-affix').affix({
        offset: {
            top: function () {
                return (this.top = $('.i-affix').offset().top)
            }
        }
      });
    $('.i-affix').on('affix.bs.affix', function () {
        $this = $(this);
        $this.parent().css( "height", $this.outerHeight() );
    });


});



