function RegisterWidgetViewModel(data, form) {
    var self = this;

    for (var i in data.constants)
        self[i] = data.constants[i];

    self.social = ko.observable(false);
    self.currentStep = ko.observable(self.STEP_REG1);
    self.saving = ko.observable(false);

    self.id = ko.observable();
    self.email = new RegisterUserAttribute('');
    self.first_name = new RegisterUserAttribute('');
    self.last_name = new RegisterUserAttribute('');
    self.country = ko.observable('');
    self.city = ko.observable('');
    self.birthday_year = new RegisterUserAttribute('');
    self.birthday_month = new RegisterUserAttribute('');
    self.birthday_day = new RegisterUserAttribute('');
    self.gender = new RegisterUserAttribute('');

    self.uid = ko.observable('');
    self.socialServiceName = ko.observable('');

    self.daysRange = DateRange.days();
    self.monthesRange = DateRange.months();
    self.yearsRange = DateRange.years(data.minYear, data.maxYear);

    self.avatar = new UserAvatar(self);
    self.location = new UserLocation(data.countries);

    self.resend = function() {
        self.currentStep(self.STEP_EMAIL2);
    }

    self.uploadPhoto = function() {
        self.avatar.buffer();
        self.currentStep(self.STEP_PHOTO);
    }

    self.saveAvatar = function() {
        self.currentStep(self.STEP_REG2);
    }

    self.cancelAvatar = function() {
        self.avatar.cancel();
        self.currentStep(self.STEP_REG2);
    }

    self.open = function() {
        $('a[href="#registerWidget"]:first').trigger('click');
    }

    self.setAttributes = function(attributes) {
        for (var i in attributes) {
            var attrVal = attributes[i];
            if (self[i] instanceof RegisterUserAttribute)
                self[i].val(attrVal);
            else
                self[i](attrVal);
        }
    }

    self.availableMailServices = ko.utils.arrayMap(data.mailServices, function(mailService) {
        return new MailService(mailService);
    });
    self.currentMailService = ko.computed(function() {
        var emailParts = self.email.val().split('@');
        if (emailParts.length != 2)
            return null;

        var domain = emailParts[1];
        for (var i in self.availableMailServices) {
            if (self.availableMailServices[i].domains.indexOf(domain) != -1)
                return self.availableMailServices[i];
        }
        return null;
    });

    // для регистрации через вопрос специалисту
    if (data.newUser !== null) {
        self.setAttributes(data.newUser);
        self.currentStep(self.STEP_REG2);
        $(function() {
            self.open();
        });
    }
}

function UserLocation(countries) {
    var self = this;

    //опции страны для select2
    self.countrySettings = {
        width: '100%',
        minimumResultsForSearch: -1,
        dropdownCssClass: 'select2-drop__search-off select2-drop__separated-first-items',
        escapeMarkup: function(m) { return m; },
        placeholder: 'Выберите страну'
    }

    //опции города для select2
    self.citySettings = {
        //minimumInputLength: 2,
        width: '100%',
        dropdownCssClass: 'select2-drop__search-on',
        escapeMarkup: function(m) { return m; },
        formatNoMatches: function () { return "Город не найден"; },
        ajax: {
            url : '/geo/default/searchCities/',
            dataType: 'json',
            data: function (term, page) {
                return {
                    term: term,
                    pageLimit: 10,
                    page: page,
                    country_id: self.country_id()
                };
            },
            results: function (data, page) {
                var results = [];
                for (var i in data.cities) {
                    var city = data.cities[i];

                    var name = city.name;
                    if (city.type)
                        name += ' ' + city.type + '.';
                    var desc = city.region.name;
                    if (city.district)
                        desc += ', ' + city.district.name + ' р-н';

                    results.push({
                        id : city.id,
                        text : name,
                        desc : desc
                    });
                }
                return { results : results, more : data.more };
            }
        },
        formatResult: function(city, container, query, escapeMarkup) {
            var markup = [];
            window.Select2.util.markMatch(city.text, query.term, markup, escapeMarkup);
            return '<div class="select2-result_i">' + markup.join('') +  '</div>' + '<div class="select2-result_desc">' + city.desc + '</div>';
        },
        searchInputPlaceholder: "Введите название",
        placeholder: 'Выберите город'
    }

    self.city_name = ko.observable('');
    self.city_id = ko.observable(null);
    self.country_id = ko.observable(null);
    self.availableCountries = ko.utils.arrayMap(countries, function (item) {
        return new Country(item);
    });

    self.country = ko.computed(function() {
        if (self.country_id() === null)
            return null;

        return ko.utils.arrayFirst(self.availableCountries, function(country) {
            return country.id == self.country_id();
        });
    });

    self.country_id.subscribe(function() {
        self.city_id(null);
    });

    $('#RegisterFormStep2_city_id').on('select2-open', function() {
        $('#RegisterFormStep2_city_id').data('select2').search.val(self.city_name());
        $('#RegisterFormStep2_city_id').data('select2').search.trigger('input');
    });
}

