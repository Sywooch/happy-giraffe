var socwin;
$(document).ready(function () {
    if ($('a.fancy').size() > 0) {
        $('body').delegate('a.fancy', 'click', function () {
            var onComplete_function = function () {
                if ($('.popup .chzn').size() > 0) $('.popup .chzn').chosen();
            };
            if ($(this).hasClass('attach_link')) {
                onComplete_function = function () {
                    Attach.init();
                };
            }
            $(this).clone().fancybox({
                overlayColor:'#000',
                overlayOpacity:'0.6',
                padding:0,
                showCloseButton:false,
                scrolling:false,
                onComplete:onComplete_function
            }).trigger('click');
            return false;
        });
    }

    if ($('.chzn').size() > 0) {
        $('.chzn').each(function () {
            var s = $(this);
            s.chosen({
                allow_single_deselect:s.hasClass('chzn-deselect')
            })
        });
    }

    if ($('input[placeholder], textarea[placeholder]').size() > 0) $('input[placeholder], textarea[placeholder]').placeholder();

    $('body').click(function (e) {
        if (!$(e.target).parents().hasClass('navdrp')) navDrpClose();
    })

});

function addAttributesToCart(form, update) {
    var link = $('<a></a>').attr('href', form.action);
    link.fancybox({
        overlayColor:'#000',
        overlayOpacity:'0.6',
        padding:0,
        showCloseButton:false,
        scrolling:false,
        ajax:{
            type:'POST',
            data:$(form).serialize()
        }
    });
    link.trigger('click');
    return false;
}


function setTab(el, num) {
    var tabs = $(el).parents('.tabs');
    var li = $(el).parent();
    if (!li.hasClass('active')) {
        tabs.find('li').removeClass('active');
        li.addClass('active');
        tabs.find('.tab-box-' + num).fadeIn();
        initSelects(tabs.find('.tab-box-' + num));
        tabs.find('.tab-box').not('.tab-box-' + num).hide();

    }
}

function setItemRadiogroup(el, val) {
    var rg = $(el).parents('.filter-radiogroup');
    var li = $(el).parent();

    if (!li.hasClass('active')) {
        if (!rg.hasClass('filter-radiogroup-multiply')) {
            rg.find('li').removeClass('active');
            rg.find('input').val(val);
        } else {
            li.find('input').val(1);
        }

        li.addClass('active');
    }

}

function unsetItemRadiogroup(el) {
    var rg = $(el).parents('.filter-radiogroup');
    var li = $(el).parent();

    $(li).removeClass('active');
    $(li).find('input').val(0);
}

function setRatingHover(el, num) {
    var block = $(el).parents('.setRating');

    block.addClass('hover');

    var i = 0;

    while (i < num) {
        block.find('span').eq(i).addClass('hover');
        i++;
    }
}

function setRatingOut(el) {
    $(el).removeClass('hover').find('span').removeClass('hover');

}

function setRating(el, num) {

    var block = $(el).parents('.setRating');

    block.find('span').removeClass('active');

    var i = 0;

    while (i < num) {
        block.find('span').eq(i).addClass('active');
        i++;
    }

    block.find('input').val(num);
}

$('.setRating span').hover(function () {

    $('.hotel-class .star-hover').removeClass('star-hover');

    var ok = false;
    $(this).addClass('star-hover');
    var i = 1;
    $('.hotel-class .star').each(function () {

        if ($(this).hasClass('star-hover')) {
            ok = true;
        }

        if (ok == false) {
            $(this).addClass('star-hover');
            i++;
        }
    })
})

$('.hotel-class .star').click(function () {
    $('.hotel-class .star').removeClass('checked');

    var ok = false;
    $(this).addClass('checked');
    var i = 1;
    $('.hotel-class .star').each(function () {

        if ($(this).hasClass('checked')) {
            ok = true;
            $('.hotel-class input').val(i);
        }

        if (ok == false) {
            $(this).addClass('checked');
            i++;
        }
    })
});

function toggleFilterBox(el) {
    $(el).parents('.filter-box').toggleClass('filter-box-toggled');
}

function setPlaceholder(el) {
    if ($(el).val() == '') {
        $(el).val($(el).attr('placeholder'));
        $(el).addClass('placeholder')
    }
}

function unsetPlaceholder(el) {
    if ($(el).val() == $(el).attr('placeholder')) {
        $(el).val('');
        $(el).removeClass('placeholder');
    }
}


function toggleChildForm(el) {
    $(el).parents('.child').find('.child-form').fadeToggle();
}

function toggleBudgetCategoryBox(el) {
    $(el).parents('.category-box').find('.box-in:not(:animated)').slideToggle(function () {
        $(this).parents('.category-box').toggleClass('toggled')
    });
}
function toggleSelectBox(el) {
    list = $(el).parents('.select-box').find('.select-list');
    if (list.is(':visible')) {
        list.hide();
    }
    else {
        if ($('.select-list:visible').size() > 0) {
            $('.select-list:visible').hide();
        }
        list.fadeIn(200);
    }

}

function setSelectBoxValue(el) {
    $(el).parents('.select-box').find('.select-value span').html($(el).find('span').html());
    $(el).parents('.select-box').find('.select-value input').val($(el).find('input').val());
    $(el).parents('.select-box').find('.select-list li').removeClass('active');
    $(el).addClass('active');
    if (!$(el).parents().hasClass('popup-container')) toggleSelectBox(el);
}

function initSelects(block) {
    block.find('.chzn-done').next().remove();
    var chzns = block.find('.chzn-done');
    if (chzns.size() > 0) {
        chzns.each(function () {

            var s = $(this);
            s.removeClass('chzn-done').chosen({
                allow_single_deselect:s.hasClass('chzn-deselect')
            })

        });
    }
}
function confirmMessage(el, data, callback) {
    var d = {};
    for (var n in data) {
        d[data[n]['name']] = data[n]['value'];
    }
    if (callback)
        callback(el, d);
    var box = $(el).parents('.popup');
    box.find('.confirm-after').fadeIn();
    box.find('.confirm-before').hide();
    setTimeout(function () {
        $.fancybox.close()
    }, 1000)
}

function cl(value) {
    console.log(value);
}

$.fancybox.open = function (content) {
    var fancy = $('<a></a>').fancybox({content:content, showCloseButton:false, scrolling:false});
    fancy.trigger('click');
    $('#fancybox-wrap .chzn').chosen();
}

function navDrpOpen(el) {

    var li = $(el).parent();

    if (!li.hasClass('active')) {
        navDrpClose();
        li.addClass('active');
    } else {
        li.removeClass('active');
    }

}

function navDrpClose(el) {
    $('.navdrp.active').removeClass('active');
}

$.fn.toggleDisabled = function () {
    return this.each(function () {
        this.disabled = !this.disabled;
    });
};