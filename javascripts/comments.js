(function(window) {
    function f(ko) {
        var ENTER_KEY_SEND = 1;
        function CommentViewModel(data) {
            var self = this;
            self.OPENED_BOT = 0;
            self.OPENED_TOP = 1;
            ko.mapping.fromJS(data, {}, self);
            self.extended = ko.observable(false);
            self.opened = ko.observable(false);
            self.gallery = ko.observable(data.gallery);
            self.objectName = ko.observable(data.objectName);
            self.editor = null;

            self.comments = ko.observableArray([]);
            self.comments(ko.utils.arrayMap(data.comments, function (comment) {
                return new NewComment(comment, self);
            }));
            self.enterSetting = ko.observable(data.messaging__enter);
            self.enterSetting.subscribe(function (a) {
                $.post('/ajax/setUserAttribute/', { key: 'messaging__enter', value: a ? 1 : 0 });
                ENTER_KEY_SEND = a;
            });
            ENTER_KEY_SEND = self.enterSetting();

            self.sending = ko.observable(false);
            self.focusEditor = function () {
                setTimeout(function () {
                    self.editor.redactor('focusEnd');
                }, 100);
                return true;
            };

            self.getCount = ko.computed(function () {
                return self.allCount();
            });

            self.openComment = function (val) {

                if (self.opened() !== val) {
                    self.opened(val);
                    if (self.response() !== false)
                        self.cancelReply();
                    ko.utils.arrayForEach(self.comments(), function (comment) {
                        if (comment.editMode())
                            comment.editMode(false);
                    });

                    self.initEditor((val == self.OPENED_TOP ? 'add_top_' : 'add_') + self.objectName());
                }
                else
                    self.focusEditor();
            };

            self.Enter = function () {
                if (self.enterSetting())
                    self.addComment();
            };
            self.addComment = function () {
                if (!self.sending()) {
                    self.sending(true);
                    self.disableInput();
                    $.post('/ajaxSimple/addComment/', {entity: self.entity(), entity_id: self.entity_id(), response_id: self.responseId(), text: self.getMessageText()},
                        function (response) {
                            if (response.status) {
                                if (self.response() !== false)
                                    self.cancelReply();
                                self.opened(false);
                                self.comments.push(new NewComment(response.data, self));
                                self.allCount(self.allCount() + 1);
                                if (self.gallery()) {
                                    $('.photo-window_right').animate({ scrollTop: $('.comments-gray').height() + 500 }, "fast");
                                    $('#add_' + self.objectName()).val('').removeAttr('readonly');
                                }
                            }
                            self.sending(false);
                        }, 'json');
                }
            };
            self.goBottom = function () {
                if (userIsGuest)
                    $('a[href=#loginWidget]').trigger('click');

                if (self.full())
                    $('body').stop().animate({scrollTop: $('.layout-wrapper').height()}, "normal");
                self.openComment();
            };
            self.initEditor = function (id) {
                self.editor = $('#' + id);
                if (!self.gallery()) {
        //            $('#' + id).redactorHG({
        //                pastePlainText: true,
        //                initCallback: function () {
        //                    redactor = this;
        //                    self.focusEditor();
        //                },
        //                changeCallback: function(html) {
        //                    if (self.response() !== false && html.indexOf(self.response().replyUserLink()) == -1) {
        //                        self.cancelReply();
        //                        self.goBottom();
        //                    }
        //                },
        //                minHeight: 68,
        //                autoresize: true,
        //                buttons: ['bold', 'italic', 'underline', 'image', 'video', 'smile'],
        //                comments: true
        //            });

                    var wysiwyg = new HgWysiwyg($('#' + id), {
                        focus: false,
                        toolbarExternal: '.wysiwyg-toolbar-btn:empty',
                        minHeight: 68,
                        buttons: ['bold', 'italic', 'underline'],
                        plugins: ['imageCustom', 'smilesModal', 'videoModal'],
                        callbacks: {
                            init : [
                                function () {
                                    redactor = this;
                                    self.focusEditor();
                                }
                            ],
                            change : [
                                function(html) {
                                    if (self.response() !== false && html.indexOf(self.response().replyUserLink()) == -1) {
                                        self.cancelReply();
                                        self.goBottom();
                                    }
                                }
                            ]
                        }
                    });

                    wysiwyg.run();
                }
            };

            self.disableInput = function () {
                $('#add_' + self.objectName()).attr('readonly', 'readonly');
            };

            self.getMessageText = function () {
                if (self.gallery()) {
                    if (self.editor == null)
                        return $('#add_' + self.objectName()).val();
                    else
                        return self.editor.val();
                } else
                    return self.editor.html();
            };

            self.toggleExtended = function() {
                self.extended(! self.extended());

                if (self.extended()) {
                    self.scroll = $('#' + self.objectName()).find('.scroll').baron({
                        scroller: '.scroll_scroller',
                        container: '.scroll_cont',
                        track: '.scroll_bar-hold',
                        bar: '.scroll_bar'
                    });
                }
                else
                    self.scroll.dispose();
            };

            self.commentsToShow = ko.computed(function() {
                if (self.full() || self.extended())
                    return self.comments();

                return self.comments().slice(self.comments.length - 3, self.comments().length);
            });

            /*************************************** reply ****************************************/
            self.response = ko.observable(false);
            self.responseId = ko.computed(function () {
                if (self.response())
                    return self.response().id;
                else
                    return '';
            });

            self.Reply = function (comment) {
                if (self.opened() !== false)
                    self.opened(false);
                self.response(comment);
                self.initEditor('reply_' + self.response().id());
                self.editor.html(comment.replyTreatmentHtml());
            };

            self.cancelReply = function() {
                self.response(false);
            }
        }
        window.CommentViewModel = CommentViewModel;

        function NewComment(data, parent) {
            var self = this;
            self.parent = parent;
            self.removed = ko.observable(false);
            self.editMode = ko.observable(false);
            ko.mapping.fromJS(data, {}, self);

            self.author = new User(data['author']);
            self.ownComment = ko.computed(function () {
                return CURRENT_USER_ID == self.author.id();
            });
            self.canAdmin = ko.computed(function () {
                return self.canEdit() || self.canRemove();
            });
            self.albumPhoto = ko.computed(function () {
                return self.photoUrl() !== false;
            });

            self.Like = function () {
                if (userIsGuest)
                    $('a[href=#loginWidget]').trigger('click');
                else if (CURRENT_USER_ID != self.author.id()) {
                    $.post('/ajaxSimple/commentLike/', {id: self.id}, function (response) {
                        if (response.status) {
                            if (self.userLikes()) {
                                self.userLikes(false);
                                self.likesCount(self.likesCount() - 1);
                            } else {
                                self.userLikes(true);
                                self.likesCount(self.likesCount() + 1);
                            }
                        }
                    }, 'json');
                }
            };

            self.GoEdit = function () {
                self.editMode(true);
                $('#text' + self.id()).val(self.editHtml());
                self.parent.initEditor('text' + self.id());
                ko.utils.arrayForEach(self.parent.comments(), function (comment) {
                    if (comment.id() != self.id())
                        if (comment.editMode())
                            comment.editMode(false);
                });
                self.parent.opened(false);
            };

            self.Edit = function () {
                var text = self.parent.getMessageText();
                $.post('/ajaxSimple/editComment/', {id: self.id(), text: text}, function (response) {
                    if (response.status) {
                        if (!self.parent.gallery()) {
                            self.parent.editor.redactor('destroy');
                            self.parent.editor = null;
                        }
                        self.editMode(false);
                        self.html(response.text);
                        self.editHtml(response.editHtml);
                    }
                }, 'json');
            };

            self.Remove = function () {
                $.post('/ajaxSimple/deleteComment/', {id: self.id()}, function (response) {
                    if (response.status) {
                        self.removed(1);
                        self.parent.allCount(self.parent.allCount() - 1);
                    }
                }, 'json');
            };

            self.Restore = function () {
                $.post('/ajaxSimple/restoreComment/', {id: self.id()}, function (response) {
                    if (response.status) {
                        self.removed(0);
                        self.parent.allCount(self.parent.allCount() + 1);
                    }
                }, 'json');
            };

            self.Reply = function () {
                if (userIsGuest)
                    $('a[href=#loginWidget]').trigger('click');
                else
                    self.parent.Reply(self);
            };

            self.Enter = function () {
                if (self.parent.enterSetting() || self.parent.gallery()) {
                    self.Edit();
                    return false;
                }
                return true;
            };

            self.openGallery = function() {
                var collection;
                var collectionOptions;

                switch(parent.entity()) {
                    case 'CommunityContent':
                    case 'BlogContent':
                        collection = 'PhotoPostPhotoCollection';
                        collectionOptions = { contentId : parent.entity_id };
                        break;
                    case 'Album':
                        collection = 'AlbumPhotoCollection';
                        collectionOptions = { albumId : parent.entity_id };
                        break;
                }

                PhotoCollectionViewWidget.open(collection, collectionOptions, self.photoId());
            }

            self.replyUserLink = function() {
                return '<a href="/user/' + self.author.id() + '/">' + self.author.fullName() + '</a>';
            }

            self.replyTreatmentHtml = function() {
                return '<p>' + self.replyUserLink() + ',&nbsp;</p>'
            }
        }
        window.NewComment = NewComment;

        function User(data) {
            var self = this;
            ko.mapping.fromJS(data, {}, self);

            self.fullName = ko.computed(function () {
                var fullName = self.firstName();
                if (self.lastName().length > 0)
                    fullName += ' ' + self.lastName();
                return fullName;
            }, this);

            self.avatarClass = ko.computed(function () {
                return self.gender() == 0 ? 'female' : 'male';
            }, this);
        }

        ko.bindingHandlers.enterKey = {
            init: function(element, valueAccessor, allBindings, vm) {
                ko.utils.registerEventHandler(element, "keypress", function(event) {
                    if (event.keyCode === 13) {
                        ko.utils.triggerEvent(element, "change");
                        valueAccessor().call(vm, vm);
                        if (ENTER_KEY_SEND)
                            return false;
                    }
                    return true;
                });
            }
        };
    }
    if (typeof define === 'function' && define['amd']) {
        define('ko_comments', ['knockout', 'knockout.mapping', 'ko_library'], f);
    } else {
        f(window.ko, window.ko.mapping);
    }
})(window);