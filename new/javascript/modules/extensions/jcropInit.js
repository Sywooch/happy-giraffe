define(['jquery', 'models/Model', 'user-config', 'jquery.Jcrop.min'], function ($, Model, userConfig) {
    var handleSubmitSet = function handleSubmitSet (data) {
        $.magnificPopup.close();
        location.reload(false);
    };
    var measures = function mesures(cropSelectMark, wh, scale) {
        if (cropSelectMark !== undefined) {
            return [cropSelectMark.x1Measure, cropSelectMark.y1Measure, cropSelectMark.x2Measure, cropSelectMark.y2Measure];
        }
        return [wh[0] / 2 - 100, wh[1] / 2 + 100, wh[0] / 2 + 100, wh[1] / 2 - 100];
    };
    var jcropInit = function jcropInit(photoObject, cropSelect) {
        var api;
        $('#jcrop_target').Jcrop({
            // start off with jcrop-light class
            bgOpacity: 0.3,
            bgColor: '#fff',
            aspectRatio: 1,
            boxWidth: 700,
            boxHeight: 470,
            addClass: 'jcrop-circle'
        }, function afterRelease() {
            api = this;
            var wh = api.getBounds(),
                scale = api.getScaleFactor();
            api.setSelect(measures(cropSelect, wh, scale));
            api.setOptions({ bgFade: true });
            api.ui.selection.addClass('jcrop-selection');
            photoObject.cropLoaded(true);
            $('#adding-avatar').on('click', function addingEvent(event) {
                event.preventDefault();
                var apiSizes = api.tellSelect();
                var cropObj = {
                    x: parseInt(apiSizes.x),
                    y: parseInt(apiSizes.y),
                    w: parseInt(apiSizes.w),
                    h: parseInt(apiSizes.h)
                };
                Model
                    .get('/api/users/setAvatar/', { photoId: photoObject.id(), userId: userConfig.userId, cropData: cropObj })
                    .done(handleSubmitSet);
            });
            $('#canceling-avatar').on('click', function cancelingEvent(event) {
                event.preventDefault();
                $.magnificPopup.close();
            });
            $('#change-avatar').on('click', function cancelingEvent(event) {
                event.preventDefault();
                photoObject = null;
            });
        });
    };
    return jcropInit;
});