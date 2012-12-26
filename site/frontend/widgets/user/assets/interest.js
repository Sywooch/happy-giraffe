var Interest = {

};

Interest.changeCategory = function (el) {
    if (!$(el).parent().hasClass('active')) {
        $(el).parent().addClass('active').siblings('.active').removeClass('active');

        var index = $(el).parent().index();
        $('#interestsManage .interests-drag-list:visible').hide();
        $('#interestsManage .interests-drag-list:eq(' + index + ')').show();
    }
};

Interest.removeSelected = function (el) {
    $(el).parent().remove();
    $('#interestsManage .interest-drag[data-id=' + $(el).parent().data('id') + ']').show();
};

Interest.save = function () {
    var form = $('#interestsManage form');
    $.post($(form).attr('action'), $(form).serialize(), function (response) {
        if (response.status) {
            if (response.full)
                window.location.reload();
            else{
                $.fancybox.close();
                $('div.interests-wrapper').html(response.html);
                if (typeof Bonus != 'undefined')
                    Bonus.closeStep(5);
            }
        }
    }, 'json');
}

