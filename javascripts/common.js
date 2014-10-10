function unique(arr) {
    var hash = {}, result = [];
    for ( var i = 0, l = arr.length; i < l; ++i ) {
        if ( !hash.hasOwnProperty(arr[i]) ) { //it works with objects! in FF, at least
            hash[ arr[i] ] = true;
            result.push(arr[i]);
        }
    }
    return result;
}

function declOfNum(number, titles) {
    cases = [2, 0, 1, 1, 1, 2];
    return titles[ (number % 100 > 4 && number % 100 < 20) ? 2 : cases[(number % 10 < 5) ? number % 10 : 5] ];
}

function removeA(arr) {
    var what, a = arguments, L = a.length, ax;
    while (L > 1 && arr.length) {
        what = a[--L];
        while ((ax = arr.indexOf(what)) != -1) {
            arr.splice(ax, 1);
        }
    }
    return arr;
}

$.fn.exists = function(callback) {
    var args = [].slice.call(arguments, 1);

    if (this.length) {
        callback.call(this, args);
    }

    return this;
};

$(document).ready(function () {

    $(document).ajaxComplete(function(event, xhr, settings) {
        var isJson = true;
        try {
            var json = $.parseJSON(xhr.responseText);
        } catch(e) {
            isJson = false;
        }
        if (isJson && json !== null && json.hasOwnProperty('errors')) {
            $('.error-serv_hold').html('');
            jQuery.each(json.errors, function(i, val) {
                $('.error-serv_hold').append('<p>' + val + '</p>');
            });
            $('#popup-error-link').trigger('click');
        }
    });

    $('a.article-settings_a__edit').exists(function changePurposeOfRedacting (){
        $('a.article-settings_a__edit').each(function () {
            var $this = $(this);
            $.post('/editorialDepartment/redactor/urlForEdit/?entityId=' + $(this).data('id'))
                .done(function (data) {
                    var urlObj = JSON.parse(data);
                    $this
                        .removeClass('fancy-top')
                        .attr('href', urlObj.url);

                });
        });
        });



    $(".wysiwyg-content").addtocopy({htmlcopytxt:'<br /><br />Подробнее: <a href="' + window.location.href + '">' + window.location.href + '</a>'});

    /* видео с youtube, что б не перекрывало всплывающие окна */
    $("iframe").each(function(){
        var ifr_source = $(this).attr('src');
        if (ifr_source !== undefined){
            var wmode = "wmode=transparent";
            if(  ifr_source.indexOf('youtube.com')>-1 ) {
                if(ifr_source.indexOf('?') != -1) {
                    var getQString = ifr_source.split('?');
                    var oldString = getQString[1];
                    var newString = getQString[0];
                    $(this).attr('src',newString+'?'+wmode+'&'+oldString);
                }
                else $(this).attr('src',ifr_source+'?'+wmode);
            }
        }
    });

    $(window).scroll(function () {
        var contanerScroll = $(window).scrollTop();
        if (contanerScroll > $('.layout-header').height()) {
            $('#btn-up-page').fadeIn(600);
        } else {
            $('#btn-up-page').fadeOut(600)
        }
    });

     /* Подсказки при наведении */
    $('.powertip').powerTip({
        placement: 'n',
        /*smartPlacement: true,*/
        offset: 5
    });

    $('.js-powertip-white').powerTip({
        placement: 'n',
        smartPlacement: true,
        popupId: 'powertip-white',
        offset: 8
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
            overlayColor:'#2d1a3f',
            overlayOpacity:'0.6',
            padding:0,
            showCloseButton:false,
            centerOnScroll:true,
            titleShow:false,
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

});

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

$.fn.toggleDisabled = function () {
    return this.each(function () {
        this.disabled = !this.disabled;
    });
};

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

var Register = {
    url:null,
    start:false,
    show_window_delay:3000,
    show_window_type:'',
    attributes:{},
    redirectUrl:'',
    gotoComment:'',
    step1:function () {
        $('.reg1').hide();
        $('.reg2').show();
        $('.regmail2').val($('.regmail1').val());
        $('.reg2 select').each(function () {
            $(this).trigger("liszt:updated");
        });
    },
    showStep2:function (email, type, attributes) {
        Register.attributes['email'] = email;
        Register.attributes['type'] = type;
        if (Register.redirectUrl != '')
            Register.attributes['redirectUrl'] = Register.redirectUrl;
        if (Register.gotoComment != '')
            Register.attributes['gotoComment'] = Register.gotoComment;
        if (typeof attributes != 'undefined')
            for (i in attributes)
                Register.attributes[i] = attributes[i];
        $.post('/signup/showForm/', Register.attributes, function (response) {
            var link = $('#hidden_register_link');
            link.attr('href', '#register');
            link.trigger('click');

            $('#register').find('#register-step1').hide();
            $('#register').find('.other-steps').html(response);
            $('#register').find('.chzn').each(function () {
                var $this = $(this);
                $this.chosen({
                    allow_single_deselect:$this.hasClass('chzn-deselect')
                })
            });
        });
    },
    timer:function () {
        var obj = document.getElementById('reg_timer');
        obj.innerHTML--;
        if (obj.innerHTML == 0) {
            setTimeout(function () {
                if (Register.url != null) {
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
//        $('.reg2').hide();
//        $('.reg3').show();
//        setTimeout(Register.timer, 1000);
        $.post('/signup/finish/', $('#reg-form2').serialize(), function (response) {
//            console.log(response);
            if (response.status) {
                window.location = response.url;
//                Register.url = response.profile;
            }
        }, 'json');
    },
    showRegisterWindow:function () {
        setTimeout(function () {
            if (!Register.start) {
                console.log(Register.show_window_type);
                var link = $('#hidden_register_link');

                if (Register.show_window_type == 'pregnancy')
                    link.attr('href', '#pregnancy-calendar-self');
                else if (Register.show_window_type == 'odnoklassniki')
                    link.attr('href', '#reg-odnoklassniki');
                else
                    link.attr('href', '#register');

                link.trigger('click');
            }
        }, Register.show_window_delay);
    },
    SetAttribute:function (attribute, value) {
        Register.attributes[attribute] = value;
    }
}

function ajaxSetValues(form, callback) {
    $.post($(form).attr('action'), $(form).serialize(), callback);
}

function slideNavToggle(el) {

    var li = $(el).parent();
    var ul = li.parent();

    if (ul.find('ul:animated').size() == 0) {
        if (!li.hasClass('toggled')) {
            ul.find('> li.toggled').removeClass('toggled').find('>ul').slideUp();
            li.addClass('toggled').find('>ul').slideDown();
        } else {
            li.removeClass('toggled').find('>ul').slideUp();
        }
    }
}

var PasswordRecovery = {
    send:function (form) {
        var button = $(form).find('input[type="submit"]');
        var f = function () {
            $('a[href="#login"]').trigger('click');
        }
        $('#login-retrieve .recovery-success').hide();
        $('#login-retrieve .recovery-fail').hide();
        $.post($(form).attr('action'), $(form).serialize(), function (response) {
            if (response.success) {
                $('#login-retrieve .recovery-success').show();
                $(form).submit(function (e) {
                    e.preventDefault();
                    f();
                });
                setTimeout(f, 5000);
            } else
                $('#login-retrieve .recovery-fail').show();
        }, 'json');
    }
}

var Contest = {
    canParticipate:function (el, url) {

        $.get(url, function (data) {
            switch (data.status) {
                case 10:
                    $('[href="#register"]').trigger('click');
                    break;
                case 11:
                    $(el).after($('#oopsTmpl').tmpl({id:data.id}));
                    $('.contest-error-hint').delay(3000).fadeOut(2000);
                    break;
                default:
                    document.location.href = $(el).attr('href');
            }
        }, 'json');
    }
};

var Horoscope = {
    zodiac_list:['aries', 'taurus', 'gemini', 'cancer', 'leo', 'virgo', 'libra', 'scorpio', 'sagittarius', 'capricorn', 'aquarius', 'pisces'],
    calc:function () {
        document.location.href = '/horoscope/compatibility/' + Horoscope.zodiac_list[$('#HoroscopeCompatibility_zodiac1').val() - 1] + '/' + Horoscope.zodiac_list[$('#HoroscopeCompatibility_zodiac2').val() - 1] + '/';
    },
    ZodiacChange:function (elem) {
        var val = $(elem).val();
        if (val == '')
            val = 0;
        $(elem).parents('div.sign').find('.img img').attr('src', '/images/widget/horoscope/big/' + val + '.png')
    },
    showSelect:function (el) {
        $(el).parents('div.sign').removeClass("zodiac-empty");
        $(el).next().show();
        $(el).parents('div.sign').find('.chzn-drop').css({
            "left":"0"
        });
    },
    show:function () {
        $('.user-horoscope-prev').hide();
        $('.user-horoscope-2').show();
        $.post('/horoscope/viewed/');
    }
};

function service_used(id) {
    $.post('/ajax/serviceUsed/', {id:id});
}

var Cook = {
    bookRecipe:function (el) {
        var recipe_id = $(el).data('id');
        $.post('/cook/recipe/book/', {recipe_id:recipe_id}, function (response) {
            if (response.status) {
                if (response.result == 1)
                    $(el).html('<span>Рецепт в моей <br>кулинарной книге</span><i class="icon-exist"></i>');
                else
                    $(el).html('<span>Добавить в мою <br>кулинарную книгу</span><i class="icon-add"></i>');

                $('#cookbook-recipe-count').html(response.count);
            }
        }, 'json');
    }
}

function showLoginWindow() {
    $('a[href="#login"]').trigger('click');
}

function SeCounter() {
    var domain = location.protocol + '//' + location.host;
    if (document.referrer.indexOf(domain) != 0 && document.referrer != '')
        $.post("/counter/", {referrer:document.referrer});
}

function HGoTo(elem) {
    var elem = $('#' + elem);
    $('.layout-container').animate({scrollTop:elem.offsetTop + 100}, "fast");
    elem.trigger('click');
}

function openPopup(el) {
    window.open($(el).attr('href'), '', 'toolbar=0,status=0,width=626,height=436');
    return false;
}

function FriendButtonViewModel(data) {
    var self = this;

    //console.log(data);

    self.id = data.id;
    self.status = ko.observable(data.status);

    self.invite = function() {
        $.post('/friendRequests/send/', { to_id : self.id }, function(response) {
            if (response.status)
                self.status(3);
        }, 'json');
    };

    self.accept = function() {
        $.post('/friends/requests/accept/', { fromId : self.id }, function(response) {
            if (response.success)
                self.status(1);
        }, 'json');
    }

    self.cancel = function() {
        $.post('/friends/requests/cancel/', { toId : self.id }, function(response) {
            if (response.success)
                self.status(2);
        }, 'json');
    }

    self.clickHandler = function() {
        switch (self.status()) {
            case 1:
                return true;
            case 2:
                self.invite();
                break;
            case 4:
                self.accept();
            case 3:
                self.cancel();
        }
    };

    self.cssClass = ko.computed(function() {
        switch (self.status()) {
            // уже в друзьях
            case 1:
                return 'user-btns_ico-hold__friend';
            // можно отправить приглашение
            case 2:
            // можно подтвердить приглашение
            case 4:
                return 'user-btns_ico-hold__friend-add';
            // приглашение отправленно
            case 3:
                return 'user-btns_ico-hold__friend-added'
        }
    });

    self.bubbleCssClass = ko.computed(function() {
        switch (self.status()) {
            case 1:
                return 'b-ava-large_bubble__friend-onhover';
            case 2:
            case 4:
                return 'b-ava-large_bubble__friend-add';
            case 3:
                return 'b-ava-large_bubble__friend-added';
        }
    });

    self.iconCssClass = ko.computed(function() {
        switch (self.status()) {
            case 1:
                return 'b-ava-large_ico__friend';
            case 2:
            case 4:
                return 'b-ava-large_ico__friend-add';
            case 3:
                return 'b-ava-large_ico__friend-added';
        }
    });

    self.tip = ko.computed(function() {
        switch (self.status()) {
            case 1:
                return '';
            case 2:
            case 4:
                return 'Добавить в друзья';
            case 3:
                return 'Отменить приглашение'
        }
    });
}

function HgLike(el, entity, entity_id){
    $.post('/ajaxSimple/like/', {entity: entity, entity_id: entity_id}, function (response) {
        if (response.status) {
            if ($(el).hasClass('active')){
                $(el).text(parseInt($(el).text()) - 1);
            }else{
                $(el).text(parseInt($(el).text()) + 1);
            }
            $(el).toggleClass('active');
        }
    }, 'json');
}

function HgLikeSmall(el, entity, entity_id){
    $.post('/ajaxSimple/like/', {entity: entity, entity_id: entity_id}, function (response) {
        if (response.status) {
            if ($(el).find('.ava-list_like-hg').hasClass('active')){
                $(el).find('.count').text(parseInt($(el).text()) - 1);
            }else{
                $(el).find('.count').text(parseInt($(el).text()) + 1);
            }
            $(el).find('.ava-list_like-hg').toggleClass('active');
            $(el).find('.andyou').toggle();
        }
    }, 'json');
}

//блок поиска
$(function() {
    SiteSearch.init();

    $('body').delegate('a.js-hg_alert', 'click', function(e){
        $(this).next().fadeIn(200).delay(2000).fadeOut(200);
        e.preventDefault();
    });

    $('body').delegate('a.fancy-top', 'click', function (e) {
    var onComplete_function2 = function () {
        var scTop = $(document).scrollTop();
        var box = $('#fancybox-wrap');

        boxTop = parseInt(Math.max(scTop + 40));
        box.stop().animate({'top' : boxTop}, 200);
    };

    $(this).clone().fancybox({
        overlayColor:'#2d1a3f',
        overlayOpacity:'0.6',
        padding:0,
        enableKeyboardNav: false,
        showCloseButton:false,
        centerOnScroll:false,
        hideOnOverlayClick:false,
        onComplete:onComplete_function2,
        enableKeyboardNav:false
    }).trigger('click');
        e.preventDefault();
    });
});

var SiteSearch = {
    init:function(){
        if ($('#site-search').val() != '')
            $('#site-search-btn').addClass('active');
    },
    keyUp: function(event, el){
        if(event.keyCode == 13){
            SiteSearch.click();
        }else{
            if ($(el).val() != '')
                $('#site-search-btn').addClass('active');
            else
                $('#site-search-btn').removeClass('active');
        }
    },
    click:function(){
        if ($('#site-search').val() != ''){
            $('#site-search').val('');
            $('#site-search-btn').removeClass('active');
            return false;
        }
        return true;
    }
}

var AddMenu = {
    select: function (el, type, club) {
        if (club == '')
            var url = '/blog/form/type' + type + '/';
        else
            var url = '/blog/form/type' + type + '/?club_id='+club;
        $.post(url, {'short': 1}, function (response) {
            var $formContainer = $(response).find('#add_form_container'),
                $scriptContainer = $(response).filter('script');

             $('#add_form_container')
                .html(
                    $formContainer.html() + '<script>' + $scriptContainer.text() + '</script>'
                );

            $('.js_add_menu a').removeClass('active');
            $(el).addClass('active');
        });
        return false;
    }
}

var DateRange = {
    days : function() {
        var daysRange = [];
        for (var i = 1; i <= 31; i++)
            daysRange.push(i);
        return daysRange;
    },
    months : function() {
        return [
            { id : 1, name : 'Января' },
            { id : 2, name : 'Февраля' },
            { id : 3, name : 'Марта' },
            { id : 4, name : 'Апреля' },
            { id : 5, name : 'Мая' },
            { id : 6, name : 'Июня' },
            { id : 7, name : 'Июля' },
            { id : 8, name : 'Августа' },
            { id : 9, name : 'Сентября' },
            { id : 10, name : 'Октября' },
            { id : 11, name : 'Ноября' },
            { id : 12, name : 'Декабря' }
        ];
    },
    years : function(min, max) {
        var yearsRange = [];
        for (var i = max; i >= min; i--)
            yearsRange.push(i);
        return yearsRange;
    }
}