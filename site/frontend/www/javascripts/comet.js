function Comet() {
    this.events = new Array();
    this.events[0] = [];
    this.events[1] = [];
    this.events[2] = [];
    this.events[3] = [];
    this.events[4] = [];
    this.events[5] = [];
    this.events[6] = [];
    this.events[7] = [];
    this.events[8] = [];
    this.events[9] = [];
    this.events[10] = [];

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
    this.server.subscribe(cache, function(result, id) {
        $this.call(result.type, result, id);
    });
    this.server.execute();
}

Comet.prototype.addEvent = function(type, event) {
    this.events[type][this.events[type].length] = event;
}

var comet = new Comet;

/*Comet.prototype.testfunc = function(result, id) {
    cl(123);
}

// Custom function, ex.
Comet.prototype.testfunc2 = function(result, id) {
    cl(456);
}
comet.addEvent(0, 'testfunc2');*/




