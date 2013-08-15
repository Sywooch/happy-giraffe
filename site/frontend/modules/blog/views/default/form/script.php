<script type="text/javascript">
    ko.bindingHandlers.chosenRubric =
    {
        init: function(element, valueAccessor, allBindingsAccessor, viewModel, bindingContext)
        {
            $(element).addClass('chzn');
            $(element).chosen().ready(function(){
                $('.js-select-rubric').find('.chzn-drop').append('<div class="chzn-itx-simple_add" id="rubricAddForm"><div class="chzn-itx-simple_add-hold"> <input type="text" class="chzn-itx-simple_add-itx" placeholder="Добавить рубрику" data-bind="value: newRubricTitle, valueUpdate: \'keyup\'"> <a class="chzn-itx-simple_add-del" data-bind="visible: newRubricTitle().length > 0, click: clearNewRubricTitle"></a> </div> <button class="btn-green" data-bind="click: createRubric">Ok</button> </div>');
                ko.applyBindings(viewModel, document.getElementById('rubricAddForm'));
            });
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
</script>