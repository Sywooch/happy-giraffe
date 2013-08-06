<script type="text/javascript">
    ko.bindingHandlers.chosenRubric =
    {
        init: function(element, valueAccessor, allBindingsAccessor, viewModel, bindingContext)
        {
            $(element).addClass('chzn');
            $(element).chosen().ready(function(){
                $('.js-select-rubric').find('.chzn-drop').append('<div class="chzn-itx-simple_add" id="rubricAddForm"><div class="chzn-itx-simple_add-hold"> <input type="text" class="chzn-itx-simple_add-itx" data-bind="value: newRubricTitle, valueUpdate: \'keyup\'"> <a class="chzn-itx-simple_add-del" data-bind="visible: newRubricTitle().length > 0, click: clearNewRubricTitle"></a> </div> <button class="btn-green" data-bind="click: createRubric">Ok</button> </div>');
                ko.applyBindings(viewModel, document.getElementById('rubricAddForm'));
            });
        },
        update: function(element, valueAccessor, allBindingsAccessor, viewModel, bindingContext)
        {
            $(element).trigger('liszt:updated');
        }
    };

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
        self.newRubricTitle = ko.observable('');
        self.rubricsList = ko.observableArray(ko.utils.arrayMap(data.rubricsList, function(rubric) {
            return new BlogRubric(rubric);
        }));
        self.selectedRubric = ko.observable(data.rubricsList[0]);

        self.clearNewRubricTitle = function() {
            self.newRubricTitle('');
        }

        self.createRubric = function() {
            $.post('/newblog/createRubric/', { title : self.newRubricTitle() }, function(response) {
                if (response.success) {
                    self.rubricsList.push(new BlogRubric({ id : response.id, title : self.newRubricTitle() }));
                    self.selectedRubric(response.id);
                    self.newRubricTitle('');
                    $('body').click();
                }
            }, 'json');
        }

        self.toggleDropdown = function() {
            self.showDropdown(! self.showDropdown());
        };

        self.selectedPrivacyOption = function() {
            return self.privacyOptions()[self.selectedPrivacyOptionIndex()];
        };
    };

    var BlogRubric = function(data, parent) {
        var self = this;
        self.id = data.id;
        self.title = data.title;
    }

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
                html += photo.html;
            });
            redactor.insertHtml(html);
            self.close();
        };
        self.close = function(){
            $('#redactor-popup_b-photo').addClass('display-n');
        };
        self.openLoad = function(data, event){
            if (self.upload().photos().length < 1)
                return true;
        };

        $('#redactor-popup_b-photo .js-upload-files-multiple').on('change', function (evt) {
            if (self.upload().photos().length < 1){
                var files = FileAPI.getFiles(evt);
                self.upload().onFiles(files);
                FileAPI.reset(evt.currentTarget);
            }
        });

        if (FileAPI.support.dnd) {
            $('.b-add-img_html5-tx').show();

            $('#redactor-popup_b-photo .b-add-img__for-single').dnd(function (over) {}, function (files) {
                if (self.upload().photos().length < 1)
                    self.upload().onFiles(files);
            });
        }
    };
</script>