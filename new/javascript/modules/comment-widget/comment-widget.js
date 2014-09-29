define(['jquery', 'knockout', 'comments-control', 'user-control', 'text!comment-widget.html', 'moment', 'model', 'comment-model', 'user-model', 'care-wysiwyg', 'knockout.mapping', 'ko_library', 'comet-connect'], function($, ko, CommentsController, UserData, template, moment, Model, Comment, User) {

   var CommentWidgetViewModel = function (params) {

      comet.addChannel(params.channelId);

      this.commentsData = Object.create( CommentsController );

      this.userData = Object.create( UserData );

      this.commentsDataQueue = [];

      this.parsedData = ko.mapping.fromJS([]);

      this.authUser = ko.mapping.fromJS({});

      this.editing = ko.observable(false);

      this.editor = ko.observable('');

      this.cacheData = {};

       this.modelParams = params;

      this.editorHidden = ko.observable(false);

      /**
       * Comet Создания комментария
       */

      this.newCommentAddedEvent = function (result, id) {

        this.cacheData = result;

          if (this.cacheData.responseId !== 0) {
              Model.get(
                  User.getUserUrl,
                  {
                      id: result.authorId,
                      avatarSize: this.commentsData.commentAvatarSize
                  })
                  .done( this.answerAdded.bind( this ) );
          }
          else {
              Model.get(
                  User.getUserUrl,
                  {
                      id: result.authorId,
                      avatarSize: this.commentsData.commentAvatarSize
                  })
                  .done( this.getNewUser.bind( this ) );
          }


      };

      Comet.prototype.newCommentAdded = this.newCommentAddedEvent.bind(this);

      comet.addEvent(2510, 'newCommentAdded');

      this.getNewUser = function (userData) {
        this.parsedData.unshift( this.commentsData.newCommentAddedUser( this.cacheData, userData, this.parsedData()) );
      };


       this.answerAdded = function (userData) {
           var answerObject = this.commentsData.newAnswer( this.cacheData, userData, this.parsedData());
           this.parsedData()[answerObject.parentId].answers.push(answerObject.comment);
       };

      /**
       * Comet Обновление комментария
       */

      this.renewCommentAddedEvent = function (result, id) {

        if ( result.responseId !== 0 ) {
            var commentRootId = this.commentsData.findIfAnswer( result, this.parsedData() );
            var commentChildId = this.commentsData.findInAnswers( result, this.parsedData()[commentRootId].answers() );
            if (commentChildId !== undefined) {
                this.parsedData()[commentRootId].answers()[commentChildId].purifiedHtml( result.purifiedHtml );
            }

        }

        else {
            var commentObj = this.commentsData.removedStatus( result, this.parsedData() );

            if (commentObj !== undefined) {
                this.parsedData()[commentObj].purifiedHtml( result.purifiedHtml );
            }
        }


      };

      Comet.prototype.renewCommentAdded = this.renewCommentAddedEvent.bind(this);

      comet.addEvent(2520, 'renewCommentAdded');


      /**
       * Comet Удаление комментария
       */

      this.commentRemovedEvent = function (result, id) {

        var commentObj = this.commentsData.removedStatus( result, this.parsedData() );

        if (commentObj !== undefined) {
            this.parsedData()[commentObj].removed( true );
        }

      };

      Comet.prototype.commentRemoved = this.commentRemovedEvent.bind(this);

      comet.addEvent(2530, 'commentRemoved');

      /**
       * Comet Восстановление комментария
       */

      this.commentRestoredEvent = function (result, id) {

        var commentObj = this.commentsData.removedStatus( result, this.parsedData() );

        if (commentObj !== undefined) {
            this.parsedData()[commentObj].removed( false );
        }

      };

      Comet.prototype.commentRestored = this.commentRestoredEvent.bind(this);

      comet.addEvent(2540, 'commentRestored');


      this.setEditing = function() {
         this.editing(true);
      };

      this.isRedactorStringEmpty = function isRedactorStringEmpty(string) {
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
      };

      this.cancelEditor = function cancelEditor(data) {

          if (this.editorHidden() === false ) {

          };

      };

      this.addComment = function addComment () {
         var commentText = this.editor();
         if ( !this.isRedactorStringEmpty( commentText ) ) {
            Model
              .get( Comment.createCommentUrl, this.commentsData.createComment( params.entity, params.entityId, this.editor() ))
              .done( this.cancelEditor.bind(this) )
         }
      };

      this.deleteComment = function deleteComment () {

         var commentText = this.editor();
         if ( !this.isRedactorStringEmpty( commentText ) ) {
            Model.get( Comment.createCommentUrl, this.commentsData.createComment( params.entity, params.entityId, this.editor() ));
         }
      };

      this.editorConfig = {
          minHeight: 88,
          buttons: ['bold', 'italic', 'underline'],
          plugins: ['imageCustom', 'smilesModal', 'videoModal'],
          callbacks: {
              init: []
         }
      };

      this.beginEditing = function(message) {
          this.editor(message.text());
          this.setEditing();
      };

      this.cancelEditing = function() {
          this.editor('');
          this.editing(false);
      }

      this.allEventsSucceed = function usersSucceed(userData) {
         ko.mapping.fromJS(this.userData.getCurrentUserFromList(userData.data, userData.success), this.authUser);
         ko.mapping.fromJS(this.commentsData.allDataReceived(userData.data, this.commentsDataQueue.commentsData), this.parsedData);
      }

      this.dataGetSucceed = function (data) {
         this.commentsDataQueue = this.commentsData.parseData(data);
         Model.get( User.getUserUrl, this.commentsDataQueue.userPack).done( this.allEventsSucceed.bind( this ) );
      };

      this.commentDataParams = this.commentsData.getListData( params.entity, params.entityId, params.listType );
      Model.get( Comment.getListUrl, this.commentDataParams ).done( this.dataGetSucceed.bind( this ) );
   }

   return {
      viewModel: CommentWidgetViewModel,
      template: template
   };
});