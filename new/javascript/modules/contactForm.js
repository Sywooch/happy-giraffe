define('contactForm', ['jquery', 'knockout', 'models/Model', 'jquery_file_upload'], function($, ko, Model) {
   function ContactForm() {
       var self = this;
       self.SUBMIT_URL = '/api/pages/send/';

       self.message = ko.observable('');
       self.name = ko.observable('');
       self.companyName = ko.observable('');
       self.email = ko.observable('');
       self.phone = ko.observable('');
       self.loading = ko.observable(false);
       self.attach = ko.observable(false);
       self.sent = ko.observable(false);

       self.send = function() {
            self.loading(true);

           var attrs = {
               message: self.message(),
               name: self.name(),
               companyName: self.companyName(),
               email: self.email(),
               phone: self.phone()
           };

           if (self.attach() !== false) {
               attrs['attachId'] = self.attach().attachId;
           }

           Model.get(self.SUBMIT_URL, { attributes: attrs }).done(function() {
               self.message('');
               self.name('');
               self.companyName('');
               self.email('');
               self.phone('');
               self.attach(false);
               self.loading(false);
               self.sent(true);
           });
       };

       $('input[type=file]').fileupload({
           url: '/api/pages/createAttachment/',
           dataType: 'json',
           add: function(e, data) {
               data.submit();
           },
           done: function(e, data) {
               self.attach(new Attach(data.result.data));
           }
       });
   }

    function Attach(data) {
        var self = this;

        self.attachId = data.attachId;
        self.fileName = data.fileName;
    }

    return ContactForm;
});