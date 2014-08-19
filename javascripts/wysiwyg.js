(function(window, $) {
    function f(ko) {
        function setPopupPosition(a, popup) {
            var top = a.offset().top;
            var left = a.offset().left;

            popup.css({
                'top': top - popup.height() + 50,
                'left': left + 35
            });
        }
        window.setPopupPosition = setPopupPosition;

        var WysiwygPhotoUpload = function (comments) {
            var self = this;
            self.comments = comments;
            self.upload = ko.observable(new UploadPhotos(null, false, '#redactor-popup_b-photo'));

            self.add = function () {
                var html = '';
                ko.utils.arrayForEach(self.upload().photos(), function(photo) {
                    if (self.comments === true)
                        html += photo.comment_html;
                    else
                        html += photo.html;
                });
                html += '<p></p>';
                redactor.selectionRestore();
                redactor.insertHtmlAdvanced(html, true);
                self.close();
            };
            self.close = function(){
                $('#redactor-popup_b-photo').addClass('display-n');
                self.upload().photos.removeAll();
            };
        };
//        window.WysiwygPhotoUpload = WysiwygPhotoUpload;

        var WysiwygLink = function(data) {
            var self = this;
            self.url = ko.observable(data.url);
            self.text = ko.observable(data.text);

            self.close = function() {
                $('#redactor-popup_b-link').addClass('display-n');
            }

            self.processLink = function() {
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

                if (link.search(re) == -1 && link.search(re2) == 0 && redactor.opts.linkProtocol)
                {
                    link = redactor.opts.linkProtocol + link;
                }

                redactor.linkInsert('<a href="' + link + '">' + text + '</a>', $.trim(text), link, '');
                self.close();
            }
        };
//        window.WysiwygLink = WysiwygLink;

        var Video = function(data, parent) {
            var self = this;
            self.link = ko.observable(data.link);
            self.embed = ko.observable(data.embed);
            self.previewLoading = ko.observable(false);
            self.previewError = ko.observable(false);

            self.check = function() {
                self.previewError(false);
                self.previewLoading(true);
                $.get('/newblog/videoPreview/', { url : self.link(), width : 395 }, function(response) {
                    self.previewLoading(false);
                    if (response.success === false)
                        self.previewError(true);
                    else
                        self.embed(response.html);
                }, 'json');
            };

            self.remove = function() {
                self.link('');
                self.embed(null);
            };

            self.embed.subscribe(function() {
                if ($('.redactor_btn_video').length > 0)
                    setPopupPosition($('.redactor_btn_video'), $('.redactor-popup_b-video'));
            });
        };
//        window.Video = Video;

        $.fn.redactorHG = function(customOptions) {
            var textarea = this;

            var defaultOptions = {
                lang: 'ru',
                observeImages: false,
                toolbarExternal: '.wysiwyg-toolbar-btn',
                initCallback: function() {
                    redactor = this;
                    delete formWPU;
                },
                activeButtonsAdd: {
                    h2: 'h2',
                    h3: 'h3',
                    a: 'link_del'
                },
                buttonsCustom: {
                    video : {
                        title: 'Вставить видео',
                        callback: function(buttonNamem, buttonDOM, buttonObject) {
                            this.selectionSave();
                            video = new Video({ link : '', embed : null });
                            ko.applyBindings(video, document.getElementById('redactor-popup_b-video'));

                            if ($('.redactor-popup_b-video').is(':visible'))
                                $('.redactor-popup_b-video').addClass('display-n');
                            else {
                                $('.redactor-popup_b-video').removeClass('display-n');
                                setPopupPosition($(buttonDOM), $('.redactor-popup_b-video'));
                            }
                        }
                    },
                    image : {
                        title: 'Вставить фото',
                        callback: function(buttonNamem, buttonDOM, buttonObject) {
                            this.selectionSave();
                            if (typeof formWPU === 'undefined'){
                                formWPU = new WysiwygPhotoUpload(customOptions.comments);
                                ko.applyBindings(formWPU, document.getElementById('redactor-popup_b-photo'));
                            }else{
                                formWPU.upload().photos.removeAll();
                            }

                            if ($('.redactor-popup_b-photo').is(':visible'))
                                $('.redactor-popup_b-photo').addClass('display-n');
                            else {
                                $('.redactor-popup_b-photo').removeClass('display-n');
                                setPopupPosition($(buttonDOM), $('.redactor-popup_b-photo'));
                            }
                        }
                    },
                    smile: {
                        title: 'Смайлы',
                        callback: function(buttonName, buttonDOM, buttonObject) {
                            if ($('.redactor-popup_b-smile').is(':visible'))
                                $('.redactor-popup_b-smile').addClass('display-n');
                            else {
                                $('.redactor-popup_b-smile').removeClass('display-n');
                                setPopupPosition($(buttonDOM), $('.redactor-popup_b-smile'));
                            }
                        }
                    },
                    link_add: {
                        title: 'Вставить ссылку',
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
                        title: 'Удалить ссылку',
                        exec: 'unlink'
                    },
                    h2: {
                        title: 'Средний заголовок',
                        callback: function(buttonName, buttonDOM, buttonObject) {
                            a = buttonDOM;
                            buttonDOM.hasClass('redactor_act') ? document.execCommand('formatBlock', false, 'p') : document.execCommand('formatBlock', false, buttonName);
                        }
                    },
                    h3: {
                        title: 'Малый заголовок',
                        callback: function(buttonName, buttonDOM, buttonObject) {
                            buttonDOM.hasClass('redactor_act') ? document.execCommand('formatBlock', false, 'p') : document.execCommand('formatBlock', false, buttonName);
                        }
                    }
                }
            }

            var options = $.extend({}, defaultOptions, customOptions);

            var toolbarVerticalFixed = options.hasOwnProperty('plugins') && options.plugins.indexOf('toolbarVerticalFixed') != -1;

            $.get('/ajax/redactor/', {}, function(response) {
                $('.wysiwyg-related').remove();
                $('body').append(response);
                textarea.before('<div class="wysiwyg-toolbar"><div class="wysiwyg-toolbar-btn"></div>');

                $.extend($.Redactor.opts.langs['ru'], {
                    bold: 'Жирный',
                    italic: 'Курсив',
                    unorderedlist: 'Маркеры',
                    orderedlist: 'Нумерация'
                });

                $('.redactor-popup_smiles a').on('click', function() {
                    var pic = $(this).find('img').attr('src');
                    redactor.insertHtml('<img class="smile" src="' + pic + '" />');
                    $('.redactor-popup_b-smile').addClass('display-n');
                    return false;
                });
                textarea.redactor(options);
            });
        }
    }

    if (typeof define === 'function' && define['amd']) {
        define('wysiwyg_old', ['knockout'], f);
    } else {
        f(window.ko);
    }
})(window, jQuery);




