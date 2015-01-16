define(['knockout', 'text!avatar-uploader/avatar-uploader.html', 'ko_photoUpload', "user-config", 'models/Model', 'photo/Photo', 'extensions/jcropInit', 'bootstrap', 'jquery.Jcrop.min'], function AvatarUploaderHandler(ko, template, uploader, userConfig, Model, Photo, jcropInit) {
    function AvatarUploader(params) {
        this.initData = params.initData;
        this.initData.form = params.initData;
        this.handlerAvatarRequest = function handlerAvatarRequest(response) {
            if (response.success === true) {
                var cropSelect = {
                    x1Measure: response.data.data.x,
                    y1Measure: response.data.data.y,
                    x2Measure: response.data.data.x + response.data.data.h,
                    y2Measure: response.data.data.y + response.data.data.w
                };
                response.data.data.photo.status = 1;
                response.data.data.photo.cropLoaded = false;
                this.photo(new Photo(response.data.data.photo));
                this.loaded(true);
                jcropInit(this.photo(), cropSelect);
            } else {
                this.loaded(true);
            }
        };
        var computer = new uploader.AvatarSingleViewModel(this.initData);
        computer.loaded = ko.observable(false);
        Model.get('/api/users/getAvatar/', { userId: userConfig.userId }).done(this.handlerAvatarRequest.bind(computer));
        ko.applyBindings(computer, document.getElementById('photo-tab-computer'));
    }
    return {
        viewModel: AvatarUploader,
        template: template
    };
});