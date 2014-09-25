define(['jquery', 'knockout', 'comments-control', 'user-control', 'text!comment-widget.html', 'moment', 'model', 'comment-model', 'user-model', 'wysiwyg', 'knockout.mapping', 'ko_library', 'comet-connect'], function($, ko, CommentsController, UserData, template, moment, Model, Comment, User) {

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

      this.getNewUser = function (userData) {
        this.parsedData.unshift( this.commentsData.newCommentAddedUser( this.cacheData, userData, this.parsedData()) );
      };

      this.newCommentAddedEvent = function (result, id) {
        this.cacheData = result;

        Model.get(
            User.getUserUrl,
            {
              id: result.authorId,
              avatarSize: this.commentsData.commentAvatarSize
            })
          .done( this.getNewUser.bind( this ) );
      };

      Comet.prototype.newCommentAdded = this.newCommentAddedEvent.bind(this);

      comet.addEvent(2510, 'newCommentAdded');

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

      this.addComment = function addComment () {
         var commentText = this.editor();
         if ( !this.isRedactorStringEmpty( commentText ) ) {
            Model.get( Comment.createCommentUrl, this.commentsData.createComment( params.entity, params.entityId, this.editor() ));
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