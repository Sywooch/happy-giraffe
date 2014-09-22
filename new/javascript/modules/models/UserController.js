define(['jquery', 'knockout'], function($, ko) {

   var UserController = {

      getUserUrl: '/api/users/get/',

      isUserInPack: function isUserInPack (id, userData) {
         for (var i=0; i < userData.length; i++) {
            if (id === userData[i].data.id) {
               return i;
            }
         }
         return false
      },

      get: function ( url, paramsData ) {
         return $.ajax(
           {
               type: "POST",
               url: url,
               data:  JSON.stringify(paramsData),
               dataType: 'json'
            }
          );
      },

   }

   return UserController;
});