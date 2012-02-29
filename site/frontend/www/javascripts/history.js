function AjaxHistory(id) {
    this.id = id;
    var $this = this;
    history.replaceState({ path:window.location.href }, '');
    $(window).bind('popstate', function (event) {
        var state = event.originalEvent.state;
        if (state) {
            $this.load($this.id, state.path);
        }
    });
}

AjaxHistory.prototype.changeBrowserUrl = function (url) {
    var url = url.split("?");
    if (url[1]) {
        var query = new Array();
        var params = url[1].split("&");
        for (i in params) {
            var param = params[i].split("=");
            // удаляем параметр ajax, т. к. он не должен передаваться в ссылке
            if (param[0] == "ajax" || param[0] == 'lastPage') {
                continue;
            }
            query[param[0]] = param[1];
        }
    }
    if (history.replaceState) {
        window.history.pushState({path : this.buildUrl(url[0], query)}, "", this.buildUrl(url[0], query));
    }
}

// функция-аналог http_build_query в PHP
AjaxHistory.prototype.buildUrl = function (url, parameters) {
    var qs = "";
    for (var key in parameters) {
        var value = parameters[key];
        qs += key + "=" + encodeURIComponent(value) + "&";
    }
    if (qs.length > 0) {
        qs = qs.substring(0, qs.length - 1);
        url = url + "?" + qs;
    }
    return url;
}

AjaxHistory.prototype.load = function (id, url) {
    $.ajax({
        type:'GET',
        url:url,
        success:function (data) {
            id = '#' + id;
            $(id).replaceWith($(id, '<div>' + data + '</div>'));
        }
    });
    return this;
}