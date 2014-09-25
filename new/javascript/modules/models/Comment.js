define(["jquery", "knockout", "model"], function($, ko, Model) {

   var Comment = {

      user: {},

      color: '',

      /**
       * Url для получения списка комментариев
       * @type {String}
       */
      getListUrl: '/api/comments/list/',

      /**
       * Url для получения одного комментария
       * @type {String}
       */
      getComment: '/api/comments/get/',

      /**
       * Url страницы для создания комментария
       * @type {String}
       */
      createCommentUrl: '/api/comments/create/',

      /**
       * Url страницы для создания комментария
       * @type {String}
       */
      removeCommentUrl: '/api/comments/remove/',

      answers: [],

      removed: false,

      removeSucess: function removeSucess(successData) {
         console.log(successData);
      },

      remove: function remove() {
         Model
            .get( this.removeCommentUrl(), { id: this.id() } )
            .done( this.removeSucess.bind(this) );
      },

      init: function init (object) {

         if (object !== undefined) {

            this.authorId = object.authorId;

            this.dtimeCreate = object.dtimeCreate;

            this.entity = object.entity;

            this.entityId = object.entityId;

            this.id = object.id;

            this.entityUrl = object.entityUrl;

            this.likesCount = object.likesCount;

            this.originHtml = object.originHtml;

            this.photoId = object.photoId;

            this.purifiedHtml = object.purifiedHtml;

            this.responseId = object.responseId;

            this.rootId = object.rootId;

            this.specialistLabel = object.specialistLabel;

            this.specialistLabel = object.specialistLabel;

            return this;
         }
      }
   }

   return Comment;
});