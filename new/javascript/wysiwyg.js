/**
 * Дополнительные часто используемые байндинги
 * Author: alexk984
 * Date: 12.08.13
 */
(function() {
    function f() {
        HgWysiwyg.prototype = {
            loaded : false,
            load : function() {
                var self = this;
                if (! HgWysiwyg.prototype.loaded) {
                    $.get('/ajax/redactorNew/', function(response) {
                        $('body').append(response);
//                    ko.applyBindings(self.popupsViewModel, document.getElementById('wysiwyg-related'));
//                    //ko.applyBindings(new WysiwygVideo(), document.getElementById('redactor-popup_b-video'));
//                    $('.redactor-popup_smiles a').on('click', function() {
//                        var pic = $(this).find('img').attr('src');
//                        self.obj.insertHtml('<img class="smile" src="' + pic + '" />');
//                        $('.redactor-popup_b-smile').addClass('display-n');
//                        return false;
//                    });
                    });
                }
            },
            insertBlock : function(obj, html) {
                var targetBlock;
                var currentBlock = $(obj.getBlock());
                var newNode = $('<p>' + obj.opts.invisibleSpace + '</p>');
                if (currentBlock.text() == '​')
                    targetBlock = currentBlock;

                else {
                    currentBlock.after('<p>' + obj.opts.invisibleSpace + '</p>');
                    targetBlock = currentBlock.next();
                }

                targetBlock.html(html);
                targetBlock.after(newNode);
                obj.selectionStart(newNode);

                targetBlock.imagesLoaded(function() {
                    obj.sync();
                });
            },
            fixPosition : function(a) {
                $('#redactor_modal').hide();

                setTimeout(function() {
                    var top = a.offset().top;
                    var left = a.offset().left;

                    $('#redactor_modal').css({
                        'top': top - $('#redactor_modal').height() - 6,
                        'left': left - 100
                    });
                    $('#redactor_modal').show();
                }, 200);
            }
        }

        function HgWysiwyg(element, options)
        {
            var self = this;
            self.obj = null;
            self.load();

            self.callbacks = options.callbacks;
            self.addCallback = function(event, handler) {
                if (! self.callbacks.hasOwnProperty(event))
                    self.callbacks[event] = [];

                self.callbacks[event].push(handler);
            }
            self.fireCallbacks = function(event, args) {
                if (self.callbacks.hasOwnProperty(event))
                    for (var x in self.callbacks[event])
                        self.callbacks[event][x].apply(self.obj, args);
            }

            self.tempBoxHeight = null;

            self.defaultOptions = {
                autoresize: true,
                focus: true,
                pastePlainText: true,
                observeImages: false,
                toolbarExternal: '.redactor-control_toolbar',
                buttons: [''],
                initCallback: function()
                {
                    self.obj = this;

                    if (options.newStyle === true) {
                        self.initScroll(this);
                        self.tempBoxHeight = this.$box.height();
                    }

            self.obj.buttonActiveObserver = function(e, btnName)
            {
                var parent = this.getParent();
                if (e !== false)
                    this.buttonInactiveAll(btnName);

                if (e === false && btnName !== 'html')
                {
                    if ($.inArray(btnName, this.opts.activeButtons) != -1)
                    {
                        this.buttonActiveToggle(btnName);
                    }
                    return;
                }

                if (parent && parent.tagName === 'A') this.$toolbar.find('a.redactor_dropdown_link').text(this.opts.curLang.link_edit);
                else this.$toolbar.find('a.redactor_dropdown_link').text(this.opts.curLang.link_insert);

                if (this.opts.activeButtonsAdd)
                {
                    $.each(this.opts.activeButtonsAdd, $.proxy(function(i,s)
                    {
                        this.opts.activeButtons.push(s);

                    }, this));

                    $.extend(this.opts.activeButtonsStates, this.opts.activeButtonsAdd);
                }

                $.each(this.opts.activeButtonsStates, $.proxy(function(key, value)
                {
                    if ($(parent).closest(key, this.$editor.get()[0]).length != 0)
                    {
                        this.buttonActive(value);
                    }

                }, this));

                var $parent = $(parent).closest(this.opts.alignmentTags.toString().toLowerCase(), this.$editor[0]);
                if ($parent.length)
                {
                    var align = $parent.css('text-align');

                    switch (align)
                    {
                        case 'right':
                            this.buttonActive('alignright');
                            break;
                        case 'center':
                            this.buttonActive('aligncenter');
                            break;
                        case 'justify':
                            this.buttonActive('justify');
                            break;
                        default:
                            this.buttonActive('alignleft');
                            break;
                    }
                }
            };

                    self.fireCallbacks('init', this);
                },
                changeCallback: function(html)
                {
                    if (options.newStyle === true) {
                        var redactor = this;

                        setTimeout(function() {
                            var redactorH = redactor.$box.height();

                            var bParrent = redactor.$box.parents('.redactor-control_hold');
                            if (redactorH >= 250)
                                bParrent.height(250);
                            else
                                bParrent.height(redactorH);

                            if (self.tempBoxHeight != redactorH)
                                addBaron('.redactor-control_hold .scroll');

                            self.tempBoxHeight = redactorH;
                        }, 0);
                    }

                    self.fireCallbacks('change', arguments);
                },
                focusCallback: function(e)
                {
                    if (options.newStyle === true)
                        $(this.$box).parents('.redactor-control_hold').addClass('redactor-control_hold__focus');

                    self.fireCallbacks('focus', arguments);
                },
                blurCallback: function(e)
                {
                    if (options.newStyle === true)
                        $(this.$box).parents('.redactor-control_hold').removeClass('redactor-control_hold__focus');

                    self.fireCallbacks('blur', arguments);
                },
                keydownCallback: function(e)
                {
                    self.fireCallbacks('keydown', arguments);
                }
            }

            self.run = function() {
                var settings = $.extend({}, self.defaultOptions, options);
                $(element).redactor(settings);

                var modalInit = self.obj.modalInit;
                self.obj.modalInit = function(title, content, width, callback) {
                    modalInit.apply(self.obj, arguments);
                    $('body').addClass('body__redactor-popup');
                }

                var modalClose = self.obj.modalClose;
                self.obj.modalClose = function() {
                    modalClose.apply(self.obj);
                    $('body').removeClass('body__redactor-popup');
                }
            }

            self.initScroll = function(redactor) {
                $(redactor.$box).wrap('<div class="scroll"><div class="scroll_scroller"><div class="scroll_cont"></div></div></div>');
                $(redactor.$box).parents('.scroll_scroller').after('<div class="scroll_bar-hold"><div class="scroll_bar"><div class="scroll_bar-in"></div></div></div>');
                addBaron('.redactor-control_hold .scroll');
            }
        }

        window.RedactorPlugins = {};

        window.RedactorPlugins.imageCustom = {
            init: function() {
                var obj = this;

                var fake = '<form id="wysiwygImage" method="POST" enctype="multipart/form-data"><div class="file-fake powertip" title="Фото">' +
                    '<div class="file-fake_btn redactor_btn_image"></div>' +
                    '<input type="file" class="file-fake_inp" accept="image/*">' +
                    '</div></form>';

                this.$toolbar.append($('<li>').append(fake));
                $('#wysiwygImage .file-fake_inp').on('click', function() {
                    obj.selectionSave();
                    return true;
                });

                $('#wysiwygImage').fileupload({
                    dataType: 'json',
                    url: '/ajaxSimple/uploadPhoto/',
                    done: function (e, data) {
                        obj.selectionRestore();
                        HgWysiwyg.prototype.insertBlock(obj, data.result.comment_html);
                    }
                });

            }
        }

        window.RedactorPlugins.smilesModal = {
            init: function()
            {
                var obj = this;

                var callback = function(buttonDOM) {
                    HgWysiwyg.prototype.fixPosition(buttonDOM);
                    $('#redactor_modal').on('resize', function() {
                        HgWysiwyg.prototype.fixPosition(buttonDOM);
                    });

                    $('.redactor-popup_smiles a').on('click', function() {
                        var pic = $(this).find('img').attr('src');
                        obj.insertHtml('<img class="smile" src="' + pic + '" />');
                        obj.modalClose();
                        return false;
                    });
                }

                this.buttonAdd('smile', 'Смайлы', function(buttonName, buttonDOM, buttonObj, e) {
                    this.modalInit('Smiles', '#redactor-popup_b-smile', 500, function() {callback(buttonDOM)});
                });
            }
        }

        window.RedactorPlugins.videoModal = {
            init: function()
            {
                var obj = this;

                var callback = function(buttonDOM) {
                    obj.selectionSave();
                    HgWysiwyg.prototype.fixPosition(buttonDOM);
                    $('#redactor_modal').resize(function() {
                        HgWysiwyg.prototype.fixPosition(buttonDOM);
                    });

                    var model = new WysiwygVideo(obj);
                    ko.cleanNode($('#redactor_modal_inner')[0]);
                    ko.applyBindings(model, document.getElementById('redactor_modal_inner'));
                }

                this.buttonAdd('video', 'Видео', function(buttonName, buttonDOM, buttonObj, e) {
                    this.modalInit('Video', $('#redactor-popup_b-video').html(), 500, function() {callback(buttonDOM)});
                });
            }
        }

        function WysiwygVideo(redactor)
        {
            var self = this;
            self.link = ko.observable('');
            self.embed = ko.observable(null);
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

            self.isProvider = function(provider) {
                return ko.computed({
                    read: function () {
                        return self.link().indexOf(provider) != -1;
                    }
                });
            }

            self.add = function() {
                redactor.selectionRestore();
                HgWysiwyg.prototype.insertBlock(redactor, self.embed());
                redactor.modalClose();
            }

            self.embed.subscribe(function() {
                $('#redactor_modal').trigger('resize');
            });
        };

        return HgWysiwyg;
    };
    if (typeof define === 'function' && define['amd']) {
        define('wysiwyg', ['imagesLoaded', 'ko_upload'], f);
    } else {
        window.HgWysiwyg = f();
    }
})(window);