define(['jquery', 'knockout', 'extensions/helpers', 'photo-slider/photo-slider'], function sliderBindingHandler($, ko, Helpers, photoSliderObj) {
    ko.bindingHandlers.photoSlider = {
        init: function photoSliderInit(element, valueAccessor, allBindings, bindingContext) {
            var values = valueAccessor(),
                tagName = 'photo-slider',
                galleryOpenHash = 'openGallery';
            var photo = (ko.isObservable(values.photo) === false) ? values.photo : values.photo().id(),
                collectionId = (ko.isObservable(values.collectionId) === false) ? values.collectionId : values.collectionId(),
                userId = (ko.isObservable(values.userId) === false) ? values.userId : values.userId();
            var getSliderToOpen = function getSliderToOpen() {
                if ($(tagName).length === 0) {
                    $('body').after('<' + tagName + ' params="{ photo: ' + photo + ', collectionId: ' + collectionId + ', userId: ' + userId + ' }"></' + tagName + '>');
                    ko.cleanNode($(tagName)[0]);
                    ko.applyBindings({}, $(tagName)[0]);
                }
            };
            if (Helpers.checkUrlForHash(galleryOpenHash)) {
                getSliderToOpen();
            }
            $(element).on('click', function sliderClickHandler(evt) {
                evt.preventDefault();
                getSliderToOpen();
            });
        }
    };
});