
$(function() {


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


    lastResults = [];
    $(".select-cus__add").select2({
        width:'100%',
        dropdownCssClass: 'select2-drop__add',
        allowClear: true,

        data: [{id: "foo", text:"Вова"},{id:"bar1", text:"Молодеж"},{id:"bar2", text:"Псков"},{id:"bar3", text:"Псков2"},{id:"bar4", text:"Псков3"},{id:"bar5", text:"Псков4"},{id:"bar6", text:"Псков5"},{id:"bar7", text:"Псков6"},{id:"bar8", text:"Псков7"},{id:"bar9", text:"Транспорт"}],
        createSearchChoice: function (term) {
            if(lastResults.some(function(r) { return r.text == term })) {
                return { id: term, text: term };
            }
            else {
                return { id: term, text: term + " &nbsp; <span class='color-gray font-s'> Новый альбом</span> " };
            }
        },
        formatSelection: selectCus__SearchOnDesc,
        escapeMarkup: function(m) { return m; },
        searchInputPlaceholder: 'Название альбома',

        // Возможен вариант решения http://www.bootply.com/122726
        // minimumInputLength:1,

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



