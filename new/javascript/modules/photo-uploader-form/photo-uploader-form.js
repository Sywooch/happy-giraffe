define(['jquery', 'knockout', 'text!photo-uploader-form/photo-uploader-form.html', 'ko_photoUpload', "user-config", 'bootstrap'], function photoUploaderFormViewHandler($, ko, template, uploader, userConfig) {
    function PhotoUploaderFormView(params) {
        this.initData = {};
        this.multiple =  params.initData.multiple;
        this.initData.form = params.initData;
        this.editor = params.editor;
        this.statusFail = 2;
        this.statusOk = 1;
        this.statusLoading = 0;

        //UGLY JQUERY AJAX
        $('a[data-toggle="tab"]').on('shown.bs.tab', function photoUploaderTabHandler() {
            $(document).trigger('koUpdate');
        });
        $('a[href="#photo-tab-computer"]').tab('show');
        // end of UGLY JQUERY AJAX

        this.initPUTabs = function initPUTabs(computerTabName, computerTabMultipleName, albumTabName, urlTabName) {
            console.log(params);
            var computer,
                computerMultiple,
                albums,
                url;
            if (this.initData.form.multiple === true) {
                computerMultiple = new uploader.FromComputerMultipleViewModel(this.initData, this.editor);
                ko.applyBindings(computerMultiple, document.getElementById(computerTabMultipleName));
            } else {
                computer = new uploader.FromComputerSingleViewModel(this.initData, this.editor);
                ko.applyBindings(computer, document.getElementById(computerTabName));
            }
            albums = new uploader.FromAlbumsViewModel(this.initData, this.editor);
            url = new uploader.ByUrlViewModel(this.initData, this.editor);
            ko.applyBindings(albums, document.getElementById(albumTabName));
            ko.applyBindings(url, document.getElementById(urlTabName));
        };


        this.initPUTabs('photo-tab-computer', 'photo-tab-computer-multiple', 'photo-tab-album', 'photo-tab-link');

    }
    return {
        viewModel: PhotoUploaderFormView,
        template: template
    };
});