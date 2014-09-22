function VacancyViewModel() {
    var self = this;

    self.cv = ko.observable(null);

    self.clearCv = function() {
        self.cv(null);
    }

    self.cvValue = ko.computed(function() {
        return self.cv() === null ? '' : self.cv().url();
    });

    self.loading = ko.observable(false);

    $('input[type=file]').fileupload({
        url: '/vacancy/upload/',
        dataType: 'json',
        add: function(e, data) {
            self.loading(true);
            data.submit();
        },
        done: function(e, data) {
            self.cv(new Cv(data.result));
            self.loading(false);
        }
    });
}

function Cv(data) {
    var self = this;
    self.name = ko.observable(data.name);
    self.url = ko.observable(data.url);
}

function afterValidateVacancy(form, data, hasError) {
    if (! hasError) {
        $.post(form.attr('action'), form.serialize(), function(response) {
            if (response.success) {
                $('.vacancy_send').removeClass('display-n');
                $('.f-about').addClass('display-n');
            }
            $(form).find('button').removeAttr('disabled');
        }, 'json');
    } else {
        $(form).find('button').removeAttr('disabled');
    }
    return false;
}

function beforeValidateVacancy(form) {
    $(form).find('button').attr('disabled', 'disabled');
    return true;
}