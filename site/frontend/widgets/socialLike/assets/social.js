var Social = {
    key : false,
    update_url : false,
    window : false,
    timer : false,
    model_name : false,
    model_id : false,
    api_url : false,
    ajax_url : false,
    elem : null,
    wait : function() {
        if (this.window && this.window.closed) {
            clearInterval(this.timer);
            this.getRate();
        }
    },
    open : function(key, url, title, width, height, elem) {
        this.key = key;
        this.elem = elem;
        var url = this.ajax_url + '?key=' + key + '&entity=' + this.model_name + '&entity_id=' + this.model_id + '&surl=' + url;
        this.window = window.open(url, title, 'width='+width+',height='+height);
        if(this.timer) {
            clearInterval(this.timer);
            this.timer = false;
        }
        this.timer = setInterval('Social.wait();', 100);
        return false;
    },
    getRate : function() {
        var params = {
            modelName : this.model_name,
            objectId : this.model_id,
            key : this.key
        };
        $.post(this.update_url.replace('rate', 'getRate'), params, function(response) {
            $(".like-block div.rating span").text(response.count);
            $(Social.elem).parent().find('.count').text(response.entity);
        },
        "json");
    },
    update : function(value, update, callback) {
        var params = {
            modelName : this.model_name,
            objectId : this.model_id,
            key : this.key,
            r : value ? value : 1
        };
        if(update)
            params.url = this.api_url;
        $.post(this.update_url, params, function(response) {
            $(".like-block div.rating span").text(response.count);
            $(Social.elem).parent().find('.count').text(response.entity);
            if(callback)
                callback();
        },
        "json");
    }
}