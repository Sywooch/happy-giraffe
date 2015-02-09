define(['jquery', 'knockout'], function sliderBindingHandler($, ko) {
    var Helpers = {
        checkStrings: function checkStrings(stringOne, stringTwo) {
            return stringOne === stringTwo;
        },
        getCurrentHash: function getCurrentHash() {
            return window.location.hash.slice(1);
        },
        findByProperty: function findByProperty(propertyName, value, array) {
            var arrayKey;
            for (arrayKey in array) {
                if (array[arrayKey][propertyName] === value) {
                    return array[arrayKey];
                }
            }
            return false;
        },
        checkUrlForHash: function checkUrlForHash(hash) {
            return this.checkStrings(this.getCurrentHash(), hash);
        },
        fireMethodOnHash: function fireMethodOnHash(hash, method) {
            if (this.checkUrlForHash(hash)) {
                method();
            }
        }
    };
    return Helpers;
});