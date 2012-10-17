var Social = {
    key:false,
    update_url:false,
    window:false,
    timer:false,
    model_name:false,
    model_id:false,
    api_url:false,
    ajax_url:false,
    elem:null,
    clicked:[],
    wait:function () {
        if (this.window && this.window.closed) {
            clearInterval(this.timer);
            this.getRate();
        }
    },
    open:function (key, url, title, width, height, elem) {
        this.key = key;
        this.elem = elem;
        var url = this.ajax_url + '?key=' + key + '&entity=' + this.model_name + '&entity_id=' + this.model_id + '&surl=' + encodeURIComponent(url);
        this.window = window.open(url, title, 'width=' + width + ',height=' + height);
        if (this.timer) {
            clearInterval(this.timer);
            this.timer = false;
        }
        this.timer = setInterval('Social.wait();', 100);
        this.clicked = [];
        return false;
    },
    getRate:function () {
        var params = {
            modelName:this.model_name,
            objectId:this.model_id,
            key:this.key
        };
        $.post(this.update_url.replace('rate', 'getRate'), params, function (response) {
                $(".like-block div.rating span").text(response.count);
                $(Social.elem).parent().find('.count').text(response.entity);
            },
            "json");
    },
    update:function (value, update, callback) {
        var params = {
            modelName:this.model_name,
            objectId:this.model_id,
            key:this.key,
            r:value ? value : 1
        };
        if (update)
            params.url = this.api_url;
        $.post(this.update_url, params, function (response) {
                $(".like-block div.rating span").text(response.count);
                $(Social.elem).parent().find('.count').text(response.entity);
                if (callback)
                    callback();
            },
            "json");
    },
    updateLikesCount:function (key) {
        if ($.inArray(key, this.clicked) == -1) {
            this.clicked.push(key);
            if (this.model_name == 'ContestWork') {
                $.post('/ajax/updateRating/', {modelName:this.model_name, objectId:this.model_id, key:key, url:location.href});
                var r = $('div.rating span');
                r.val(parseInt(r.val()) + 1)
            }
        }
    },
    showFacebookPopup:function (el) {
        Social.updateLikesCount('fb');
        var sTop = window.screen.height / 2 - (150);
        var sLeft = window.screen.width / 2 - (313);
        window.open(el.href, 'sharer', 'toolbar=0,status=0,width=626,height=300,top=' + sTop + ',left=' + sLeft);

        return false;
    }
}
$(function () {
    $('body').delegate('.yohoho_guest', 'click', function () {
        $.fancybox.open('<div class="popup-confirm popup">' +
            '<a class="popup-close" onclick="$.fancybox.close();" href="javascript:void(0);">Закрыть</a>' +
            '<div class="confirm-before">Чтобы проголосовать, вам нужно авторизоваться</div>' +
            '</div>');
    });
    $('body').delegate('.yohoho_me', 'click', function () {
        $.fancybox.open('<div class="popup-confirm popup">' +
            '<a class="popup-close" onclick="$.fancybox.close();" href="javascript:void(0);">Закрыть</a>' +
            '<div class="confirm-before">Вы не можете голосовать сами за себя</div>' +
            '</div>');
    });
    $('body').delegate('.yohoho_steps', 'click', function () {
        $('.contest-error-hint').show().delay(3000).fadeOut(2000);
    });
})