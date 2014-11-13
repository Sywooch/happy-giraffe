 define('photo/PhotoAttach', ['knockout', 'photo/Photo', 'models/Model'], function(ko, Photo, Model) {
    // Основная модель аттача
    function PhotoAttach(data) {
        this.removeUrl = '/api/photo/attaches/remove/';
        this.restoreUrl = '/api/photo/attaches/restore/';
        this.setCoverUrl = '/api/photo/collections/setCover/';
        this.id = ko.observable(data.id);
        this.position = ko.observable(data.position);
        this.photo = ko.observable(new Photo(data.photo));
        this.loading = ko.observable(true);
        this.broke = ko.observable(false);
        this.removed = ko.observable(false);
        this.isCover = ko.observable(false);
        this.remove = function () {
            Model.get(this.removeUrl, {
                id: this.id()
            }).done(function (response) {
                if (response.success === true) {
                    this.removed(true);
                }
            }.bind(this));
        };
        this.restore = function () {
            Model.get(this.restoreUrl, {
                id: this.id()
            }).done(function (response) {
                if (response.success === true) {
                    this.removed(false);
                }
            }.bind(this));
        };
        this.setCover = function setCover(collectionId, data) {
            Model
                .get(this.setCoverUrl, { collectionId: collectionId, attachId: this.id() })
                .done(this.setCoverHandler.bind(this));
        };
        this.setCoverHandler = function setCoverHandler(status) {
            if (status.success === true) {
                this.isCover(true);
            }
        };
    }

    return PhotoAttach;
});