function Country(data) {
    this.id = data.id;
    this.name = data.name;
    this.code = data.code;
    this.citiesFilled = data.citiesFilled;
};

function UserAvatar(parent) {
    var self = this;

    self.imgSrc = ko.observable('');
    self.coords = ko.observable(null);

    self.bufferImgSrc = ko.observable('');
    self.bufferCoords = ko.observable(null);

    self.showPreview = function(coords) {
        var image = new Image();
        image.src = self.imgSrc();
        self.coords(coords);

        var sizes = [24, 40, 72, 200];
        for (var i in sizes) {
            var size = sizes[i];
            var rx = size / coords.w;
            var ry = size / coords.h;

            $('.preview-' + size).css({
                width: Math.round(rx * image.width) + 'px',
                height: Math.round(ry * image.height) + 'px',
                marginLeft: '-' + Math.round(rx * coords.x) + 'px',
                marginTop: '-' + Math.round(ry * coords.y) + 'px'
            });
        }
    }

    self.jcrop = {
        options : {
            aspectRatio: 1,
            bgOpacity: 0.6,
            bgColor: '#2c87c0',
            addClass: 'jcrop-blue',
            onChange: self.showPreview,
            onSelect: self.showPreview,
            boxWidth: 500,
            bgFade: true
        },
        ready : function() {
            var image = new Image();
            image.src = self.imgSrc();
            var x = image.width / 2 - 200 / 2;
            var y = image.height/ 2 - 200 / 2;
            var x2 = x + 200;
            var y2 = y + 200;
            this.setSelect([x, y, x2, y2]);
        }
    }

    self.buffer = function() {
        self.bufferCoords(self.coords());
        self.bufferImgSrc(self.imgSrc());
    }

    self.cancel = function() {
        self.coords(self.bufferCoords());
        self.imgSrc(self.bufferImgSrc());
    }

    self.isChanged = ko.computed(function() {
        return (self.coords() != self.bufferCoords()) || (self.imgSrc() != self.bufferImgSrc());
    });

    self.clear = function() {
        self.imgSrc('');
    }

    $('#AvatarUploadForm_image').fileupload({
        dataType: 'json',
        url: '/signup/register/avatarUpload/',
        dropZone: $('.img-upload_hold'),
        add: function (e, data) {
            data.submit();
            $('.img-upload').addClass('img-upload__load');
        },
        done: function (e, data) {
            self.imgSrc(data.result.imgSrc);
            $('.img-upload').removeClass('img-upload__load');
        },
        progressall: function (e, data) {
            var progress = parseInt(data.loaded / data.total * 100, 10);
            $('.img-upload_i-load-progress').css(
                'width',
                progress + '%'
            );
        }
    });
}

function MailService(data)
{
    var self = this;
    self.name = data.name;
    self.url = data.url;
    self.domains = data.domains;
}

function RegisterUserAttribute(value)
{
    var self = this;
    self.val = ko.observable(value);
    self.show = ko.observable(true);
}

function LoginWidgetViewModel() {
    var self = this;

    self.email = ko.observable();
    self.password = ko.observable();
    self.rememberMe = ko.observable();

    self.open = function() {
        $('a[href="#loginWidget"]:first').trigger('click');
    }

    self.recover = function() {
        $('#LoginForm_email').trigger('change');
        passwordRecoveryVm.email(self.email());
        return false;
    }
}

function PasswordRecoveryWidgetViewModel() {
    var self = this;

    self.email = ko.observable();
    self.isSent = ko.observable(false);

    self.login = function() {
        loginVm.email(self.email());
        return false;
    }
}