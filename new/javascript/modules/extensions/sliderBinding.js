define(['jquery', 'knockout', 'extensions/helpers', 'photo-slider/photo-slider'], function sliderBindingHandler($, ko, Helpers, photoSliderObj) {
    ko.bindingHandlers.photoSlider = {
        init: function photoSliderInit(element, valueAccessor, allBindings, bindingContext) {
            var values = valueAccessor(),
                tagName = 'photo-slider',
                galleryOpenHash = 'openGallery';
            var photo = (ko.isObservable(values.photo) === false) ? values.photo : values.photo().id(),
                collectionId = (ko.isObservable(values.collectionId) === false) ? values.collectionId : values.collectionId(),
                userId = (ko.isObservable(values.userId) === false) ? values.userId : values.userId(),
                originalUrl = (ko.isObservable(values.originalUrl) === false) ? values.originalUrl : values.originalUrl();
            var getSliderToOpen = function getSliderToOpen() {
                if ($(tagName).length != 0) {
                    var data = ko.contextFor($(tagName).children().get(0)).$data;
                    ko.contextFor($(tagName).children().get(0)).$data.closePhotoHandler({});
                }
                if (originalUrl === undefined) {
                    $('body').after('<' + tagName + ' params="{ photo: ' + photo + ', collectionId: ' + collectionId + ', userId: ' + userId + ' }"></' + tagName + '>');
                } else {
                    $('body').after('<' + tagName + ' params="{ photo: ' + photo + ', collectionId: ' + collectionId + ', userId: ' + userId + ', originalUrl: \'' + originalUrl + '\' }"></' + tagName + '>');
                }
                ko.cleanNode($(tagName)[0]);
                ko.applyBindings({}, $(tagName)[0]);
            };
            if (Helpers.checkUrlForHash(galleryOpenHash)) {
                getSliderToOpen();
            }
            $(element).on('click', function sliderClickHandler(evt) {
                evt.preventDefault();
                $.magnificPopup.close();
                getSliderToOpen();
            });
        }
    };
});
