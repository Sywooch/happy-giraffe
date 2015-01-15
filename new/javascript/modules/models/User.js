define(['knockout', 'models/Model', 'user-config'], function PresetManagerHandler(ko, Model, userConfig) {
    var User = {
        getUserUrl: '/api/users/get/',
        getCurrentUserUrl: '/api/users/getCurrentUser/',
        changePasswordUrl: '/api/users/changePassword/',
        changeEmailUrl: '/api/users/changeEmail/',
        removeUserUrl: '/api/users/remove/',
        updateUserUrl: '/api/users/update/',
        mailSubscriptionUrl: '/api/users/mailSubscription/',
        isGuest: userConfig.isGuest,
        isModer: userConfig.isModer,
        userId: userConfig.userId,
        /**
         * Полное имя
         * @returns {string}
         */
        fullName: function fullName() {
            return this.firstName + ' ' + this.lastName;
        },
        parsePack: function parsePack(element) {
            if (element.success === true) {
                var userInst = Object.create(User);
                userInst.init(element.data);
                return userInst;
            }
        },
        get: function get(avatarSize) {
            return Model.get(this.getUserUrl, { id: this.userId, avatarSize: avatarSize });
        },
        getCurrentUser: function getCurrentUser(avatarSize) {
            return Model.get(this.getCurrentUserUrl, { id: this.userId, avatarSize: avatarSize });
        },
        changePassword: function changePassword(newPassword) {
            return Model.get(this.changePasswordUrl, { id: this.id, password: newPassword });
        },
        changeEmail: function changeEmail() {
            return Model.get(this.changeEmailUrl, { id: this.id });
        },
        remove: function remove() {
            return Model.get(this.removeUserUrl, { id: this.id });
        },
        update: function update(attributes) {
            return Model.get(this.updateUserUrl, { id: this.id, attributes: attributes });
        },
        updateModel: function updateModel (data) {
            for (var prop in data) {
                if (prop === 'birthday') {
                    this.birthday.day = ko.observable((data.birthday !== undefined) ? new Date(data.birthday).getDate() : null);
                    this.birthday.month = ko.observable((data.birthday !== undefined) ? new Date(data.birthday).getMonth() + 1 : null);
                    this.birthday.year = ko.observable((data.birthday !== undefined) ? new Date(data.birthday).getFullYear() : null);
                    this.birthday.editing(false);
                } else {
                    if (this[prop] !== undefined) {
                        if (this[prop].value !== undefined) {
                            if (prop === 'gender' && this[prop].value() === null) {
                                data[prop] = 'null';
                            }
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
        mailSubscribe: function mailSubscribe() {
            return Model.get(this.mailSubscriptionUrl, { id: this.id, value: this.subscriptionMail });
        },
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
        parseSocialServices: function parseSocialServices(socialServices) {
            var socialObject = {};
            if (socialServices.length > 0) {
                for (var service in socialServices) {
                    socialObject[socialServices[service].service] = socialServices[service];
                }
            }
            return socialObject;
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

                this.subscriptionMail = object.subscriptionMail;

                this.fullName = this.fullName();

                return this;
            }
        },
        settleSettings: function settleSettings(object) {
            if (object !== undefined) {
                this.id = object.id;
                this.profileUrl = object.profileUrl;
                this.publicChannel = object.publicChannel;
                this.isOnline = object.isOnline;
                this.firstName = Model.createStdProperty(object.firstName, 'first_name');
                this.gender = Model.createStdProperty(object.gender, 'gender');
                this.lastName = Model.createStdProperty(object.lastName, 'last_name');
                this.birthday = Model.createStdProperty(object.birthday), 'birthday';
                this.email = Model.createStdProperty(object.email, 'email');
                this.subscriptionMail = Model.createStdProperty(object.subscriptionMail, 'subscriptionMail');
                this.socialServices = Model.createStdProperty(this.parseSocialServices(object.socialServices), 'socialServices');
                this.address = Model.createStdProperty(object.address, 'address');
                this.birthday.day = ko.observable((object.birthday !== undefined) ? new Date(object.birthday).getDate() : null);
                this.birthday.month = ko.observable((object.birthday !== undefined) ? new Date(object.birthday).getMonth() + 1 : null);
                this.birthday.year = ko.observable((object.birthday !== undefined) ? new Date(object.birthday).getFullYear() : null);
                this.birthday.value = ko.computed(this.getBirthdayValue, this.birthday);
                this.newPassword = Model.createStdProperty('', 'password');
                return this;
            }
        }
    };
    return User;
});