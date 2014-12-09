define(['jquery', 'knockout', 'photo-slider/photo-slider'], function sliderBindingHandler($, ko, photoSliderObj) {
    ko.bindingHandlers.photoSlider = {
        init: function photoSliderInit(element, valueAccessor, allBindings, bindingContext) {
            var values = valueAccessor(),
                tagName = 'photo-slider';
            var photo = (ko.isObservable(values.photo) === false) ? values.photo : values.photo().id(),
                collectionId = (ko.isObservable(values.collectionId) === false) ? values.collectionId : values.collectionId();
            $(element).on('click', function sliderClickHandler() {
                if ( $(tagName).length === 0 ) {
                    $(element).after('<' + tagName + ' params="{ photo: ' + photo + ', collectionId: ' + collectionId + '}"></' + tagName + '>');
                    ko.cleanNode($(tagName)[0]);
                    ko.applyBindings({}, $(tagName)[0]);
                }
            });
        }
    };
});