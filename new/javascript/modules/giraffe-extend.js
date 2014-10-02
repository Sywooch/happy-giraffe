define('giraffe-extend', ["knockout"], function(ko) {
    return function(a, b) {
        if(!a.addGiraffeExtends) {
            a.giraffeExtends = new Array();
            a.addGiraffeExtends = function(className) {
                this.giraffeExtends.push(className);
            };
        }
        var className = b.constructor;
        if(className && a.giraffeExtends.indexOf(className) === -1) {
            ko.utils.extend(a, b);
        }
    };
});