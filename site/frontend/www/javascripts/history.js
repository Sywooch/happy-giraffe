var states = new Array();
function AjaxHistory(id) {
    this.id = id;
    var $this = this;
    var loadCallback = null;
    if(history.replaceState)
        history.replaceState({ path:window.location.href }, '');

    if(typeof(states[$this.id]) == 'undefined')
    {
        states[$this.id] = true;
        $(window).bind('popstate', function (event) {
            var state = event.originalEvent.state;
            if (state) {
                $this.load($this.id, state.path);
            }
        });
    }
}

AjaxHistory.prototype.changeBrowserUrl = function (url) {
    if(url == document.location.href)
        return;
    url = url.split("?");
    if (url[1]) {
        var query = new Array();
        var hash = url[1].split('#');
        var params = url[1].split("&");
        for (var i in params) {
            var param = params[i].split("=");
            // удаляем параметр ajax, т. к. он не должен передаваться в ссылке
            if (param[0] == "ajax" || param[0] == 'lastPage') {
                continue;
            }
            query[param[0]] = param[1];
        }
    }
    var path = this.buildUrl(url[0], query);
    if (hash != undefined && hash.length > 1)
        path += '#' + hash[1];
    if (typeof(window.history.pushState) == 'function') {
        window.history.pushState({path:path}, "", path);
    } else {
        document.location.href = path;
    }
    _gaq.push(['_trackPageview', path]);
    yaCounter11221648.hit(path);
};

// функция-аналог http_build_query в PHP
AjaxHistory.prototype.buildUrl = function (url, parameters) {
    var qs = "";
    for (var key in parameters) {
        var value = parameters[key];
        qs += key + "=" + value + "&";
    }
    if (qs.length > 0) {
        qs = qs.substring(0, qs.length - 1);
        url = url + "?" + qs;
    }
    return url;
};

AjaxHistory.prototype.load = function (id, url, callback) {
    var $this = this;
    if(this.loadCallback) {
        this.loadCallback(id, url);
        return true;
    }
    $.ajax({
        type:'GET',
        url:url,
        success:function (data) {
            id = '#' + id;
            $(id).replaceWith($(id, '<div>' + data + '</div>'));
            if (/#/.test(document.location.hash))
                document.location.hash = document.location.hash;
            if (callback)
                callback(id, url);
        }
    });
    return this;
};