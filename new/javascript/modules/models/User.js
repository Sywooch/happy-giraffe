define(function() {

    var User = {

        getUserUrl: '/api/users/get/',

        /**
         * Полное имя
         * @returns {string}
         */
        fullName: function fullName() {
            return this.firstName + ' ' + this.lastName;
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

                this.fullName = this.fullName();

                return this;
            }

        }
    };

    return User;
});