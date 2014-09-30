define(["jquery", "knockout", "model", "care-wysiwyg"], function($, ko, Model) {

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
       * Url страницы для удаления комментария
       * @type {String}
       */
      removeCommentUrl: '/api/comments/remove/',

      /**
       * Url страницы для восстановления комментария
       * @type {String}
       */
      restoreCommentUrl: '/api/comments/restore/',

      /**
       * Url страницы для обновления комментария
       * @type {String}
       */
      renewCommentUrl: '/api/comments/update/',

      answers: [],

      removed: false,

      editingCurrent: false,

      editor: '',

       answerTo: {},

      removeSucess: function removeSucess(successData) {

         if (successData === false) {

         };

      },

      editorConfig: {
          minHeight: 88,
          buttons: ['bold', 'italic', 'underline'],
          plugins: ['imageCustom', 'smilesModal', 'videoModal'],
          callbacks: {
              init: []
         }
      },

      answering: false,

      beginEditing: function beginEditing(message) {
          this.editor(message.text());
          this.edit();
      },

      cancelEditing: function cancelEditing() {
          this.editor('');
          this.editingCurrent(false);
          this.answering(false);
      },

      cancelEditor: function cancelEditor() {
          this.editor('');
          this.editingCurrent(false);
          this.answering(false);
      },

      edit: function edit() {
          this.editor(this.originHtml());
          this.editingCurrent(true);
      },

           /**
            * Создание отдельного комментария
            * @param  {string} entity
            * @param  {int} entityId
            * @param  {sting} text
            * @param  {id} responseId
            * @return {object}
            */
           createCommentCredentials: function createCommentCredentials(entity, entityId, text, responseId) {
               if (responseId === undefined) {

                   return {
                       entity: entity,
                       entityId: entityId,
                       text: text
                   }
               }

               return {
                   entity: entity,
                   entityId: entityId,
                   text: text,
                   responseId: responseId
               }
           },

       isRedactorStringEmpty: function isRedactorStringEmpty(string) {
           if (string !== '') {
               string = string
                   .replace(/(?!<\/?[imgiframe].*?>)<.*?>/g,"")
                   .replace(/(&nbsp;)/ig, "")
                   .trim();

               if (string !== '') {
                   return false;
               }
           }
           return true;
        },

       create: function create(params) {
           var commentText = this.editor();
           if ( !this.isRedactorStringEmpty( commentText ) ) {
               Model
                   .get( this.createCommentUrl(), this.createCommentCredentials( params.entity, params.entityId, commentText, this.id() ) )
                   .done( this.cancelEditor.bind(this) );
           }
       },

      renewComment: function renewComment() {
         Model
            .get( this.renewCommentUrl(), { id: this.id(), text: this.editor() } )
            .done( this.cancelEditor.bind(this) );
      },

       response: function response () {
           this.cancelEditing();
           this.answering(true);
           this.editor();
       },

      remove: function remove() {
         Model
            .get( this.removeCommentUrl(), { id: this.id() } )
            .done( this.removeSucess.bind(this) );
      },

      restore: function restore() {
         Model
            .get( this.restoreCommentUrl(), { id: this.id() } )
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

            this.removed = object.removed;

            this.editingCurrent = object.editingCurrent;

            this.answering = object.answering;

             this.answerTo = {};

            this.editor = this.editor;

            return this;
         }
      }
   };

    return Comment;
});