define(['jquery', 'knockout'], function($, ko) {
   var User = {
      avatarId: this.avatarId,
      avatarurl: this.avatarUrl,
      firstName: this.firstName,
      gender: this.gender,
      id: this.id,
      isOnline: this.isOnline,
      lastName: this.lastName,
      profileUrl: this.profileUrl,
      publicChannel: this.publicChannel,
      fullName: function fullName() {
         return this.firstName + ' ' + this.lastName;
      },
      init: function (object) {
         if (object !== undefined) {
            this.avatarId = object.avatarId;
            this.avatarUrl = object.avatarUrl;
            this.firstName = object.firstName;
            this.gender = object.gender;
            this.id = object.id;
            this.isOnline = object.isOnline;
            this.lastName = object.lastName;
            this.profileUrl = object.profileUrl;
            this.publicChannel = object.publicChannel;
            this.fullName = this.fullName();
            return this;
         }
      }
   }
   return User;
});