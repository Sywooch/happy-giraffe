define(["jquery", "knockout"], function ($, ko) {
    var componentIterator = function componentIterator() {
        ko.applyBindings({}, $(this)[0]);
    };
    ko.components.register('md-redactor', { require: 'md-redactor/md-redactor' });
    $('md-redactor').each(componentIterator);
    ko.components.register('photo-uploader', { require: 'photo-uploader/photo-uploader' });
    $('photo-uploader').each(componentIterator);
    ko.components.register('photo-uploader-form', { require: 'photo-uploader-form/photo-uploader-form' });
    ko.components.register('photo-albums-create', { require: 'photo-albums-create/photo-albums-create' });
    $('photo-albums-create').each(componentIterator);
    ko.components.register('photo-album', { require: 'photo-album/photo-album' });
    $('photo-album').each(componentIterator);
    ko.components.register('photo-albums', { require: 'photo-albums/photo-albums' });
    $('photo-albums').each(componentIterator);
    ko.components.register('photo-album-compact', { require: 'photo-album-compact/photo-album-compact' });
    $('photo-album-compact').each(componentIterator);
    ko.components.register('photo-slider', { require: 'photo-slider/photo-slider' });
    ko.components.register('photo-collection', { require: 'photo-collection/photo-collection' });
    $('photo-collection').each(componentIterator);
    ko.components.register('family-user', { require: 'family-user/family-user' });
    $('family-user').each(componentIterator);
    ko.components.register('family-settings', { require: 'family-settings/family-settings' });
    $('family-settings').each(componentIterator);
    ko.components.register('photo-single', { require: 'photo-single/photo-single' });
    $('photo-single').each(componentIterator);
    ko.components.register('comment-widget', { require: 'comment-widget/comment-widget' });
    $('comment-widget').each(componentIterator);
<<<<<<< HEAD
    ko.components.register('register-form', { require: 'signup/register-form' });
    ko.components.register('login-form', { require: 'signup/login-form' });
    ko.components.register('password-recovery-form', { require: 'signup/password-recovery-form' });
=======
    ko.components.register('post-status-add', { require: 'post-status-add/post-status-add' });
    $('post-status-add').each(componentIterator);
    ko.components.register('post-photo-add', { require: 'post-photo-add/post-photo-add' });
    $('post-photo-add').each(componentIterator);
    ko.components.register('article-settings', { require: 'article-settings/article-settings' });
    $('article-settings').each(componentIterator);
    ko.components.register('redactor-panel', { require: 'redactor-panel/redactor-panel' });
    $('redactor-panel').each(componentIterator);

>>>>>>> develop
});