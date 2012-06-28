$(document).ready(function () {
    $('a.fancy').fancybox({
        overlayColor:'#000',
        overlayOpacity:'0.6',
        padding:0,
        showCloseButton:false,
        scrolling:false
    });

    $('table.common_sett a, .add_main_ct, .add_paket, .addValue, .content a').tooltip({
        track:true,
        delay:0,
        showURL:false,
        fade:200
    });

    jQuery(".niceCheck").each(
        /* при загрузке страницы меняем обычные на стильные checkbox */
        function () {
            changeCheckStart(jQuery(this));
        });

    $('.small_foto div').click(function () {
        var Input = basename($(this).children('img').attr('src'));
        $('.big_foto').find('a').attr({ href:'/upload/catalog/product/' + Input});
        $('.big_foto').find('img').attr({ src:'/upload/catalog/product/thumb/' + Input});
        return false;
    });

    function basename(path) {
        parts = path.split('/');
        return parts[parts.length - 1];
    }

});

function RefreshTooltip(elem) {
    elem.tooltip({
        track:true,
        delay:0,
        showURL:false,
        fade:200
    });
}


function changeCheck(el)
    /*
     функция смены вида и значения чекбокса при клике на контейнер чекбокса (тот, который отвечает за новый вид)
     el - span контейнер для обычного чекбокса
     input - чекбокс
     */ {

    var el = el,
        input = el.find("input").eq(0);

    if (el.attr("class").indexOf("niceCheckDisabled") == -1) {
        if (!input.attr("checked")) {
            el.addClass("niceChecked");
            input.attr("checked", true);
        } else {
            el.removeClass("niceChecked");
            input.attr("checked", false).focus();
        }
    }

    return true;
}

function changeVisualCheck(input) {
    /*
     меняем вид чекбокса при смене значения
     */
    var wrapInput = input.parent();
    if (!input.attr("checked")) {
        wrapInput.removeClass("niceChecked");
    }
    else {
        wrapInput.addClass("niceChecked");
    }
}

function changeCheckStart(el)
    /*
     новый чекбокс выглядит так <span class="niceCheck"><input type="checkbox" name="[name check]" id="[id check]" [checked="checked"] /></span>
     новый чекбокс получает теже name, id и другие атрибуты что и были у обычного
     */ {

    try {
        var el = el,
            checkName = el.attr("name"),
            checkId = el.attr("id"),
            checkChecked = el.attr("checked"),
            checkDisabled = el.attr("disabled"),
            checkTab = el.attr("tabindex"),
            checkValue = el.attr("value");
        if (checkChecked)
            el.after("<span class='niceCheck niceChecked'>" +
                "<input type='checkbox'" +
                "name='" + checkName + "'" +
                "id='" + checkId + "'" +
                "checked='" + checkChecked + "'" +
                "value='" + checkValue + "'" +
                "tabindex='" + checkTab + "' /></span>");
        else
            el.after("<span class='niceCheck'>" +
                "<input type='checkbox'" +
                "name='" + checkName + "'" +
                "id='" + checkId + "'" +
                "value='" + checkValue + "'" +
                "tabindex='" + checkTab + "' /></span>");

        /* если checkbox disabled - добавляем соотвсмтвующи класс для нужного вида и добавляем атрибут disabled для вложенного chekcbox */
        if (checkDisabled) {
            el.next().addClass("niceCheckDisabled");
            el.next().find("input").eq(0).attr("disabled", "disabled");
        }

        /* цепляем обработчики стилизированным checkbox */
        el.next().bind("mousedown", function (e) {
            changeCheck(jQuery(this))
        });
        el.next().find("input").eq(0).bind("change", function (e) {
            changeVisualCheck(jQuery(this))
        });
        if (jQuery.browser.msie) {
            el.next().find("input").eq(0).bind("click", function (e) {
                changeVisualCheck(jQuery(this))
            });
        }
        el.remove();
    }
    catch (e) {
        // если ошибка, ничего не делаем
    }

    return true;
}

/*    ConfirmPopup      */
var confirm_popup = null;
$('html').delegate('#confirm_popup .popup_question input.agree', 'click', function () {
    $.fancybox.close();
    confirm_popup.callback(confirm_popup.sender);
});

$('html').delegate('#confirm_popup .popup_question input.disagree', 'click', function () {
    $.fancybox.close();
});

function ConfirmPopup(text, sender, callback) {
    $('#confirm_popup .popup_question span').text(text);
    $('#confirm_popup_link').trigger('click');
    this.callback = callback;
    this.sender = sender;
    confirm_popup = this;
}

function ChangeUserPassword(el, id) {
    $.post('/userRoles/changePassword', {id:id}, function (response) {
        if (response.status) {
            $(el).next().html(response.result);
        }
    }, 'json');
}

$.fancybox.open = function (content) {
    var fancy = $('<a></a>').fancybox({content:content, showCloseButton:false, scrolling:false});
    fancy.trigger('click');
    $('#fancybox-wrap .chzn').each(function() {
        var s = $(this);
        s.chosen({
            allow_single_deselect:s.hasClass('chzn-deselect')
        });
    });
}