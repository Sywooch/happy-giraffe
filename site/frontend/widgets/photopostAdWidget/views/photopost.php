
    $.magnificPopup.open({
        items: {
            src: '<div class="popup popup-sign"><a href="<?=$url?>"><img src="<?=$image?>"></a></div>',
            type: 'inline',
            overflowY: 'auto',
            tClose: 'Закрыть',
            fixedBgPos: true,
            callbacks: {
                open: function() {
                    $('html').addClass('mfp-html');
                    addBaron('.scroll');
                },
                close: function() {
                    $('html').removeClass('mfp-html');
                }
            }
        }
    });
