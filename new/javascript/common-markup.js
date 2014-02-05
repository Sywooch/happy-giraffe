
$(function() {

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


    $(document).on('click', '.tooltip-click-b', function(){
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
    })
});

