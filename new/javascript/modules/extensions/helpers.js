define(['jquery', 'knockout'], function sliderBindingHandler($, ko) {
    var Helpers = {
        checkStrings: function checkStrings(stringOne, stringTwo) {
            return stringOne === stringTwo;
        },
        getCurrentHash: function getCurrentHash() {
            return window.location.hash.slice(1);
        },
        checkPropertiesInArrayForEquality: function checkPropertiesInArrayForEquality(arrayItem, propertyArray, propertyGiven) {
            if (propertyArray === propertyGiven) {
                return arrayItem;
            }
        },
        findByProperty: function findByProperty(propertyName, value, array) {
            var arrayKey;
            for (arrayKey in array) {
                if (ko.isObservable(array[arrayKey][propertyName])) {
                    if (array[arrayKey][propertyName]() === value) {
                        return array[arrayKey];
                    }
                } else {
                    if (array[arrayKey][propertyName] === value) {
                        return array[arrayKey];
                    }
                }
            }
            return false;
        },
        findByPropertyReturnIndex: function findByPropertyReturnIndex(propertyName, value, array) {
            var arrayKey;
            for (arrayKey in array) {
                if (ko.isObservable(array[arrayKey][propertyName])) {
                    if (array[arrayKey][propertyName]() === value) {
                        console.log(array[arrayKey]);
                        return { element: ko.observable(array[arrayKey]), index: ko.observable(parseInt(arrayKey)) };
                    }
                } else {
                    if (array[arrayKey][propertyName] === value) {
                        return { element: array[arrayKey], index: parseInt(arrayKey) };
                    }
                }
            }
            return false;
        },
        checkUrlForHash: function checkUrlForHash(hash) {
            return this.checkStrings(this.getCurrentHash(), hash);
        }
    };
    return Helpers;
});