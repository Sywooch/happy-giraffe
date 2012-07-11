var Interest = {

};

Interest.changeCategory = function(el) {
    if (! $(el).parent().hasClass('active')) {
        $(el).parent().addClass('active').siblings('.active').removeClass('active');

        var index = $(el).parent().index();
        $('#interestsManage .interests-drag-list:visible').hide();
        $('#interestsManage .interests-drag-list:eq(' + index + ')').show();
    }
};

Interest.checkItem = function(elem) {
    $(elem).toggleClass('selected');
    var id = $(elem).attr('for');
    $('#'+id).click();
};

Interest.save = function(form) {
    $.post(form.action, $(form).serialize(), function(data) {
        $('#user_interests_list').replaceWith(data);
        $.fancybox.close();
    });
    return false;
}


