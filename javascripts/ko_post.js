/** Repost ***/
(function(window) {
    function f(ko, mapping) {
        ko.bindingHandlers.chosenRubric =
        {
            init: function(element, valueAccessor, allBindingsAccessor, viewModel, bindingContext)
            {
                viewModel.rubricsList.unshift(new BlogRubric({ id : undefined, title : undefined }));
                $(element).addClass('chzn');
                $(element).chosen().ready(function(){
                    $('.js-select-rubric').find('.chzn-drop').append('<div class="chzn-itx-simple_add clearfix" id="rubricAddForm">' +
                            '<button class="btn-green" data-bind="click: createRubric">Ok</button> ' +
                            '<div class="chzn-itx-simple_add-hold"> ' +
                                '<input type="text" class="chzn-itx-simple_add-itx" placeholder="Создайте новую" data-bind="value: newRubricTitle, valueUpdate: \'keyup\'"> ' +
                                '<a class="chzn-itx-simple_add-del" data-bind="visible: newRubricTitle().length > 0, click: clearNewRubricTitle"></a> ' +
                            '</div> ' +
                        '</div>');
                    ko.applyBindings(viewModel, document.getElementById('rubricAddForm'));
                });
            },
            update: function(element, valueAccessor, allBindingsAccessor, viewModel, bindingContext)
            {
                $(element).trigger('liszt:updated');
            }
        };
        ko.bindingHandlers.chosenRubricClub =
        {
            init: function(element, valueAccessor, allBindingsAccessor, viewModel, bindingContext)
            {
                viewModel.rubricsList.unshift(new BlogRubric({ id : undefined, title : undefined }));
                $(element).addClass('chzn');
                $(element).chosen();
            },
            update: function(element, valueAccessor, allBindingsAccessor, viewModel, bindingContext)
            {
                $(element).trigger('liszt:updated');
            }
        };

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
            self.selectedRubric = ko.observable(data.selectedRubric === null ? (data.rubricsList.length > 1 ? undefined : data.rubricsList[0].id) : data.selectedRubric);

            self.clearNewRubricTitle = function() {
                self.newRubricTitle('');
            };

            self.createRubric = function() {
                $.post('/newblog/createRubric/', { title : self.newRubricTitle() }, function(response) {
                    if (response.success) {
                        self.rubricsList.push(new BlogRubric({ id : response.id, title : self.newRubricTitle() }));
                        self.selectedRubric(response.id);
                        self.newRubricTitle('');
                        $('body').click();
                    }
                }, 'json');
            };

            self.toggleDropdown = function() {
                self.showDropdown(! self.showDropdown());
            };

            self.selectedPrivacyOption = function() {
                return self.privacyOptions()[self.selectedPrivacyOptionIndex()];
            };
        };
        window.BlogFormViewModel = BlogFormViewModel;

        var BlogRubric = function(data, parent) {
            var self = this;
            self.id = data.id;
            self.title = data.title;
        };
        window.BlogRubric = BlogRubric;

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
        window.BlogPrivacyOption = BlogPrivacyOption;

        var Video = function(data, parent) {
            var self = this;
            self.link = ko.observable(data.link);
            self.embed = ko.observable(data.embed);
            self.previewLoading = ko.observable(false);
            self.previewError = ko.observable(false);

            self.check = function() {
                self.previewError(false);
                self.previewLoading(true);
                $.get('/newblog/videoPreview/', { url : self.link() }, function(response) {
                    self.previewLoading(false);
                    response.success ? self.embed(response.html) : self.previewError(true);
                }, 'json');
            };

            self.remove = function() {
                self.link('');
                self.embed(null);
            };
        };
        window.Video = Video;

        function RepostWidget(data) {
            var self = this;

            self.modelName = data.modelName;
            self.modelId = data.modelId;
            self.entity = data.entity;
            self.count = ko.observable(data.count);
            self.active = ko.observable(data.active);
            self.ownContent = ko.observable(data.ownContent);
            self.adding = ko.observable(null);

            self.clickHandler = function() {
                if (self.ownContent())
                    return;

                if (! self.active()) {
                    if (self.adding() === null) {
                        $.get('/favourites/default/getEntityData/', { modelName : self.modelName, modelId : self.modelId}, function(response) {
                            response.rubricsList = data.rubricsList;
                            self.adding(new Entity(response, self));

                            $('html').one('click', function() {
                                self.adding(null);
                            });

                            $(event.target).parents('.favorites-add-popup').one('click', function(event){
                                event.stopPropagation();
                            });

                            $(event.target).one('click', function(event){
                                event.stopPropagation();
                            });
                        }, 'json');
                    } else {
                        self.cancel();
                    }
                } else {
                    self.remove();
                }
            };

            self.add = function(data, event) {
                if (self.ownContent())
                    return;

                var el = $(event.target).parents('.favorites-control').find('.favorites-control_a');

                var data = {
                    'Repost[model_name]' : self.modelName,
                    'Repost[model_id]' : self.modelId,
                    'Repost[note]' : self.adding().note(),
                    'Repost[rubric_id]' : self.adding().selectedRubric()
                };

                $.post('/ajaxSimple/repostCreate/', data, function(response) {
                    if (response.success) {
                        self.adding(null);
                        self.active(true);
                    }
                }, 'json');
            };

            self.remove = function() {
                var data = {
                    modelName : self.modelName,
                    modelId : self.modelId
                };
                $.post('/ajaxSimple/repostDelete/', data, function(response) {
                    if (response.success) {
                        self.active(false);
                    }
                }, 'json');
            };

            self.cancel = function() {
                self.adding(null);
            };

            self.active.subscribe(function(val) {
                val ? self.count(self.count() + 1) : self.count(self.count() - 1);
            });
        }
        window.RepostWidget = RepostWidget;


        /**
         * Настройки записи в блог
         */
        function BlogRecordSettings(data) {
            var self = this;
            mapping.fromJS(data, {}, self);
            self.displayOptions = ko.observable(false);
            self.displayPrivacy = ko.observable(false);
            self.removed = ko.observable(false);

            self.attach = function(){
                $.post('/newblog/attachBlog/', {id: self.id()}, function (response) {
                    if (response.status) {
                        self.attached(!self.attached());
                    }
                }, 'json');
                self.displayOptions(false);
            };
            self.show = function(){
                self.displayOptions(!self.displayOptions());
            };
            self.showPrivacy = function(){
                self.displayPrivacy(!self.displayPrivacy());
            };
            self.privacyClass = ko.computed(function () {
                if (self.privacy() == 0)
                    return 'ico-users__all';
                else return 'ico-users__friend';
            });
            self.setPrivacy = function(privacy){
                $.post('/newblog/updatePrivacy/', {id: self.id(), privacy:privacy}, function (response) {
                    if (response.status) {
                        self.privacy(privacy);
                        self.displayPrivacy(false);
                    }
                }, 'json');

            };
            self.remove = function() {
                $.post('/newblog/remove/', { id : self.id() }, function(response) {
                    if (response.success)
                        self.removed(true);
                }, 'json');
            }
            self.restore = function() {
                $.post('/newblog/restore/', { id : self.id() }, function(response) {
                    if (response.success)
                        self.removed(false);
                }, 'json');
            }
        }
        window.BlogRecordSettings = BlogRecordSettings;

        function likeControlFixedInBlock(block, inBlock, blockIndent) {

            var block = $(block);
            var blockTop = block.offset().top;
            var blockHeight = block.outerHeight();
            /*
             var stopTop = $(elementStop).offset().top;
             var blockStopTop = stopTop - blockTop - blockHeight - blockIndent;
             */
            var inBlock = $(inBlock);
            var blockStopBottom = inBlock.offset().top + inBlock.outerHeight();

            if (blockStopBottom-blockTop-blockHeight-blockIndent > 20) {

                $(window).scroll(function() {
                    var windowScrollTop = $(window).scrollTop();
                    if (
                        windowScrollTop > blockTop-blockIndent &&
                            windowScrollTop + blockHeight < blockStopBottom - blockIndent
                        ) {
                        block.css({
                            'position': 'fixed',
                            'top'     : blockIndent+'px'
                        });
                    } else {

                        block.css({
                            'position': 'relative',
                            'top'     : 'auto'
                        });

                        if (windowScrollTop + blockHeight > blockStopBottom - blockIndent) {
                            block.css({
                                /* 92 - высота блока над едущими лайками */
                                'top'     : inBlock.outerHeight() - blockHeight - 92
                            });
                        }
                    }
                });
            }
        }
        window.likeControlFixedInBlock = likeControlFixedInBlock;

        function PhotoPostWidget() {
            var self = this;

            self.state = ko.observable(0);

            self.setState = function(state) {
                self.state(state);
            };
        }
        window.PhotoPostWidget = PhotoPostWidget;
    }
    if (typeof define === 'function' && define['amd']) {
        define('ko_post', ['knockout', 'knockout.mapping', 'baron', 'ko_favourites', 'ko_library'], f);
    } else {
        f(window.ko, window.ko.mapping);
    }
})(window);