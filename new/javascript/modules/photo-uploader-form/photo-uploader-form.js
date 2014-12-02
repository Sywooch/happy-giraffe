define(['jquery', 'knockout', 'text!photo-uploader-form/photo-uploader-form.html', 'ko_photoUpload', "user-config", 'bootstrap'], function photoUploaderFormViewHandler($, ko, template, uploader, userConfig) {
    function PhotoUploaderFormView(params) {
        this.initData = params.initData;
        this.multiple =  params.initData.multiple;
        this.initData.form = params.initData;
        this.statusFail = 2;
        this.statusOk = 1;
        this.statusLoading = 0;

        //UGLY JQUERY AJAX
        $('a[data-toggle="tab"]').on('shown.bs.tab', function photoUploaderTabHandler() {
            $(document).trigger('koUpdate');
        });
        if (this.initData.multiple === true) {
            $('a[href="#photo-tab-computer-multiple"]').tab('show');
        } else {
            $('a[href="#photo-tab-computer"]').tab('show');
        }

        // end of UGLY JQUERY AJAX

        this.initPUTabs = function initPUTabs(computerTabName, computerTabMultipleName, urlTabName) {
            var computer,
                computerMultiple,
                albums,
                url;
            if (this.initData.multiple === true) {
                computerMultiple = new uploader.FromComputerMultipleViewModel(this.initData);
                ko.applyBindings(computerMultiple, document.getElementById(computerTabMultipleName));
            } else {
                computer = new uploader.FromComputerSingleViewModel(this.initData);
                ko.applyBindings(computer, document.getElementById(computerTabName));
            }
            //albums = new uploader.FromAlbumsViewModel(this.initData);
            url = new uploader.ByUrlViewModel(this.initData);
            //ko.applyBindings(albums, document.getElementById(albumTabName));
            ko.applyBindings(url, document.getElementById(urlTabName));
        };


        this.initPUTabs('photo-tab-computer', 'photo-tab-computer-multiple', 'photo-tab-link');

    }
    return {
        viewModel: PhotoUploaderFormView,
        template: template
    };
});