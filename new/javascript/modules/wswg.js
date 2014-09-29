define(['knockout', 'jquery', 'imagesLoaded', 'ko_upload', 'chosen', 'redactor'], function (ko, $) {

    function HgWysiwyg (element, options) {

        this.obj = null;
        this.callbacks = options.callbacks;
        this.tempBoxHeight = null;
        this.loaded = false;

        this.load = function load() {

            if ( !this.loaded ) {
                $.get('/ajax/redactorNew/', function(response) {
                    $('body').append(response);
                });
            }
        };

        this.load();

        var redactorInstance = this;

        redactorInstance.insertBlock  = function insertBlock(obj, html) {
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
        };

        redactorInstance.fixPosition  = function fixPosition(a) {
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
        };

        redactorInstance.addCallback = function(event, handler) {
            if (! this.callbacks.hasOwnProperty(event))
                this.callbacks[event] = [];
            this.callbacks[event].push(handler);
        };

        redactorInstance.fireCallbacks = function(event, args) {
            if (this.callbacks.hasOwnProperty(event))
                for (var x in this.callbacks[event])
                    this.callbacks[event][x].apply(this.obj, args);
        };

        redactorInstance.initEditor = function initEditor () {
            redactorInstance.obj = this;
            if ( options.newStyle === true ) {
                redactorInstance.initScroll(this);
                redactorInstance.tempBoxHeight = this.$box.height();
            }
            this.obj.buttonActiveObserver = function buttonActiveObserver (e, btnName) {
                var parent = this.getParent();

                if ( e !== false ) {
                    this.buttonInactiveAll(btnName);
                }

                if ( e === false && btnName !== 'html' ) {
                    if ($.inArray(btnName, this.opts.activeButtons) !== -1 ) {
                        this.buttonActiveToggle(btnName);
                    }
                    return;
                }

                if ( parent && parent.tagName === 'A' ) {
                    this
                        .$toolbar
                            .find('a.redactor_dropdown_link')
                            .text(this.opts.curLang.link_edit);
                }
                else {
                   this
                    .$toolbar
                       .find('a.redactor_dropdown_link')
                       .text(this.opts.curLang.link_insert);

                }

                if (this.opts.activeButtonsAdd) {
                    $.each(this.opts.activeButtonsAdd, $.proxy( function (i,s) {
                        redactorInstance.opts.activeButtons.push(s);
                    } ), this);

                    $.extend(this.opts.activeButtonsStates, this.opts.activeButtonsAdd);
                }

                $.each(this.opts.activeButtonsStates, $.proxy(function (key, value) {
                   if ( $(parent).closest(key, redactorInstance.$editor.get()[0]).length != 0 ) {
                       this.buttonActive(value);
                   }
                } ), this);

                var $parent = $(parent)
                    .closest(
                        this.opts.alignmentTags.toString().toLowerCase(), this.$editor[0]
                    );

                if ($parent.length) {
                    var align = $parent.css('text-align');

                    switch (align) {
                        case 'right':
                            instance.buttonActive('alignright');
                            break;
                        case 'center':
                            instance.buttonActive('aligncenter');
                            break;
                        case 'justify':
                            instance.buttonActive('justify');
                            break;
                        default:
                            instance.buttonActive('alignleft');
                            break;
                    };

                }

            };

           redactorInstance.fireCallbacks('init', this);
        };

        redactorInstance.changeEditor =  function changeEditor(html) {
            if (options.newStyle === true) {
                var redactor = this;
                setTimeout( function () {
                    var redactorH = redactor.$box.height();

                    var bParent = redactor.$box.parents('.redactor-control_hold');
                    if ( redactorH >= 250 ) {
                        bParent.height(250);
                    }
                    else {
                        bParent.height(redactorH);
                    }

                    if (redactorInstance.tempBoxHeight != redactorH) {
                        addBaron('.redactor-control_hild .sctoll');
                    }

                    redactorInstance.tempBoxHeight = redactorHl;

                }, 0);
            }
            redactorInstance.fireCallbacks('change', arguments);
        };


        redactorInstance.focusEditor = function focusEditor (e) {
            if (options.newStyle === true) {
                $(this.$box)
                    .parents('.redactor-control_hold')
                    .addClass('redactor-control_hold__focus');
            }
            redactorInstance.fireCallbacks('focus', arguments);
        };

        redactorInstance.blurEditor = function blurEditor(e) {
            if (options.newStyle === true) {
                $(this.$box)
                    .parent('.redactor-control_hold')
                    .removeClass('redactor-control_hold__focus');
            }
            redactorInstance.fireCallbacks('blur', arguments);
        };

        redactorInstance.keyDownEditor = function keyDownEditor(e) {
              redactorInstance.fireCallbacks('keydown', arguments);
        };

        this.defaultOptions = {
            autoresize: true,
            focus: true,
            pastePlainText: true,
            observeImages: false,
            toolbarExternal: '.redactor-control_toolbar',
            buttons: ['']
        };


        this.defaultOptions.initCallback = function initCallback() {
            console.log(redactorInstance);
           redactorInstance.initEditor.bind(this);
        };

        this.defaultOptions.changeCallback = function changeCallback(html) {
          redactorInstance.changeEditor.bind(this);
        };

        this.defaultOptions.focusCallback = function focusCallback(e) {
            redactorInstance.focusEditor.bind(this);
        };

        this.defaultOptions.blurCallback = function blurCallback(e) {
          redactorInstance.blurEditor.bind(this);
        };

        this.defaultOptions.keydownCallback = function keydownCallback(e) {
          redactorInstance.keyDownEditor.bind(this);
        };

        this.run = function run () {

            var settings = $.extend({}, redactorInstance.defaultOptions, options);
            $(element).redactor(settings);

            var modalInit = redactorInstance.obj.modalInit;

            redactorInstance.obj.modalInit = function modalInit(title, content, width, callback) {
                modalInit.apply(redactorInstance.obj, arguments);
                $('body').addClass('body__redactor-popup');
            };

            var modalClose = redactorInstance.obj.modalClose;

            redactorInstance.obj.modalClose = function modalClose() {
                modalClose.apply(redactorInstance.obj);
                $('body').removeClass('body__redactor-popup');
            };
        };

        this.initScroll = function initScroll (redactor) {
            $(redactor.$box)
                .wrap('<div class="scroll"><div class="scroll_scroller"><div class="scroll_cont"></div></div></div>');
            $(redactor.$box)
                .parents('.scroll_scroller').after('<div class="scroll_bar-hold"><div class="scroll_bar"><div class="scroll_bar-in"></div></div></div>');
            addBaron('.redactor-control_hold .scroll');
        };
    };

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
                    HgWysiwyg.insertBlock(obj, data.result.comment_html);
                }
            });

        }
    }

    window.RedactorPlugins.smilesModal = {
        init: function()
        {
            var obj = this;

            var callback = function(buttonDOM) {
                HgWysiwyg.fixPosition(buttonDOM);
                $('#redactor_modal').on('resize', function() {
                    HgWysiwyg.fixPosition(buttonDOM);
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
                // obj.selectionSave();
                HgWysiwyg.fixPosition(buttonDOM);
                $('#redactor_modal').resize(function() {
                    HgWysiwyg.fixPosition(buttonDOM);
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
            redactor.selectionSave();
            HgWysiwyg.insertBlock(redactor, self.embed());
            redactor.modalClose();
        }

        self.embed.subscribe(function() {
            $('#redactor_modal').trigger('resize');
        });
    };

    return HgWysiwyg;
});