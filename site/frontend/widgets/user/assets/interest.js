var Interest = {

};

Interest.changeCategory = function(link) {
    $(link).parent().addClass('active').siblings().removeClass('active');
    var index = $(link).parent().index();
    $('#interestsEdit').find('.interests-list ul.active').removeClass('active');
    $('#interestsEdit').find('.interests-list ul:eq('+index+')').addClass('active');
    return false;
}