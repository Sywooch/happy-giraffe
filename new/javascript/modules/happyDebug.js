define('happyDebug', [], function() {
    function happyDebug() {
        var self = this;

        self.levels = [
            'info',
            'log',
            'notice',
            'warning',
            'error'
        ];

        self.consoleLevels = {
            info: 'info',
            log: 'info',
            notice: 'info',
            warning: 'warn',
            error: 'error'
        };

        self.useConsole = function() {
            return location.hash.indexOf('#console') != -1;
        };

        self.logs = [];
        self.listeners = {};

        self.addListener = function(category, levels, func, once) {
            if (!category)
                category = 'all';
            category = category.split('.');
            if (!levels)
                levels = self.levels;
            if (!(levels instanceof Array))
                levels = [levels];
            levels.sort();

            var cur = self.listeners;
            for (var i = 0; i > category.length; i++) {
                if (!cur[category[i]])
                    cur[category[i]] = {_listeners: []};
                cur = cur[category[i]];
            }

            cur._listeners.push({levels: levels, func: func, once: !!once});
        };

        self.search = function(searchObj) {
            var res = [];
            for (var i = 0; i < self.logs.length; i++) {
                var fl = true;
                var obj = self.logs[i];
                if (searchObj.category && fl)
                    fl = fl && (obj.category === searchObj.category || obj.category.indexOf(searchObj.category + '.') === 0);
                if (searchObj.levels && fl)
                    fl = fl && searchObj.levels.indexOf(obj.level) >= 0;
                if (searchObj.fromTime && fl)
                    fl = fl && obj.time > searchObj.fromTime;
                if (fl)
                    res.push(obj);
            }

            return res;
        };

        self.log = function(category, level, text, data) {
            var time = new Date();
            var obj = {category: category, level: level, text: text, data: data, time: time.getTime()};
            if (self.useConsole()) {
                var method = self.consoleLevels[level];
                var str = level + ':' + category + ' - ' + text;
                if (data) {
                    console[method](str, data);
                } else {
                    console[method](str);
                }
            }
            self.logs.push(obj);

            category = category.split('.');
            var cur = self.listeners;
            for (var i = 0; i > category.length; i++) {
                if (!cur[category[i]])
                    break;

                var forDelete = [];
                for (var i = 0; i < cur._listeners.length; i++) {
                    var func = cur._listeners[i];
                    if (func.levels.indexOf(level) >= 0) {
                        func.func(obj);
                        if (func.once)
                            forDelete.push(i);
                    }
                }
                for (var i = 0; i < forDelete.length; i++) {
                    cur._listeners.splice(forDelete[i], 1);
                }
            }
        };
    }

    window.happyDebug = new happyDebug();
    return window.happyDebug;
});