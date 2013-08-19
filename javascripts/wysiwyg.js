var WysiwygPhotoUpload = function () {
    var self = this;
    self.upload = ko.observable(new UploadPhotos(null, false));

    self.add = function () {
        var html = '';
        ko.utils.arrayForEach(self.upload().photos(), function(photo) {
            html += photo.html;
        });
        console.log('df');
        redactor.insertHtmlAdvanced(html);
        self.close();
    };
    self.close = function(){
        $('#redactor-popup_b-photo').addClass('display-n');
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

var WysiwygLink = function(data) {
    var self = this;
    self.url = ko.observable(data.url);
    self.text = ko.observable(data.text);

    self.close = function() {
        $('#redactor-popup_b-link').addClass('display-n');
    }

    self.processLink = function() {
        console.log('process');

        var link = '', text = '';

        link = self.url();
        text = self.text();

        if ($('#redactor_link_blank').prop('checked'))
        {
            target = ' target="_blank"';
            targetBlank = '_blank';
        }

        // test url (add protocol)
        var pattern = '((xn--)?[a-z0-9]+(-[a-z0-9]+)*\.)+[a-z]{2,}';
        var re = new RegExp('^(http|ftp|https)://' + pattern, 'i');
        var re2 = new RegExp('^' + pattern, 'i');

        if (link.search(re) == -1 && link.search(re2) == 0 && this.opts.linkProtocol)
        {
            link = this.opts.linkProtocol + link;
        }

        redactor.linkInsert('<a href="' + link + '">' + text + '</a>', $.trim(text), link, '');
        self.close();
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

(function($) {
    $.fn.redactorHG = function(customOptions) {
        var textarea = this;

        var defaultOptions = {
            initCallback: function() {
                redactor = this;
            },
            activeButtonsAdd: {
                h2: 'h2',
                h3: 'h3',
                a: 'link_del'
            },
            buttonsCustom: {
                video : {
                    title: 'video',
                    callback: function(buttonNamem, buttonDOM, buttonObject) {
                        this.selectionSave();
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
                        this.selectionSave();

                        this.insert_link_node = false;

                        var sel = this.getSelection();
                        var url = '', text = '';

                        var elem = this.getParent();
                        var par = $(elem).parent().get(0);
                        if (par && par.tagName === 'A')
                        {
                            elem = par;
                        }

                        if (elem && elem.tagName === 'A')
                        {
                            url = elem.href;
                            text = $(elem).text();

                            this.insert_link_node = elem;
                        }
                        else text = sel.toString();

                        var thref = self.location.href.replace(/\/$/i, '');
                        var turl = url.replace(thref, '');

                        ko.cleanNode(document.getElementById('redactor-popup_b-link'));
                        this.linkVM = new WysiwygLink({ url : turl, text : text });
                        ko.applyBindings(this.linkVM, document.getElementById('redactor-popup_b-link'))
                        $('#redactor-popup_b-link').toggleClass('display-n');
                    }
                },
                link_del: {
                    title: 'link_del',
                    exec: 'unlink'
                },
                h2: {
                    title: 'h2',
                    callback: function(buttonName, buttonDOM, buttonObject) {
                        a = buttonDOM;
                        buttonDOM.hasClass('redactor_act') ? document.execCommand('formatBlock', false, 'p') : document.execCommand('formatBlock', false, buttonName);
                    }
                },
                h3: {
                    title: 'h3',
                    callback: function(buttonName, buttonDOM, buttonObject) {
                        buttonDOM.hasClass('redactor_act') ? document.execCommand('formatBlock', false, 'p') : document.execCommand('formatBlock', false, buttonName);
                    }
                }
            }
        }

        var options = $.extend({}, defaultOptions, customOptions);

        var toolbarVerticalFixed = options.hasOwnProperty('plugins') && options.plugins.indexOf('toolbarVerticalFixed') != -1;

        $.get('/ajax/redactor/', { toolbarVerticalFixed : toolbarVerticalFixed }, function(response) {
            textarea.before(response);
            $('.redactor-popup_smiles a').on('click', function() {
                var pic = $(this).find('img').attr('src');
                redactor.insertHtml('<img class="smile" src="' + pic + '" />');
                $('.redactor-popup_b-smile').addClass('display-n');
                return false;
            });
            textarea.redactor(options);
        });
    }
})(jQuery);