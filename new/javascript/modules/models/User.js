define(['jquery', 'knockout'], function($, ko) {

   var User = {

      getUser: '/api/users/get/',

      getUserData: function (id, avatarSize, isPack) {

         // if (isPack) {
         //    pack: {
               
         //    }
         // }

         // avatarSize = typeof avatarSize !== 'undefined' ? avatarSize : false;

         // return {
         //    id: id,
         //    avatarSize: avatarSize
         // }
      }

   }

   return User;
});