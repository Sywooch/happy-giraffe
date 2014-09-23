define(['jquery', 'knockout', 'userConfig', 'user-model'], function($, ko, userConfig, User) {

   var UserController = {

      getUserUrl: '/api/users/get/',

      userConfig: userConfig,

      checkForMe: function checkForMe(array) {
         if ($.inArray( this.userConfig.userId, array ) === -1 ) {
            array.push(this.userConfig.userId)
         }
         return array;
      },

      getCurrentUserFromList: function getCurrentUserFromList(userList, success) {
         if (success === true) {
            for( var i = 0; i < userList.length; i++ ) {
               if (userList[i].data.id === this.userConfig.userId) {
                  userList[i].data.success = userList[i].success;
                  var userObj = Object.create( User );
                  return userObj.init( userList[i].data );
               }
            }
         }
         return false;
      },

      isUserInPack: function isUserInPack (id, userData) {
         for (var i=0; i < userData.length; i++) {
            if (id === userData[i].data.id) {
               return i;
            }
         }
         return false
      },

      get: function get ( url, paramsData ) {
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