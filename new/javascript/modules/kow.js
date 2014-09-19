define('kow', ['knockout'], function (ko) {
   ko.components.register('comment-widget', { require: 'comment-widget' }); ko.applyBindings({}, $('comment-widget')[0]);
});