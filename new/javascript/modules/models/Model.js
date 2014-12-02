define(["jquery", "knockout", "models/User"], function ($, ko, User) {

    var Model = {

        /**
         * [get асинхронный запрос к api]
         * @param  {string} url        url к которому обращаемся
         * @param  {object} paramsData объект с данными для запроса к API
         * @return {$.ajax}            Возвращает объект $.ajax
         */
        get: function get(url, paramsData) {
            return $.ajax(
                {
                    type: 'POST',
                    url: url,
                    contentType: 'application/json; charset=UTF-8',
                    data:  JSON.stringify(paramsData),
                    dataType: 'json'
                }
            );
        },

        /**
         * [when асинхронный запрос к api]
         * @param ajaxOne
         * @param ajaxTwo
         * @returns {*}
         */
        when: function when(ajaxOne, ajaxTwo) {
            return $.when(ajaxOne, ajaxTwo);
        },

        findById: function findById(id, array) {
            var iterator;
            for (iterator = 0; iterator < array.length; iterator++) {
                if (id === array[iterator].id) {
                    return array[iterator];
                }
            }
            return false;
        },
        findByIdObservable: function findByIdObservable(id, array) {
            var iterator;
            for (iterator = 0; iterator < array.length; iterator++) {
                if (id === array[iterator].id()) {
                    return array[iterator];
                }
            }
            return false;
        },
        findByIdObservableIndex: function findByIdObservable(id, array) {
            var iterator;
            for (iterator = 0; iterator < array.length; iterator++) {
                if (id === array[iterator].id()) {
                    return { element: ko.observable(array[iterator]), index: ko.observable(iterator) };
                }
            }
            return false;
        },
        checkRights: function checkRights(externalId) {
            if (User.userId !== null) {
                if (parseInt(User.userId) === externalId) {
                    return true;
                }
            }
            return false;
        },
        apiUrlCreator: function apiUrlCreator(base, url) {
            return base + '/' + url + '/';
        },
        colorsArray: ['purple', 'yellow', 'carrot', 'green', 'blue'],
        returnNewColor: function returnNewColor(index) {
            return this.elementCssClass + this.colorsArray[($.inArray(this.colorsArray[index() % this.colorsArray.length], this.colorsArray)) % this.colorsArray.length];
        },
        stdProperty: {
            editing: ko.observable(false),
            value: ko.observable(null)
        },
        createStdProperty: function createStdProperty(value) {
            var stdProperty = Object.create({ editing: ko.observable(false), value: ko.observable(value) });
            return stdProperty;
        }
    };

    return Model;
});