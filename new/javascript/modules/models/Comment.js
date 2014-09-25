define(function() {

   var Comment = {

      user: {},

      color: '',

      answers: [],

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