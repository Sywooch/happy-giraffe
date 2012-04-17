var Interest = {

};

Interest.changeCategory = function(link) {
    $(link).parent().addClass('active').siblings().removeClass('active');
    var index = $(link).parent().index();
    $('#interestsEdit').find('.interests-list ul.active').removeClass('active');
    $('#interestsEdit').find('.interests-list ul:eq('+index+')').addClass('active');
    return false;
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