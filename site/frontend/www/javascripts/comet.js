function Comet() {
    this.events = new Array();
    this.events[0] = ['testfunc'];
}

Comet.prototype.connect = function(host, namespace, cache) {
    this.server = new Dklab_Realplexor(host, namespace);
    this.server.subscribe(cache, function(result, id) {
        this.call(result.type, result, id);
    });
    this.server.execute();
}

Comet.prototype.call = function(type, result, id) {
    for(var i in this.events[type]) {
        var func = this.events[type][i];
        if(this[func] != 'undefined')
            this[func](result, id);
    }
}

Comet.prototype.addEvent = function(type, event) {
    this.events[type][this.events[type].length] = event;
}

var comet = new Comet;
$(function() {
    comet.connect("http://plexor.dev.happy-giraffe.ru", "hg_", "afed5");
});



// Example functions
Comet.prototype.testfunc = function(result, id) {
    cl(123);
}

// Custom function, ex.
Comet.prototype.testfunc2 = function(result, id) {
    cl(456);
}
comet.addEvent(0, 'testfunc2');




