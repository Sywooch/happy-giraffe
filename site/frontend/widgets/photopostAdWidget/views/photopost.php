<script>
require(['jquery', 'knockout', 'common'], function($, ko) {
    $.get('/site/cookie/', function(response) {
        if (response !== null) {
            $.magnificPopup.open({
                items: {
                    src: '<div class="popup popup-sign"><a href="' + response.url + '"><img src="' + response.image + '"></a></div>',
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
        }
    }, 'json');
});
</script>
