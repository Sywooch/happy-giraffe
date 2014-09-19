define(['jquery', 'knockout', 'comments-model', 'text!comment-widget.html', 'moment', 'knockout.mapping'], function($, ko, Comments, template, moment) {

   var CommentWidgetViewModel = function (params) {

      this.commentsData = Object.create( Comments );

      this.parsedData = ko.mapping.fromJS([]);

      this.dataGetSucceed = function (data) {

         var dataQ = this.commentsData.parseData(data);

         ko.mapping.fromJS(dataQ, this.parsedData);

         console.log(this.parsedData());
      };

      this.commentDataParams = this
                                 .commentsData
                                    .getListData( params.entity, params.entityId, params.listType );

      this
         .commentsData
            .get( this.commentsData.getListUrl, this.commentDataParams )
               .done( this.dataGetSucceed.bind( this ) );
   }

   return {
      viewModel: CommentWidgetViewModel,
      template: template
   };
});