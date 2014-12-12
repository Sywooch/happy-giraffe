define(['jquery', 'knockout', 'models/Model', 'extensions/knockout.validation', 'extensions/validatorRules'], function ($, ko, Model) {
   var Status = {
       getUrl: '/api/status/get/',
       createUrl: '/api/status/create/',
       updateUrl: '/api/status/update/',
       removeUrl: '/api/status/remove/',
       restoreUrl: '/api/status/restore/',
       moodsUrl: '/api/status/moods/',
       moodImageUrl: '/images/widget/mood/',
       mood: {},
       choosedMood: ko.observable(),
       moodsArray: ko.observableArray([]),
       maxTextLength: 450,
       create: function createStatus() {
         return Model.get(this.createUrl, { text: this.text(), mood: (this.choosedMood() !== undefined && this.choosedMood() !== null) ? this.choosedMood().id : null });
       },
       update: function updateStatus() {
           return Model.get(this.updateUrl, { id: this.id(), text: this.text(), mood: (this.choosedMood() !== undefined && this.choosedMood() !== null) ? this.choosedMood().id : null });
       },
       get: function getStatus(id) {
           return Model.get(this.getUrl, { id: id });
       },
       init: function initStatus(statusData) {
           this.id = ko.observable(statusData.id);
           this.text = ko.observable(statusData.text);
           this.text.extend({ maxLength: { params: this.maxTextLength, message: "Количество символов не больше " + this.maxTextLength }, mustFill: true });
           this.choosedMood = ko.observable(statusData.mood);
           if (this.choosedMood() !== undefined) {
               this.choosedMood().url = (statusData.mood !== undefined) ? this.moodImageUrl + statusData.mood.id + '.png' : '';
           }
           this.isRemoved = ko.observable(statusData.isRemoved);
           this.dtimeCreate = ko.observable(statusData.dtimeCreate);
       }
   };

    return Status;
});