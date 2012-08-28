jQuery.extend(jQuery.expr[':'].Contains = function(a, i, m) {
    return (a.textContent || a.innerText || "").toUpperCase().indexOf(m[3].toUpperCase())>=0;
})

$(document).ready(function () {
    $.ajaxSetup({
        complete: function() {

        }
    });

    $('body').delegate('a.fancy', 'click', function () {
        Register.start = true;
        var onComplete_function = function () {
            if ($('.popup .chzn').size() > 0)
                $('.popup .chzn').each(function () {
                    var s = $(this);
                    s.chosen({
                        allow_single_deselect:s.hasClass('chzn-deselect')
                    });
                });
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

    if ($('.chzn').size() > 0) {
        $('.chzn').each(function () {
            var $this = $(this);
            $this.chosen({
                allow_single_deselect:$this.hasClass('chzn-deselect')
            })
        });
    }

    if ($('input[placeholder], textarea[placeholder]').size() > 0) $('input[placeholder], textarea[placeholder]').placeholder();

    $('body').click(function (e) {
        if (!$(e.target).parents().hasClass('navdrp'))
            navDrpClose();
        if (!$(e.target).parents().hasClass('visibility-picker'))
            albumVisibilityListToggle($('.visibility-list:visible'));
    })

    $('html').click(function() {
        $('.user-fast-nav .drp-list > ul:visible').hide();
    });

    $('body').on('click', '.user-fast-nav .more', function(event){
        event.stopPropagation();
    });


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
            });
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
    $('#fancybox-wrap .chzn').each(function () {
        var s = $(this);
        s.chosen({
            allow_single_deselect:s.hasClass('chzn-deselect')
        });
    });
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

function albumVisibilityListToggle(el) {
    var box = $(el).parents('.visibility-picker');
    box.find('.visibility-list').toggle();
}

function albumVisibilitySet(el, num, id) {

    var box = $(el).parents('.visibility-picker');

    box.find('> .album-visibility > span').each(function () {
        if ($(this).html() == '') $(this).remove();
    });

    for (var i = 3; i > num; i--) {
        box.find('> .album-visibility').prepend('<span></span>');
    }

    $.post(base_url + '/albums/changePermission/', {id:id, num:num});

    albumVisibilityListToggle(el);
}

function initScrolledContent() {
    var cpo = 0;
    $(window).scroll(function () {
        var cp = $('#checkpoint').offset().top;
        var st = $(window).scrollTop();
        if (!$('#morning').hasClass('morning-wide')) {
            if (st >= cp) {
                $('#morning').addClass('morning-wide')
                cpo = cp;
            }
        } else {
            if (st < cpo - 100) {
                $('#morning').removeClass('morning-wide')
            }
        }
    });
}

/*comet.addEvent(300, 'liveContents');

Comet.prototype.liveContents = function (result, id) {
    $.get(
        '/ajax/contentsLive/',
        {id:result.newId, containerClass:$('#contents_live').attr('class')},
        function (response) {
            var el = $(response).hide();
            $('#contents_live').prepend(el);
            $('#contents_live > :first').fadeIn(1000);
            $('#contents_live > :last').remove();
        }
    )
}*/

var PostGallery = {
    add:function (link) {
        $('.add-gallery').hide();
        var input_container = $(link).parents('.row-gallery:eq(0)').find('.gallery_input_container').show();
        $(link).parents('.row-gallery:eq(0)').find('.gallery_title_container').hide();
    },
    save:function (button) {
        var input_container = $(button).parent();
        var gallery_title_container = input_container.siblings('.gallery_title_container');
        var input = input_container.find('input');

        if (input.val() == '') {
            input.addClass('error');
            return false;
        } else {
            input.removeClass('error');
        }
        $('.form .row-gallery .gallery-photos').show();

        gallery_title_container.find('.gallery-title').text(input.val());
        input_container.hide();
        gallery_title_container.show();
        return false;
    },
    remove:function (link) {
        var input_container = $(link).parents('.row-gallery:eq(0)').find('.gallery_input_container');
        input_container.siblings('.gallery_title_container').hide().find('.gallery-title').text('');
        var input = input_container.find('input').val('');
        $('.add-gallery').show();
        $('.form .row-gallery .gallery-photos').hide();
        $('.form .row-gallery .gallery-photos li:lt(' + $('.form .row-gallery .gallery-photos li').size() + ')').remove();
        return false;
    }
}

function editPhotoTitleInWindow(link) {
    $(link).parent().hide().siblings('.title-edit').show();
    $(link).parent().hide().siblings('.title-edit').find('input, textarea').val($(link).siblings('.title-text').text());
}

function savePhotoTitleInWindow(button) {
    var val = $(button).siblings('input, textarea').val();
    if ($(button).siblings('input').size() > 0) {
        var attr = 'title';
        var entity = 'AlbumPhoto';
    } else {
        var attr = 'description';
        var entity = 'CookDecoration';
    }

    $(button).parent().hide().siblings('.title-content').show();
    $(button).parent().hide().siblings('.title-content').find('.title-text').text(val);
    $.post('/ajax/setValue/', {attribute:attr, value:val, entity:entity, entity_id:$('#photo-thumbs li.active a').attr('data-id')});
}

var Register = {
    url:null,
    start:false,
    step1:function(){
        $('.reg1').hide();
        $('.reg2').show();
        $('.regmail2').val($('.regmail1').val());
        $('.reg2 select').each(function () {
            $(this).trigger("liszt:updated");
        });
    },
    timer:function () {
        var obj = document.getElementById('reg_timer');
        obj.innerHTML--;
        if (obj.innerHTML == 0) {
            setTimeout(function () {
                if (Register.url != null){
                    console.log(Register.url);
                    window.location = Register.url;
                }
            }, 1000);
        }
        else {
            setTimeout(Register.timer, 1000);
        }
    },
    finish:function () {
        $('.reg2').hide();
        $('.reg3').show();
        setTimeout(Register.timer, 1000);
        $.post('/signup/finish/', $('#reg-form2').serialize(), function (response) {
            console.log(response);
            if (response.status) {
                Register.url = response.profile;
            }
        }, 'json');
    },
    showSocialStep2:function(){
        $('.register.fancy').trigger('click');
        $(".reg1").hide();
        $(".reg2").show();
        $(".email2-row").show();
    },
    showRegisterWindow:function(){
        setTimeout(function(){
            if (!Register.start){
                $('#reg-main-btn').trigger('click');
            }
        }, 3000);
    }
}

function ajaxSetValues(form, callback) {
    $.post($(form).attr('action'), $(form).serialize(), callback);
}

function getScrollBarWidth() {
    var inner = document.createElement('p');
    inner.style.width = "100%";
    inner.style.height = "200px";

    var outer = document.createElement('div');
    outer.style.position = "absolute";
    outer.style.top = "0px";
    outer.style.left = "0px";
    outer.style.visibility = "hidden";
    outer.style.width = "200px";
    outer.style.height = "150px";
    outer.style.overflow = "hidden";
    outer.appendChild (inner);

    document.body.appendChild (outer);
    var w1 = inner.offsetWidth;
    outer.style.overflow = 'scroll';
    var w2 = inner.offsetWidth;
    if (w1 == w2) w2 = outer.clientWidth;

    document.body.removeChild (outer);

    return (w1 - w2);
};

function slideNavToggle(el){
	
	var li = $(el).parent();
	var ul = li.parent();
	
	if (ul.find('ul:animated').size() == 0){
		if (!li.hasClass('toggled')){
			ul.find('> li.toggled').removeClass('toggled').find('>ul').slideUp();
			li.addClass('toggled').find('>ul').slideDown();			
		} else {
			li.removeClass('toggled').find('>ul').slideUp();
		}
	}
}

function firstStepsToggle(el){
	
	var box = $('#first-steps .block-in');
	
	if (box.is(':animated')) return false;
	
	if ($(el).hasClass('toggled')){
		box.slideUp(function(){
			$(el).find('span').html($(el).data('title'));
			$(el).prev('.bonus').toggle();
			$(el).removeClass('toggled');
			$('.user-status').removeClass('toggled');
		});
	} else {
		box.slideDown(function(){
			$(el).find('span').html($(el).data('close'));
			$(el).prev('.bonus').toggle();
			$(el).addClass('toggled');
			$('.user-status').addClass('toggled');
		});
	}
	
	
	
}

var PasswordRecovery = {
    send : function(form) {
        var button = $(form).find('input[type="submit"]');
        var f = function() {
            $('a[href="#login"]').trigger('click');
        }
        $.post($(form).attr('action'), $(form).serialize(), function(response) {
            $('.sent').html(response.message).show();
            if (response.status != 'error') {
                $(button).val('Вход на сайт');
                $(form).submit(function (e) {
                    e.preventDefault();
                    f();
                });
                setTimeout(f, 5000);
            }
        }, 'json');
    }
}