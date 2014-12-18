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
        if (this.initData.multiple === true && this.initData.collectionId !== undefined) {
            $('a[href="#photo-tab-computer-multiple"]').tab('show');
        }
        if (this.initData.multiple === true && this.initData.collectionId === undefined) {
            $('a[href="#photo-tab-computer-multiple-photos"]').tab('show');
        }
        if (this.initData.multiple === false && this.initData.collectionId !== undefined) {
            $('a[href="#photo-tab-computer-attach"]').tab('show');
        }
        if (this.initData.multiple === false && this.initData.collectionId === undefined) {
            $('a[href="#photo-tab-computer"]').tab('show');
        }

        // end of UGLY JQUERY AJAX

        this.initPUTabs = function initPUTabs(computerTabName, computerTabNameAttach, computerTabMultipleName, computerTabMultiplePhotos, urlTabName) {
            var computer,
                computerMultiple,
                albums,
                url;
            if (this.initData.multiple === true && this.initData.collectionId !== undefined) {
                computerMultiple = new uploader.FromComputerMultipleViewModel(this.initData);
                ko.applyBindings(computerMultiple, document.getElementById(computerTabMultipleName));
            }
            if (this.initData.multiple === true && this.initData.collectionId === undefined) {
                computerMultiple = new uploader.FromComputerMultipleViewModel(this.initData);
                ko.applyBindings(computerMultiple, document.getElementById(computerTabMultiplePhotos));
            }
            if (this.initData.multiple === false && this.initData.collectionId !== undefined) {
                computer = new uploader.FromComputerSingleViewModel(this.initData);
                ko.applyBindings(computer, document.getElementById(computerTabNameAttach));
            }
            if (this.initData.multiple === false && this.initData.collectionId === undefined) {
                computer = new uploader.FromComputerSingleViewModel(this.initData);
                ko.applyBindings(computer, document.getElementById(computerTabName));
            }
            //albums = new uploader.FromAlbumsViewModel(this.initData);
            url = new uploader.ByUrlViewModel(this.initData);
            //ko.applyBindings(albums, document.getElementById(albumTabName));
            ko.applyBindings(url, document.getElementById(urlTabName));
        };


        this.initPUTabs('photo-tab-computer', 'photo-tab-computer-attach', 'photo-tab-computer-multiple', 'photo-tab-computer-multiple-photos', 'photo-tab-link');

    }
    return {
        viewModel: PhotoUploaderFormView,
        template: template
    };
});