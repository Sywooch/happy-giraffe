<script>
require(['jquery', 'knockout', 'common'], function($, ko) {
    $.post('/api/ads/cookie/', function(response) {
        if (response.data !== undefined) {
            $.magnificPopup.open({
                items: {
                    src: '<div class="popup popup-sign"><a href="' + response.data.url + '"><img src="' + response.data.image + '"></a></div>',
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
