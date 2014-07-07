
$(function() {
    // Измененный tag select c инпутом поиска
/*    $('.select-cus__search-on').selectize({
        create: true,
        dropdownParent: 'body'
    });
    // Измененный tag select
    $('.select-cus__search-off').selectize({
        create: true,
        dropdownParent: 'body',
        onDropdownOpen: function(){
            // Делает не возможным ввод в input при открытом списке, без autocomplite
            this.$wrapper.find('input').attr({disabled: 'disabled'})
        }
    });*/
/*    $(".select-cus__search-on").select2({
        width: '100%',
        minimumResultsForSearch: -1,
        containerCssClass: 'select2__blue',
        dropdownCssClass: 'select2-drop__1',
        escapeMarkup: function(m) { return m; }
    });*/


    /* Инициализация скролла */
    addBaron('.scroll');
    
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
        escapeMarkup: function(m) { return m; }
    });

    function selectCus__SearchOnDesc(state) {
        if (!state.id) return state.text; // optgroup
        return "<div class='select2-result_i'>" + state.text + "</div><div class='select2-result_desc'>Текст описание</div>";
    }
    // Измененный tag select c инпутом поиска
    $(".select-cus__search-on-desc").select2({
        width: '100%',
        dropdownCssClass: 'select2-drop__search-on',
        formatResult: selectCus__SearchOnDesc,
        formatSelection: selectCus__SearchOnDesc,
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

    // Подсказки у кнопок около обольшой аватары
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
            contentCloning:true,
            interactiveAutoClose: false,
            theme: '.tooltipster-white',
            position: 'bottom',
            content: $this.find('.tooltip-popup')
        });
        
        $this.tooltipster('show');
    })

    var pageColHeight = $(window).height() - $('.layout-header').height() - 60;
    $('.page-col').css({'min-height': pageColHeight});

   
    $('.popup-a__add').on('mfpOpen', function(e /*, params */) {
        addBaron('.popup .scroll');
        
        var albumSlider =  $(".album-slider_hold").slider({
            min: 1,
            max: 3,
            value: 2,
            
        });
        $( ".album-slider_tx-minus" ).click(function() {
            sliderValue = albumSlider.slider( "value" ) - 1;
            albumSlider.slider( "value",  sliderValue );
        });
        $( ".album-slider_tx-plus" ).click(function() {
            sliderValue = albumSlider.slider( "value" ) + 1;
            albumSlider.slider( "value",  sliderValue );
        });
        addBaron('.popup .scroll');
    });

});



