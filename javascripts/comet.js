(function() {
    function f() {
        function Comet() {
            this.events = new Array();
            this.cache = null;
            this.channels = new Array('guest');
            this.load = true;
        }

        function CometProto() {
            var self = this;
            self.call = function(type, result, id) {
                for (var i in this.events[type]) {
                    var func = this.events[type][i];
                    if (this[func] != 'undefined')
                        this[func](result, id);
                }

            };
            self.connect = function(host, namespace, cache) {
                this.server = new Dklab_Realplexor(host, namespace);
                var $this = this;
                if (cache) {
                    $this.channels.push(cache);
                    $this.cache = cache;
                }
                for (var i in this.channels) {
                    this.server.subscribe($this.channels[i], function(result, id) {
                        $this.call(result.type, result, id);
                    });
                }
                this.reconnect();
            };
            self.addChannel = function(channel) {
                var $this = this;
                if ($this.channels.indexOf(channel) < 0) {
                    $this.channels.push(channel);
                    if ($this.server) {
                        $this.server.subscribe(channel, function(result, id) {
                            $this.call(result.type, result, id);
                        });
                        this.reconnect();
                    }
                }
            };
            self.delChannel = function(channel) {
                var $this = this;
                var i = $this.channels.indexOf(channel);
                if (i >= 0) {
                    $this.channels.splice(i, 1);
                    if ($this.server) {
                        $this.server.unsubscribe(channel, null);
                        this.reconnect();
                    }
                }
            };
            self.addEvent = function(type, event) {
                if (this.events[type] == undefined)
                    this.events[type] = new Array();
                this.events[type][this.events[type].length] = event;
            };
            self.delEvent = function(type, event) {
                removeA(this.events[type], event);
            };

            var timer = false;
            self.reconnect = function() {
                var $this = this;
                if(!timer) {
                    timer = setTimeout(function() {
                        $this.server.execute();
                        clearTimeout(timer);
                        timer = false;
                    }, 500);
                }
            };
        }

        Comet.prototype = new CometProto();
        window.Comet = Comet;
        return new Comet();
    }


    if (typeof define === 'function' && define['amd']) {
        define('comet', f);
    } else {
        window.comet = f();
    }
})(window);