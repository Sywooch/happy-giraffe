define(['jquery', 'knockout', 'models/Model'], function ($, ko, Model) {
   var Status = {
       getUrl: '/api/status/get/',
       createUrl: '/api/status/create/',
       updateUrl: '/api/status/update/',
       removeUrl: '/api/status/remove/',
       restoreUrl: '/api/status/restore/',
       moodsUrl: '/api/status/moods/',
       moodImageUrl: '/images/widget/mood/',
       mood: {},
       moodsArray: ko.observableArray([]),
       init: function initStatus(statusData) {
           this.id = ko.observable(statusData.id);
           this.text = ko.observable(statusData.text);
           this.mood.id = ko.observable(statusData.mood.id);
           this.mood.text = ko.observable(statusData.mood.text);
           this.isRemoved = ko.observable(statusData.isRemoved);
           this.dtimeCreate = ko.observable(statusData.dtimeCreate);
       }
   };

    return Status;
});