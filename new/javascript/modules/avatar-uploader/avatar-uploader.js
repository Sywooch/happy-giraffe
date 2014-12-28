define(['knockout', 'text!avatar-uploader/avatar-uploader.html'], function AvatarUploaderHandler(ko, template) {
    function AvatarUploader(params) {
        ko.applyBindings(computer, document.getElementById('photo-tab-computer'));
    }
    return {
        viewModel: AvatarUploader,
        template: template
    };
});