(function(window) {
    function f(ko) {
        ko.bindingHandlers.length = {
            update: function(element, valueAccessor, allBindingsAccessor, viewModel, bindingContext) {
                var currentLength = valueAccessor().attribute().length;
                var maxLength = valueAccessor().maxLength;
                $(element).text(currentLength + '/' + maxLength);
            }
        };

        BlogViewModel = function(data) {
            var self = this;

            self.authorId = data.authorId;

            // title
            self.title = ko.observable(data.title);
            self.draftTitleValue = ko.observable(data.title);
            self.draftTitle = ko.observable(data.title);

            self.setTitle = function() {
                self.draftTitle(self.draftTitleValue());
            }

            self.titleHandler = function(data, event) {
                if (event.which == 13)
                    self.setTitle()
                else
                    return true;
            }

            // description
            self.description = ko.observable(data.description);
            self.draftDescriptionValue = ko.observable(data.description);
            self.draftDescription = ko. observable(data.description);

            self.descriptionToShow = ko.computed(function() {
                return self.description().replace(/\n/g, '<br />');
            });

            self.draftDescriptionToShow = ko.computed(function() {
                return self.draftDescription().replace(/\n/g, '<br />');
            });

            self.setDescription = function() {
                self.draftDescription(self.draftDescriptionValue());
            }

            // photo
            self.uploadingPhoto = ko.observable(false);
            self.jcrop = null;
            self._progress = ko.observable(0);
            self.photoThumbSrc = ko.observable(data.photo === null ? null : data.photo.thumbSrc);
            self.draftPhoto = ko.observable(data.photo === null ? null : new Photo(data.photo));

            self.progress = ko.computed(function () {
                return self._progress() + '%';
            });

            self.photoThumbSrcToShow = ko.computed(function() {
                return self.photoThumbSrc() + '?t=' + Math.floor(Math.random() * (1000000 - 1) + 1);
            });

            // rubrics
            self.showRubrics = ko.observable(data.showRubrics);
            self.showRubricsValue = ko.observable(data.showRubrics);
            self.currentRubricId = data.currentRubricId;
            self.rubrics = ko.observableArray(ko.utils.arrayMap(data.rubrics, function(rubric) {
                return new Rubric(rubric, self);
            }));

            self.addRubric = function() {
                self.rubrics.push(new Rubric({ id : null, title : '', beingEdited : true }, self));
            }

            self.updateRubrics = function() {
                var data = { userId : self.authorId };
                if (self.currentRubricId !== null)
                    data.currentRubricId = self.currentRubricId;
                $.get('/blog/default/rubricsList/', data, function(response) {
                    $('#rubricsList').html(response);
                });
            }

            self.rubricsUpdateData = function() {
                var data = {
                    toRename: {},
                    toRemove: [],
                    toCreate: []
                };
                ko.utils.arrayForEach(self.rubrics(), function(rubric) {
                    if (rubric.isRenamed() && ! rubric.isRemoved())
                        data.toRename[rubric.id()] = rubric.title();
                    if (rubric.isRemoved())
                        data.toRemove.push(rubric.id());
                    if (rubric.id() === null)
                        data.toCreate.push(rubric.title());
                });
                return data;
            }

            self.applyRubricsUpdate = function(createdRubricsIds) {
                var i = 0;
                ko.utils.arrayForEach(self.rubrics(), function(rubric) {
                    if (rubric.isRenamed())
                        rubric.isRenamed(false);
                    if (rubric.id() === null)
                        rubric.id(createdRubricsIds[i++]);
                });
                self.rubrics.remove(function(rubric) {
                    return rubric.isRemoved();
                });
            }

            self.save = function() {
                var rubricsUpdateData = self.rubricsUpdateData();
                var data = {
                    blog_title: self.draftTitle(),
                    blog_description: self.draftDescription(),
                    blog_show_rubrics: self.showRubricsValue(),
                    rubricsToRename: rubricsUpdateData.toRename,
                    rubricsToRemove: rubricsUpdateData.toRemove,
                    rubricsToCreate: rubricsUpdateData.toCreate
                };
                if (self.draftPhoto() !== null)
                    data.blog_photo = {
                        id : self.draftPhoto().id(),
                        position : self.draftPhoto().position()
                    };
                $.post('/blog/settings/update/', data, function(response) {
                    if (response.success) {
                        self.title(self.draftTitle());
                        self.description(self.draftDescription());
                        self.showRubrics(self.showRubricsValue());
                        self.photoThumbSrc((self.draftPhoto() !== null) ? response.thumbSrc : null);
                        self.applyRubricsUpdate(response.createdRubricsIds);
                        $.fancybox.close();
                        self.updateRubrics();
                    }
                }, 'json');
            }

            self.removeDraftPhoto = function() {
                self.draftPhoto(null);
            }

            self.showPreview = function(coords) {
                self.draftPhoto().position(coords);

                var rx = 720 / coords.w;
                var ry = 128 / coords.h;

                $('#preview').css({
                    width: Math.round(rx * self.draftPhoto().width()) + 'px',
                    height: Math.round(ry * self.draftPhoto().height()) + 'px',
                    marginLeft: '-' + Math.round(rx * coords.x) + 'px',
                    marginTop: '-' + Math.round(ry * coords.y) + 'px'
                });
            };

            self.initSettings = function() {
                $.each($('.b-add-img'), function () {
                    $(this)[0].ondragover = function () {
                        $('.b-add-img').addClass('dragover')
                    };
                    $(this)[0].ondragleave = function () {
                        $('.b-add-img').removeClass('dragover')
                    };
                });

                $('#popup-blog-set .popup-blog-set_jcrop-img').Jcrop({
                    onChange: self.showPreview,
                    onSelect: self.showPreview,
                    aspectRatio: 720 / 128,
                    boxWidth: 440
                }, function(){
                    self.jcrop = this;
                    if (self.draftPhoto() !== null)
                        self.jcrop.setSelect([ self.draftPhoto().position().x, self.draftPhoto().position().y, self.draftPhoto().position().x2, self.draftPhoto().position().y2 ]);
                });

                $('#popup-blog-set .js-upload-files-multiple').fileupload({
                    dataType: 'json',
                    url: '/blog/settings/uploadPhoto/',
                    dropZone: $('#popup-blog-set .b-add-img__for-single'),
                    add: function (e, data) {
                        self.uploadingPhoto(true);
                        data.submit();
                    },
                    done: function (e, data) {
                        self.complete(data.result);
                    }
                });

                $('#popup-blog-set .js-upload-files-multiple').bind('fileuploadprogress', function (e, data) {
                    self._progress(data.loaded * 100 / data.total);
                });
            }

            self.complete = function(response) {
                self.draftPhoto(new Photo(response));
                self.jcrop.setImage(self.draftPhoto().originalSrc(), function() {
                    var x = self.draftPhoto().width()/2 - 720/2;
                    var y = self.draftPhoto().height()/2 - 128/2;
                    var x2 = x + 720;
                    var y2 = y + 128;

                    self.jcrop.setSelect([ x, y, x2, y2 ]);
                    self.uploadingPhoto(false);
                });
            }

        //    self.initJcrop = function() {
        //        if (self.draftPhoto() !== null) {
        //            $('.popup-blog-set_jcrop-img').Jcrop({
        //                setSelect: [ self.draftPhoto().position().x, self.draftPhoto().position().y, self.draftPhoto().position().x2, self.draftPhoto().position().y2 ],
        //                onChange: self.showPreview,
        //                onSelect: self.showPreview,
        //                aspectRatio: 720 / 128,
        //                boxWidth: 440
        //            }, function(){
        //                self.jcrop = this;
        //            });
        //        }
        //
        //        $('#upload-target').on('load', function() {
        //            var response = $(this).contents().find('#response').text();
        //            if (response.length > 0) {
        //                self.draftPhoto(new Photo($.parseJSON(response)));
        //                if (self.jcrop === null) {
        //                    var x = self.draftPhoto().width()/2 - 720/2;
        //                    var y = self.draftPhoto().height()/2 - 128/2;
        //                    var x2 = x + 720;
        //                    var y2 = y + 128;
        //                    $('.popup-blog-set_jcrop-img').Jcrop({
        //                        setSelect: [ x, y, x2, y2 ],
        //                        onChange: self.showPreview,
        //                        onSelect: self.showPreview,
        //                        aspectRatio: 720 / 128,
        //                        boxWidth: 440
        //                    }, function(){
        //                        self.jcrop = this;
        //                    });
        //                } else {
        //                    $('.popup-blog-set_jcrop-img').Jcrop({
        //                        setSelect: [ x, y, x2, y2 ],
        //                        onChange: self.showPreview,
        //                        onSelect: self.showPreview,
        //                        aspectRatio: 720 / 128,
        //                        boxWidth: 440
        //                    }, function(){
        //                        self.jcrop = this;
        //                    });
        //
        //                }
        //            }
        //        });
        //    };
        }
        window.BlogViewModel = BlogViewModel;

        Photo = function(data) {
            var self = this;
            self.id = ko.observable(data.id);
            self.originalSrc = ko.observable(data.originalSrc);
            self.thumbSrc = ko.observable(data.thumbSrc);
            self.width = ko.observable(data.width);
            self.height = ko.observable(data.height);
            self.position = ko.observable(data.position);
        }
        window.Photo = Photo;

        Rubric = function(data, parent) {
            var self = this;
            self.id = ko.observable(data.id);
            self.title = ko.observable(data.title);
            self.editedTitle = ko.observable(data.title);
            self.beingEdited = ko.observable((typeof data.beingEdited === 'undefinded') ? false : data.beingEdited);
            self.isRenamed = ko.observable(false);
            self.isRemoved = ko.observable(false);

            self.titleHandler = function(data, event) {
                if (event.which == 13)
                    self.save();
                else
                    return true;
            }

            self.edit = function() {
                self.beingEdited(true);
            }

            self.save = function() {
                self.title(self.editedTitle());
                self.beingEdited(false);
                if (self.id() !== null)
                    self.isRenamed(true);
            }

            self.remove = function() {
                self.id() === null ? parent.rubrics.remove(self) : self.isRemoved(true);
            }

            self.restore = function() {
                self.isRemoved(false);
            }
        }
        window.Rubric = Rubric;

        function BlogSubscription(subscriptionData) {
            var self = this;

            self.subscribed = ko.observable(subscriptionData['subscribed']);
            self.count = ko.observable(subscriptionData['count']);
            self.user_id = ko.observable(subscriptionData['user_id']);

            self.toggleSubscription = function () {
                if (userIsGuest)
                    $('a[href=#login]').trigger('click');
                else
                    $.post('/newblog/subscribeToggle/', {user_id: self.user_id()}, function (response) {
                        if (response.status) {
                            if (self.subscribed()) {
                                self.subscribed(false);
                                self.count(self.count() - 1);
                            } else {
                                self.subscribed(true);
                                self.count(self.count() + 1);
                            }
                        }
                    }, 'json');
            };
            self.isSubscribed = ko.computed(function () {
                return self.subscribed();
            });
        }
        window.BlogSubscription = BlogSubscription;
    }
    if (typeof define === 'function' && define['amd']) {
        define('ko_blog', ['knockout', 'common', 'jcrop', 'ko_upload', 'ko_library'], f);
    } else {
        f(window.ko);
    }
})(window);