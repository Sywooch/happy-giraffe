define(['jquery', 'knockout', 'text!photo-uploader-form/photo-uploader-form.html', 'ko_photoUpload', "user-config", 'bootstrap'], function photoUploaderFormViewHandler($, ko, template, uploader, userConfig) {
    function PhotoUploaderFormView(params) {
        this.initData = {};
        this.multiple =  params.initData.multiple;
        this.initData.form = params.initData;
        this.statusFail = 2;
        this.statusOk = 1;
        this.statusLoading = 0;



        this.initPUTabs = function initPUTabs(computerTabName, computerTabMultipleName, albumTabName, urlTabName) {
            var computer,
                computerMultiple,
                albums,
                url;
            if (this.initData.form.multiple === true) {
                computerMultiple = new uploader.FromComputerMultipleViewModel(this.initData);
                ko.applyBindings(computerMultiple, document.getElementById(computerTabMultipleName));
            } else {
                computer = new uploader.FromComputerSingleViewModel(this.initData);
                ko.applyBindings(computer, document.getElementById(computerTabName));
            }
            albums = new uploader.FromAlbumsViewModel(this.initData);
            url = new uploader.ByUrlViewModel(this.initData);
            ko.applyBindings(albums, document.getElementById(albumTabName));
            ko.applyBindings(url, document.getElementById(urlTabName));
        };

        /**
         * Код совсем не соответствует тому, что здесь должно быть. Уберем, когда будут фотопосты к альбомам.
         */
        $.post('/api/photo/albums/getByUser/', JSON.stringify({"userId": userConfig.userId})).done(function getUserAlbums(data) {
            if (data.data.albums.length > 0) {
                //UGLY JQUERY AJAX
                $('a[data-toggle="tab"]').on('shown.bs.tab', function photoUploaderTabHandler() {
                    $(document).trigger('koUpdate');
                });
                $('a[href="#photo-tab-computer"]').tab('show');
                // end of UGLY JQUERY AJAX
            } else {
                $.post('/api/photo/albums/create/', JSON.stringify({"attributes": {"title" : "markup"}})).done(function createUserAlbum(data) {
                    if (response.success) {
                        //UGLY JQUERY AJAX
                        $('a[data-toggle="tab"]').on('shown.bs.tab', function photoUploaderTabHandler() {
                            $(document).trigger('koUpdate');
                        });
                        $('a[href="#photo-tab-computer"]').tab('show');
                        // end of UGLY JQUERY AJAX
                    }
                });
            }
        });

        this.initPUTabs('photo-tab-computer', 'photo-tab-computer-multiple', 'photo-tab-album', 'photo-tab-link');

    }
    return {
        viewModel: PhotoUploaderFormView,
        template: template
    };
});