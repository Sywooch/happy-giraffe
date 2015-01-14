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
        update: function update() {
            return Model.get(this.updateUserUrl, { first_name: this.firstName, last_name: this.lastName, gender: this.gender, birthday: this.birthday });
        },
        mailSubscribe: function mailSubscribe() {
            return Model.get(this.mailSubscriptionUrl, { id: this.id, value: this.subscriptionMail });
        },
        getBirthdayValue: function getBirthdayValue() {
            return this.year() + '-' +  this.month() + '-' + this.day();
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
                this.firstName = Model.createStdProperty(object.firstName, 'firstName');
                this.gender = Model.createStdProperty(object.gender, 'gender');
                this.lastName = Model.createStdProperty(object.lastName, 'lastName');
                this.birthday = Model.createStdProperty(object.birthday), 'birthday';
                this.email = Model.createStdProperty(object.email, 'email');
                this.subscriptionMail = Model.createStdProperty(object.subscriptionMail, 'subscriptionMail');
                this.socialServices = Model.createStdProperty(this.parseSocialServices(object.socialServices), 'socialServices');
                this.address = Model.createStdProperty(object.address, 'address');
                this.birthday.day = ko.observable((object.birthday !== undefined) ? new Date(object.birthday).getDate() : null);
                this.birthday.month = ko.observable((object.birthday !== undefined) ? new Date(object.birthday).getMonth() + 1 : null);
                this.birthday.year = ko.observable((object.birthday !== undefined) ? new Date(object.birthday).getFullYear() : null);
                this.birthday.value = ko.computed(this.getBirthdayValue, this.birthday);
                return this;
            }
        }
    };
    return User;
});