<script type="text/javascript">
    $('.wysiwyg-redactor-v').redactor({

        initCallback: function() {
            redactor = this;
            $('.redactor-popup_smiles a').on('click', function() {
                var pic = $(this).find('img').attr('src');
                redactor.insertHtml('<img class="smile" src="' + pic + '" />');
                $('.redactor-popup_b-smile').addClass('display-n');
                return false;
            });
        },

        minHeight: 450,
        autoresize: true,
        /* В базовом варианте нет кнопок 'h2', 'h3', 'link_add', 'link_del' но их функции реализованы с помощью выпадающих списков */
        buttons: ['bold', 'italic', 'underline', 'deleted', 'h2', 'h3', 'unorderedlist', 'orderedlist', 'link_add', 'link_del', 'image', 'video', 'smile'],
        buttonsCustom: {
            video : {
                title: 'video',
                callback: function(buttonNamem, buttonDOM, buttonObject) {
                    video = new Video({ link : '', embed : null });
                    ko.applyBindings(video, document.getElementById('redactor-popup_b-video'));
                    $('.redactor-popup_b-video').toggleClass('display-n');
                }
            },
            image : {
                title: 'image',
                callback: function(buttonNamem, buttonDOM, buttonObject) {
                    if (typeof formWPU === 'undefined'){
                        formWPU = new WysiwygPhotoUpload();
                        ko.applyBindings(formWPU, document.getElementById('redactor-popup_b-photo'));

                        $('#redactor-popup_b-photo .js-upload-files-multiple').on('change', function (evt) {
                            var files = FileAPI.getFiles(evt);
                            formWPU.upload().onFiles(files);
                            FileAPI.reset(evt.currentTarget);
                        });

                        if (FileAPI.support.dnd) {
                            $('.b-add-img_html5-tx').show();

                            $(document).dnd(function (over) {
                            }, function (files) {
                                formWPU.upload().onFiles(files);
                            });
                        }
                    }else{
                        formWPU.upload().photos([]);
                    }
                    $('.redactor-popup_b-photo').toggleClass('display-n');
                }
            },
            smile: {
                title: 'smile',
                callback: function(buttonName, buttonDOM, buttonObject) {
                    $('.redactor-popup_b-smile').toggleClass('display-n');
                }
            },
            link_add: {
                title: 'link_add',
                callback: function(buttonName, buttonDOM, buttonObject) {
                    // your code, for example - getting code
                    var html = this.get();
                }
            },
            link_del: {
                title: 'link_del',
                callback: function(buttonName, buttonDOM, buttonObject) {
                    // your code, for example - getting code
                    var html = this.get();
                }
            },
            h2: {
                title: 'h2',
                callback: function(buttonName, buttonDOM, buttonObject) {
                    // your code, for example - getting code
                    var html = this.get();
                }
            },
            h3: {
                title: 'h3',
                callback: function(buttonName, buttonDOM, buttonObject) {
                    // your code, for example - getting code
                    var html = this.get();
                }
            }
        }
    });



    if ($('.chzn').size() > 0) {
        $('.chzn').each(function () {
            var $this = $(this);
            $this.chosen({
                allow_single_deselect:$this.hasClass('chzn-deselect')
            })
        });
    }

    var BlogFormViewModel = function(data) {
        var self = this;
        self.title = ko.observable(data.title);
        self.privacyOptions = ko.observableArray([new BlogPrivacyOption({ value : 0, title : 'для <br>всех', cssClass : 'all' }, self), new BlogPrivacyOption({ value : 1, title : 'только <br>друзьям', cssClass : 'friend' }, self)]);
        self.selectedPrivacyOptionIndex = ko.observable(data.privacy);
        self.showDropdown = ko.observable(false);

        self.toggleDropdown = function() {
            self.showDropdown(! self.showDropdown());
        };

        self.selectedPrivacyOption = function() {
            return self.privacyOptions()[self.selectedPrivacyOptionIndex()];
        };
    };

    var BlogPrivacyOption = function(data, parent) {
        var self = this;
        self.value = ko.observable(data.value);
        self.title = ko.observable(data.title);
        self.cssClass = ko.observable(data.cssClass);

        self.select = function() {
            parent.selectedPrivacyOptionIndex(parent.privacyOptions.indexOf(self));
            parent.showDropdown(false);
        }
    };

    var Video = function(data, parent) {
        var self = this;
        self.link = ko.observable(data.link);
        self.embed = ko.observable(data.embed);
        self.previewLoading = ko.observable(false);
        self.previewError = ko.observable(false);

        self.check = function() {
            self.previewError(false);
            self.previewLoading(true);
            $.get('/newblog/videoPreview/', { url : self.link() }, function(html) {
                self.previewLoading(false);
                if (html === false)
                    self.previewError(true);
                else
                    self.embed(html);
            }, 'json');
        };

        self.remove = function() {
            self.link('');
            self.embed(null);
        };
    };

    var WysiwygPhotoUpload = function () {
        var self = this;
        self.upload = ko.observable(new UploadPhotos([]));

        self.add = function () {
            var html = '';
            ko.utils.arrayForEach(self.upload().photos(), function(photo) {
                html += '<!-- widget: { entity : \'AlbumPhoto\', entity_id : \'' + photo.id() + '\' } -->' + photo.html + '<!-- /widget -->';
            });
            redactor.insertHtml(html);
            self.close();
        };
        self.close = function(){
            $('#redactor-popup_b-photo').addClass('display-n');
        };
    };
</script>