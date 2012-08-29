function Comet() {
    this.events = new Array();
    this.cache = null;
    this.load = true;
}

Comet.prototype.call = function(type, result, id) {
    for(var i in this.events[type]) {
        var func = this.events[type][i];
        if(this[func] != 'undefined')
            this[func](result, id);
    }

}

Comet.prototype.connect = function(host, namespace, cache) {
    this.server = new Dklab_Realplexor(host, namespace);
    var $this = this;
    this.cache = cache;
    if (cache) {
        this.server.subscribe(cache, function(result, id) {
            $this.call(result.type, result, id);
        });
    }
    this.server.subscribe('guest', function(result, id) {
        $this.call(result.type, result, id);
    });
    this.server.execute();
}

Comet.prototype.addEvent = function(type, event) {
    if(this.events[type] == undefined)
        this.events[type] = new Array();
    this.events[type][this.events[type].length] = event;
}

Comet.prototype.delEvent = function(type, event) {
    removeA(this.events[type], event);
}

var comet = new Comet;
