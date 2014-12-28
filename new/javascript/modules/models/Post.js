define(['knockout', 'models/Model'], function PresetManagerHandler(ko, Model) {
    var User = {
        removeBlogUrl: '/newblog/remove/',
        restoreBlogUrl: '/newblog/restore/',
        removed: ko.observable(false),
        /**
         * Полное имя
         * @returns {string}
         */
        fullName: function fullName() {
            return this.firstName + ' ' + this.lastName;
        },
        remove: function removePost() {
            Model.get(this.removeBlogUrl, { id: this.id });
            this.removed(true);
        },
        restore: function restorePost() {
            Model.get(this.restoreBlogUrl, { id: this.id });
            this.removed(false);
        },
        /**
         * init юзера
         * @param object
         * @returns {User}
         */
        init: function init(object) {

            if (object !== undefined) {

                this.id = object.articleId;
                this.editUrl = object.editUrl;

                return this;
            }
        }
    };
    return User;
});