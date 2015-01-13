define(['knockout', 'models/Model', 'user-config'], function PresetManagerHandler(ko, Model, userConfig) {
    var User = {
        getUserUrl: '/api/users/get/',
        changePasswordUrl: '/api/users/changePassword/',
        changeEmailUrl: '/api/users/changeEmail/',
        removeUserUrl: '/api/users/remove/',
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
        changePassword: function changePassword(newPassword) {
            return Model.get(this.changePasswordUrl, { id: this.id, password: newPassword });
        },
        changeEmail: function changeEmail() {
            return Model.get(this.changeEmailUrl, { id: this.id });
        },
        remove: function remove() {
            return Model.get(this.removeUserUrl, { id: this.id });
        },
        mailSubscribe: function mailSubscribe() {
            return Model.get(this.mailSubscriptionUrl, { id: this.id, value: this.subscriptionMail });
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

                this.profileUrl = object.profileUrl;

                this.publicChannel = object.publicChannel;

                this.subscriptionMail = object.subscriptionMail;

                this.fullName = this.fullName();

                return this;
            }
        }
    };
    return User;
});