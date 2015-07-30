define(['jquery', 'knockout', 'models/Model', 'modules-helpers/component-custom-returner'], function($, ko, Model, customReturner) {
    if (window.location.href != '#openGallery') {
        Model.get('/api/photoAds/getAdPosts/', {url: location.href}).done(function (response) {
            var data = response.data[0];

            //console.log(customReturner('photo-ad', { post: JSON.stringify(data.post), collection: JSON.stringify(data.collection) }));

            if (response.success && response.data.length > 0) {
                $.magnificPopup.open({
                    items: {
                        src: '<div class="popup popup-bnr-photo">' + customReturner('photo-ad', {
                            post: JSON.stringify(data.post),
                            collection: JSON.stringify(data.collection)
                        }) + "</div>",
                        type: 'inline',
                        overflowY: 'auto',
                        tClose: 'Закрыть',
                        fixedBgPos: true,
                        callbacks: {
                            open: function () {
                                $('html').addClass('mfp-html');
                                addBaron('.scroll');
                            },
                            close: function () {
                                $('html').removeClass('mfp-html');
                            }
                        }
                    }
                });

                ko.applyBindings({}, $('photo-ad')[0]);
            }
        }.bind(this));
    }
});