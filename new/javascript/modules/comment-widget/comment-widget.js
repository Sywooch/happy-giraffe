define(['jquery', 'knockout', 'comments-control', 'user-control', 'text!comment-widget.html', 'moment', 'wysiwyg', 'knockout.mapping', 'ko_library', 'comet'], function($, ko, CommentsController, UserData, template, moment) {

   var CommentWidgetViewModel = function (params) {

      comet.addChannel(params.channelId);

      console.log(comet);

      this.commentsData = Object.create( CommentsController );

      this.userData = Object.create( UserData );

      this.commentsDataQueue = [];

      this.parsedData = ko.mapping.fromJS([]);

      this.authUser = ko.mapping.fromJS({});

      this.editing = ko.observable(false);

      this.editor = ko.observable('');

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
            this.commentsData.get( this.commentsData.createCommentUrl, this.commentsData.createComment( params.entity, params.entityId, this.editor() )).done(function (data) { console.log(data) });
         }
         else {
            console.log('will not add')
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
         this.userData.get( this.userData.getUserUrl, this.commentsDataQueue.userPack).done( this.allEventsSucceed.bind( this ) );
      };

      this.commentDataParams = this.commentsData.getListData( params.entity, params.entityId, params.listType );
      this.commentsData.get( this.commentsData.getListUrl, this.commentDataParams ).done( this.dataGetSucceed.bind( this ) );
   }

   return {
      viewModel: CommentWidgetViewModel,
      template: template
   };
});