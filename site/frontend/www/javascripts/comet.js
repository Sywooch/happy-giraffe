function Comet() {
    this.events = new Array();
}

Comet.prototype.call = function(type, result, id) {
    if(this.events[type] == undefined)
        this.events[type] = new Array();
    for(var i in this.events[type]) {
        var func = this.events[type][i];
        if(this[func] != 'undefined')
            this[func](result, id);
    }
}

Comet.prototype.connect = function(host, namespace, cache) {
    this.server = new Dklab_Realplexor(host, namespace);
    var $this = this;
    this.server.subscribe(cache, function(result, id) {
        $this.call(result.type, result, id);
    });
    this.server.execute();
}

Comet.prototype.addEvent = function(type, event) {
    this.events[type][this.events[type].length] = event;
}

var comet = new Comet;