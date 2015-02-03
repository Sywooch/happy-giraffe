define(['knockout', 'models/Model', 'user-config', 'extensions/knockout.validation', 'extensions/validatorRules', 'knockout.mapping'], function PresetManagerHandler(ko, Model, userConfig) {
    var User = {
        getUserUrl: '/api/users/get/',
        getCurrentUserUrl: '/api/users/getCurrentUser/',
        changePasswordUrl: '/api/users/changePassword/',
        changeLocationUrl: '/api/users/changeLocation/',
        changeEmailUrl: '/api/users/changeEmail/',
        removeUserUrl: '/api/users/remove/',
        updateUserUrl: '/api/users/update/',
        mailSubscriptionUrl: '/api/users/mailSubscription/',
        removeSocialServicesUrl: '/api/users/removeSocialService/',
        isGuest: userConfig.isGuest,
        isModer: userConfig.isModer,
        userId: userConfig.userId,
        socialServices: ['vkontakte', 'odnoklassniki'],
        /**
         * Полное имя
         * @returns {string}
         */
        fullName: function fullName() {
            return this.firstName + ' ' + this.lastName;
        },
        /**
         * parse pack
         * @param element
         * @returns {User}
         */
        parsePack: function parsePack(element) {
            if (element.success === true) {
                var userInst = Object.create(User);
                userInst.init(element.data);
                return userInst;
            }
        },
        /**
         * Get User
         * @param avatarSize
         * @returns {$.ajax}
         */
        get: function get(avatarSize) {
            return Model.get(this.getUserUrl, { id: this.userId, avatarSize: avatarSize });
        },
        /**
         * Get current user
         * @param avatarSize
         * @returns {$.ajax}
         */
        getCurrentUser: function getCurrentUser(avatarSize) {
            return Model.get(this.getCurrentUserUrl, { id: this.userId, avatarSize: avatarSize });
        },
        /**
         * Change users password
         * @returns {$.ajax}
         */
        changePassword: function changePassword() {
            return Model.get(this.changePasswordUrl, { id: this.id, password: this.password.value(), oldPassword: this.oldPassword.value() });
        },
        /**
         * Change users email
         * @returns {$.ajax}
         */
        changeEmail: function changeEmail() {
            return Model.get(this.changeEmailUrl, { id: this.id, email: this.email.value(), oldPassword: this.oldPassword.value() });
        },
        /**
         * Remove user
         * @returns {$.ajax}
         */
        remove: function remove() {
            return Model.get(this.removeUserUrl, { id: this.id });
        },
        /**
         * Update user attributes
         * @param attributes
         * @returns {$.ajax}
         */
        update: function update(attributes) {
            return Model.get(this.updateUserUrl, { id: this.id, attributes: attributes });
        },
        /**
         * Update date attribs
         * @param attributes
         * @returns {$.ajax}
         */
        updateDate: function updateDate(attributes) {
            return Model.get(this.updateUserUrl, { id: this.id, attributes: { birthday: this.birthday.year() + '-' + this.birthday.month() + '-' + this.birthday.day() } });
        },
        /**
         * Check rights
         * @param externalId
         * @returns {boolean}
         */
        checkRights: function checkRights(externalId) {
            if (this.userId !== null) {
                if (parseInt(this.userId) === parseInt(externalId)) {
                    return true;
                }
            }
            return false;
        },
        /**
         * Update user model
         * @param data
         */
        updateModel: function updateModel(data) {
            for (var prop in data) {
                if (prop === 'birthday') {
                    this.birthday.day = ko.observable((data.birthday !== undefined) ? new Date(data.birthday).getDate() : null);
                    this.birthday.month = ko.observable((data.birthday !== undefined) ? new Date(data.birthday).getMonth() + 1 : null);
                    this.birthday.year = ko.observable((data.birthday !== undefined) ? new Date(data.birthday).getFullYear() : null);
                    this.birthday.editing(false);
                } else {
                    if (this[prop] !== undefined) {
                        if (this[prop].value !== undefined) {
                            this[prop].value(data[prop]);
                            this[prop].editing(false);
                        } else {
                            if (ko.isObservable(this[prop])) {
                                this[prop](data[prop]);
                            } else {
                                this[prop] = data[prop];
                            }
                        }
                    }
                }
            }
        },
        /**
         * Error user handler
         * @param errorData
         */
        errorHandler: function errorHandler(errorData) {
            this.errors([]);
            if (errorData.success === false) {
                if (errorData.data.errors !== undefined) {
                    for (var errorType in errorData.data.errors) {
                        this[errorType].errors([]);
                        if (errorData.data.errors[errorType].length > 0) {
                            for (var errorI = 0; errorI < errorData.data.errors[errorType].length; errorI++) {
                                this[errorType].errors.push(errorData.data.errors[errorType][errorI]);
                            }
                        }
                    }
                }
            }
        },
        /**
         * Mail subscribe
         * @returns {$.ajax}
         */
        mailSubscribe: function mailSubscribe() {
            return Model.get(this.mailSubscriptionUrl, { id: this.id, value: (this.subscriptionMail.value() === false) ? 0 : 1 });
        },
        changeLocation: function changeLocation() {
            if (this.address.value().city().id() === null) {
                return Model.get(this.changeLocationUrl, { id: this.id, countryId: this.address.value().country().id() });
            }
            return Model.get(this.changeLocationUrl, { id: this.id, countryId: this.address.value().country().id(), cityId: this.address.value().city().id() });
        },
        /**
         * get birthday value
         * @returns {string}
         */
        getBirthdayValue: function getBirthdayValue() {
            var months,
                month;
            if (DateRange !== undefined) {
                months = DateRange.months();
                month = Model.findById(this.month(), months);
                return this.day() + ' ' + month.name.toLowerCase() + ' ' + this.year();
            }
            return this.day() + ' ' + this.month() + ' ' + this.year();
        },
        /**
         * parse social services
         * @param socialServices
         * @returns {{}}
         */
        parseSocialServices: function parseSocialServices(socialServices) {
            var socialObject = {};
            for (var serviceItem in this.socialServices) {
                if (socialServices[serviceItem] !== undefined) {
                    socialObject[this.socialServices[serviceItem]] = ko.observable(socialServices[serviceItem]);
                } else {
                    socialObject[this.socialServices[serviceItem]] = ko.observable(null);
                }
            }
            return socialObject;
        },
        removeSocial: function removeSocial(data, event) {
            this.socialServices.value()[data.service](null);
            return Model.get(this.removeSocialServicesUrl, { id: data.id });
        },
        /**
         * handling request
         * @param userData
         */
        handlingRequest: function handlingRequest(userData) {
            this.errorHandler(userData);
        },
        /**
         * update gender
         */
        updateGender: function updateGender() {
            this.update({ gender: parseInt(this.gender.value()) }).done(this.handlingRequest.bind(this));
        },
        /**
         * update subscription
         */
        updateSubscribtion: function updateSubscribtion() {
            this.mailSubscribe().done(this.handlingRequest.bind(this));
        },
        /**
         * return address
         * @returns {string}
         */
        returnAddress: function returnAddress() {
            var addressString = '';
            if (this.address.value().country() !== null) {
                addressString += this.address.value().country().name();
            }
            if (this.address.value().city().id() !== null) {
                if (this.address.value().city().name) {
                    addressString += ', ' + this.address.value().city().name();
                }
            }
            return addressString;
        },
        /**
         * init юзера
         * @param object
         * @returns {User}
         */
        init: function init(object) {
            if (object !== undefined) {
                this.avatarId = object.avatarId;
                this.avatarUrl = object.avatarUrl;
                this.firstName = object.firstName;
                this.gender = object.gender;
                this.id = object.id;
                this.isOnline = object.isOnline;
                this.lastName = object.lastName;
                this.birthday = object.birthday;
                this.profileUrl = object.profileUrl;
                this.publicChannel = object.publicChannel;
                this.email = object.email;
                this.subscriptionMail = object.subscription;
                this.fullName = this.fullName();
                return this;
            }
        },
        /**
         * settle properties for settings manipulation
         * @param object
         * @returns {User}
         */
        settleSettings: function settleSettings(object) {
            if (object !== undefined) {
                this.id = object.id;
                this.profileUrl = object.profileUrl;
                this.publicChannel = object.publicChannel;
                this.isOnline = object.isOnline;
                this.firstName = Model.createStdProperty(object.firstName, 'first_name');
                this.lastName = Model.createStdProperty(object.lastName, 'last_name');
                this.birthday = Model.createStdProperty(object.birthday, 'birthday');
                this.email = Model.createStdProperty(object.email, 'email');
                this.socialServices = Model.createStdProperty(this.parseSocialServices(object.socialServices), 'socialServices');
                this.address = Model.createStdProperty(ko.mapping.fromJS(object.address, {}), 'address');
                this.address.value().country = ko.observable(this.address.value().country);
                if (!ko.isObservable(this.address.value().city)) {
                    this.address.value().city = ko.observable(this.address.value().city);
                } else {
                    this.address.value().city({ id: ko.observable(null), name: ko.observable(null) });
                }
                this.countryId = ko.observable(this.address.value().country().id());
                this.fullGeography = ko.computed(this.returnAddress, this);
                this.birthday.day = ko.observable((object.birthday !== undefined) ? new Date(object.birthday).getDate() : null);
                this.birthday.month = ko.observable((object.birthday !== undefined) ? new Date(object.birthday).getMonth() + 1 : null);
                this.birthday.year = ko.observable((object.birthday !== undefined) ? new Date(object.birthday).getFullYear() : null);
                this.birthday.value = ko.computed(this.getBirthdayValue, this.birthday);
                this.password = Model.createStdProperty('', 'password');
                this.oldPassword = Model.createStdProperty('', 'oldPassword');
                this.errors = ko.observableArray();
                this.gender = Model.createStdProperty(object.gender.toString(), 'gender');
                this.gender.value.subscribe(this.updateGender, this);
                this.subscriptionMail = Model.createStdProperty((object.subscription === 1) ? true : false, 'subscriptionMail');
                /**
                 * Susbscribtion
                 */
                this.subscriptionMail.value.subscribe(this.updateSubscribtion, this);
                /***
                 * Validation
                 */
                this.firstName.value.extend({ mustFill: true });
                this.lastName.value.extend({ mustFill: true });
                this.birthday.day.extend({ dateMustFill: true });
                this.birthday.month.extend({ dateMustFill: true });
                this.birthday.year.extend({ dateMustFill: true });
                this.email.value.extend({ mustFill: true });
                return this;
            }
        }
    };
    return User;
});