define(['jquery', 'knockout', 'models/Model', 'extensions/knockout.validation', 'extensions/validatorRules'], function ($, ko, Model) {
    var Photopost = {
        getUrl: '/api/photopost/get/',
        createUrl: '/api/photopost/create/',
        updateUrl: '/api/photopost/update/',
        removeUrl: '/api/photopost/remove/',
        restoreUrl: '/api/photopost/restore/',
        maxTitleLength: 150,
        id: ko.observable(),
        title: ko.observable,
        photoArray: ko.observableArray(),
        photoAttaches: ko.observableArray(),
        create: function createPhotopost() {
            return Model.get(this.createUrl, { title: this.title(), collectionId: this.collectionId(), isDraft: this.isDraft() });
        },
        get: function getPhotopost(id) {
            return Model.get(this.getUrl, { id: id });
        },
        init: function initPhotopost(photopostData) {
            this.id = ko.observable(photopostData.id);
            this.title = ko.observable(photopostData.title);
            this.collectionId = ko.observable(photopostData.collectionId);
            this.isDraft = ko.observable(false);
            /**
             * Валидация
             */
            this.title.extend({ maxLength: { params: this.maxTitleLength, message: "Количество символов не больше " + this.maxTitleLength }, mustFill: true });
        }
    };

    return Photopost;
});
