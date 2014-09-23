define(['jquery', 'knockout', 'comments-control', 'user-control', 'text!comment-widget.html', 'moment', 'knockout.mapping', 'ko_library'], function($, ko, CommentsController, UserData, template, moment) {

   var CommentWidgetViewModel = function (params) {

      this.commentsData = Object.create( CommentsController );

      this.userData = Object.create( UserData );

      this.commentsDataQueue = [];

      this.parsedData = ko.mapping.fromJS([]);

      this.authUser = ko.mapping.fromJS({});

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