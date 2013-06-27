<?php $this->renderPartial('form/' . $type, compact('model', 'slaveModel')); ?>

<script type="text/javascript">
    $('.wysiwyg-redactor-v').redactor({

        minHeight: 450,
        autoresize: true,
        /* В базовом варианте нет кнопок 'h2', 'h3', 'link_add', 'link_del' но их функции реализованы с помощью выпадающих списков */
        buttons: ['bold', 'italic', 'underline', 'deleted', 'h2', 'h3', 'unorderedlist', 'orderedlist', 'link_add', 'link_del', 'image', 'video', 'smile'],
        buttonsCustom: {
            smile: {
                title: 'smile',
                callback: function(buttonName, buttonDOM, buttonObject) {
                    // your code, for example - getting code
                    var html = this.get();
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

    var BlogFormViewModel = function() {
        var self = this;
        self.title = ko.observable('');
        self.privacyOptions = ko.observableArray([new BlogPrivacyOption({ value : 0, title : 'для <br>всех', cssClass : 'all' }, self), new BlogPrivacyOption({ value : 1, title : 'только <br>друзьям', cssClass : 'friends' }, self)]);
        self.selectedPrivacyOptionIndex = ko.observable(0);
        self.showDropdown = ko.observable(false);

        self.toggleDropdown = function() {
            self.showDropdown(! self.showDropdown());
        }

        self.selectedPrivacyOption = function() {
            return self.privacyOptions()[self.selectedPrivacyOptionIndex()];
        }
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
    }

    var formVM = new BlogFormViewModel();
    ko.applyBindings(formVM, document.getElementById('popup-user-add-article'));
</script>