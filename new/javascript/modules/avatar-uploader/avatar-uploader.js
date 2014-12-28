define(['knockout', 'text!avatar-uploader/avatar-uploader.html', 'ko_photoUpload', "user-config", 'bootstrap'], function AvatarUploaderHandler(ko, template, uploader, userConfig) {
    function AvatarUploader(params) {
        this.initData = params.initData;
        this.initData.form = params.initData;
        var computer = new uploader.FromComputerSingleViewModel(this.initData);
        ko.applyBindings(computer, document.getElementById('photo-tab-computer'));
    }
    return {
        viewModel: AvatarUploader,
        template: template
    };
});