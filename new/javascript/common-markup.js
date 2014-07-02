
$(function() {


    /* Инициализация скролла */
    addBaron('.scroll');
    
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

    // Измененный tag select 
    // $(".select-cus__add").select2({
    //     width: '100%',
    //     /*multiple: true,*/
    //     maximumSelectionSize: 1,
    //     maximumInputLength: 150,
    //     /*tags:["red", "green", "blue"],*/
    //     createSearchChoice: function (term) {
    //         var text = term ;
    //         return { id: term, text: text };
    //     },
    //     createSearchChoicePosition: 'bottom',
    //     /*dropdownCssClass: 'select2-drop__search-on',*/
    //     /*searchInputPlaceholder: "Выберите альбом или создайте новый",*/
    //     /*escapeMarkup: function(m) { return m; }*/

    //     /*tokenSeparators: [","],*/
        
    //     /*data: [{id: "foo", text:"foo"},{id:"bar", text:"bar"}],*/

        
    // });
    $(".select-cus__add").select2({
        width:'100%',

        data: [{id: "foo", text:"Вова"},{id:"bar", text:"bar"}],
        // createSearchChoice: function (term) {
        //     var text = term + (lastResults.some(function(r) { return r.text == term }) ? "" :  " (Новый альбом)"/*)*/;
        //     return { id: term, text: text };
        // },
        // minimumInputLength:1,
        dropdownCssClass: 'select2-drop__add',
        createSearchChoice:function(term, data) {
             if ( $(data).filter( function() {
               return this.text.localeCompare(term)===0;
             }).length===0) {
               return {id:term, text:term};
             }
           },
        // Возможен вариант решения http://www.bootply.com/122726

        // allowClear:true,
        // formatNoMatches: function(term) {
        //     $('.select2-input').keyup(function(e) {
        //         if(e.keyCode == 13) {
        //             var newTerm = $('#newTerm').val();
        //             //alert('adding:'+newTerm);
        //             $('<option>'+newTerm+'</option>').appendTo('.select-cus__add');
        //             $('.select-cus__add').select2('val',newTerm); // select the new term
        //             $(".select-cus__add").select2('close');       // close the dropdown
        //         }
        //         // },
        //     })
        // }
    
    //     formatNoMatches: function(term) {
    //         console.log(term)
    //         /* customize the no matches output */
    //         return "<input class='form-control' id='newTerm' value='"+term+"'><a href='#' id='addNew' class='btn btn-default'>Create</a>"
    //     }
    //   .parent().find('.select2-with-searchbox').on('click','#addNew',function(){
    //     /* add the new term */
    //     var newTerm = $('#newTerm').val();
    //     //alert('adding:'+newTerm);
    //     $('<option>'+newTerm+'</option>').appendTo('.select-cus__add');
    //     $('.select-cus__add').select2('val',newTerm); // select the new term
    //     $(".select-cus__add").select2('close');       // close the dropdown
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

    // layout-footer
    var layoutFooterInHeight = $('.layout-footer').height() + 50 // 50 padding
    var pageColHeight = $(window).height() - $('.layout-header').height() - layoutFooterInHeight - 100;
    $('.page-col_cont').css({'min-height': pageColHeight});

   
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



