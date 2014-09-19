define(['jquery', 'knockout'], function($, ko) {

   var Comments = {

      getListUrl: '/api/comments/list/',

      getComment: '/api/comments/get/',

      getListData: function (entitySub, entityIdSub, listType) {
        return {
         entity: entitySub,
         entityId: entityIdSub,
         listType: listType,
         rootCount: 10,
         dtimeFrom: 0
        };
      },

      parseData: function ( parsingData ) {
        if (parsingData.success === true) {
          return parsingData.data.list;
        }
        return false;
      },

      getSuccess: function ( data ) {
         console.log(data);
      },

      errorGetting: function ( jqXHR, textStatus, errorThrown ) {
        console.log( errorThrown );
      },

      get: function ( url, paramsData ) {
         return $.ajax(
           {
               type: "POST",
               url: url,
               data:  paramsData,
               dataType: 'json'
            }
          );
      }
   }

   return Comments;
});