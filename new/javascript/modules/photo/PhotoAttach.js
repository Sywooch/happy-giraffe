 define('photo/PhotoAttach', ['knockout', 'photo/Photo', 'models/Model'], function(ko, Photo, Model) {
    // Основная модель аттача
    function PhotoAttach(data) {
        this.removeUrl = '/api/photo/attaches/remove/';
        this.restoreUrl = '/api/photo/attaches/restore/';
        this.setCoverUrl = '/api/photo/collections/setCover/';
        this.getAttachUrl = '/api/photo/attaches/get/';
        this.id = (ko.isObservable(data.id) === false) ? ko.observable(data.id) : data.id;
        this.position = (ko.isObservable(data.position) === false) ? ko.observable(data.position) : data.position;
        this.index = (ko.isObservable(data.index) === false) ? ko.observable(data.index) : data.index;
        this.url = (ko.isObservable(data.url) === false) ? ko.observable(data.url) : data.url;
        this.photo = (ko.isObservable(data.photo) === false) ? ko.observable(new Photo(data.photo)) : new Photo(data.photo);
        this.loading = ko.observable(true);
        this.broke = ko.observable(false);
        this.removed = ko.observable(false);
        this.isCover = ko.observable(false);
        this.uploaded = ko.observable(false);
        this.urlPart = 'photo' + this.photo().id() + '/';
        /**
         * doneRemoving
         *
         * @param  obj response
         * @return
         */
        this.doneRemoving = function doneRemoving(response) {
          if (response.success === true) {
              this.removed(true);
          }
        };
        /**
         * doneRestoring
         *
         * @param  obj response
         * @return
         */
        this.doneRestoring = function doneRestoring(reponse) {
          if (response.success === true) {
              this.removed(false);
          }
        };
        /**
         * Removing attach
         */
        this.remove = function removingAttach() {
            Model.get(this.removeUrl, {
                id: this.id()
            }).done(this.doneRemoving.bind(this));
        };
        /**
         * Getting attach
         * @param id
         * @returns {$.ajax}
         */
        this.get = function (id) {
            return Model.get(this.getAttachUrl, {
                id: id
            });
        };
        /**
         * Restore attach
         */
        this.restore = function () {
            Model.get(this.restoreUrl, {
                id: this.id()
            }).done(this.doneRestoring.bind(this));
        };
        /**
         * Setting attach as cover
         * @param collectionId
         * @param data
         */
        this.setCover = function setCover(collectionId, data) {
            Model
                .get(this.setCoverUrl, { collectionId: collectionId, attachId: this.id() })
                .done(this.setCoverHandler.bind(this));
        };
        /**
         * Setting attach as cover handler
         * @param collectionId
         * @param data
         */
        this.setCoverHandler = function setCoverHandler(status) {
            if (status.success === true) {
                this.isCover(true);
            }
        };
    }

    return PhotoAttach;
});
