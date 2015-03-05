define(["jquery", "knockout", 'extensions/helpers'], function ($, ko, Helpers) {
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
            return Helpers.findByProperty('id', id, array);
        },
        findByIdObservable: function findByIdObservable(id, array) {
            return Helpers.findByProperty('id', id, array);
        },
        findByIdObservableIndex: function findByIdObservable(id, array) {
            return Helpers.findByPropertyReturnIndex('id', id, array);
        },
        checkFieldsToPass: function checkFieldsToPass(fieldsNames, object) {
            var returnableObject = {};
                for (var i=0; i < fieldsNames.length; i++) {
                    if (object[fieldsNames[i]] !== undefined) {
                        if (object[fieldsNames[i]].value() !== null && object[fieldsNames[i]].value() !== undefined && object[fieldsNames[i]].value() !== '') {
                            if (object[fieldsNames[i]].value() === 'null') {
                                object[fieldsNames[i]].value(null);
                            }
                            returnableObject[fieldsNames[i]] = object[fieldsNames[i]].value();
                        }
                    }
                }
            return returnableObject;
        },
        apiUrlCreator: function apiUrlCreator(base, url) {
            return base + '/' + url + '/';
        },
        colorsArray: ['purple', 'yellow', 'carrot', 'green', 'blue'],
        returnNewColor: function returnNewColor(index) {
            return this.elementCssClass + this.colorsArray[($.inArray(this.colorsArray[index() % this.colorsArray.length], this.colorsArray)) % this.colorsArray.length];
        },
        stdProperty: {
            editing: ko.observable(true),
            value: ko.observable(null)
        },
        createStdProperty: function createStdProperty(value, name) {
            var stdProperty = Object.create({ editing: ko.observable((value !== null && value !== 'null-null-null' && ($.isEmptyObject(value) === false || $.isPlainObject(value) === false)) ? false : true), value: ko.observable(value), name: name, errors: ko.observableArray([]) });
            return stdProperty;
        }
    };
    return Model;
});