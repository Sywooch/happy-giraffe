var Interest = {

};

Interest.changeCategory = function(link) {
    var index = $(link).parent().index();
    $('#interestsEdit').find('.interests-list ul.active').hide();
    return false;
}