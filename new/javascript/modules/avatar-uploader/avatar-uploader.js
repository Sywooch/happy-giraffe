define(['knockout', 'text!avatar-uploader/avatar-uploader.html', 'ko_photoUpload', "user-config", 'models/Model', 'photo/Photo', 'bootstrap', 'jquery.Jcrop.min'], function AvatarUploaderHandler(ko, template, uploader, userConfig, Model, Photo) {
    function AvatarUploader(params) {
        this.initData = params.initData;
        this.initData.form = params.initData;
        var computer = new uploader.AvatarSingleViewModel(this.initData);
        ko.applyBindings(computer, document.getElementById('photo-tab-computer'));
    }
    return {
        viewModel: AvatarUploader,
        template: template
    };
});