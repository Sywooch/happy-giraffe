define(['jquery', 'knockout'], function sliderBindingHandler($, ko) {
    var Helpers = {
        checkStrings: function checkStrings(stringOne, stringTwo) {
            return stringOne === stringTwo;
        },
        getCurrentHash: function getCurrentHash() {
            return window.location.hash.slice(1);
        },
        checkUrlForHash: function checkUrlForHash(hash) {
            return this.checkStrings(this.getCurrentHash(), hash);
        }
    };
    return Helpers;
});