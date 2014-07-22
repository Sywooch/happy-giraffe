define('fast-message', ['knockout', 'text!messaging/fast-message.tmpl.html', 'ko_library', 'common', 'wysiwyg', 'ko_messaging'], function(ko, template) {
    var $template = $(template);
    function MessagingFastMessage(data) {
        var self = this;
        self.currentThread = function() { return false; };
        self.user = new MessagingUser(self, data);
        // Текст нового сообщения
        self.editor = ko.observable('');
        // Изображения
        self.uploadedImages = ko.observableArray([]);
        // состояния
        self.isSuccess = ko.observable(false);
        self.sendingMessage = ko.observable(false);
        self.settings = new MessagingSettings(data.settings);
        self.sendMessage = function(from) {
            self.sendingMessage(true);
            var data = {};
            data.interlocutorId = self.user.id;
            data.text = self.editor();
            //data.images = self.uploadedImagesIds();

            $.post('/messaging/messages/send/', data, function(response) {
                self.sendingMessage(false);

                if (response.success) {
                    self.isSuccess(true);
                    self.editor('');
                    self.uploadedImages([]);
                } else {
                    //
                }
            }, 'json');
        };
        self.addImage = function(data) {
            self.uploadedImages.push(new MessagingImage(data));
        };

        self.removeImage = function(image) {
            self.uploadedImages.remove(image);
        };

        self.uploadedImagesIds = ko.computed(function() {
            return ko.utils.arrayMap(self.uploadedImages(), function(image) {
                return image.id();
            })
        });

        self.editorConfig = {
            minHeight: 65,
            plugins: ['smilesModal'],
            newStyle: true,
            callbacks: {
                keydown : [
                    function(e) {
                        if (e.keyCode == 13 && self.settings.messaging__enter() != e.ctrlKey) {
                            self.sendMessage();
                            e.preventDefault();
                        }
                    }
                ]
            }
        };
    }
    $(document).magnificPopup({
        delegate: '[data-fast-message-for]',
        type: 'ajax',
        callbacks: {
            elementParse: function(item) {
                this.st.ajax.settings = {
                    dataType: 'json',
                    data: {
                        id: item.el.data('fastMessageFor')
                    },
                    url: '/messaging/default/getUserInfo/'
                };
            },
            parseAjax: function(mfpResponse) {
                var data = mfpResponse.data;
                this.model = new MessagingFastMessage(data);
                mfpResponse.data = $template.clone();
                mfpResponse.data.find('[data-baron-v], [data-baron-h]').attr({
                    'data-baron-v': null,
                    'data-baron-h': null
                });
            },
            ajaxContentAdded: function() {
                ko.applyBindings(this.model, this.content.get(0));
            }
        }
    });
    
    return {};
});