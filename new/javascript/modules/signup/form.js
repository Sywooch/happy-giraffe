define(['knockout', 'models/Model', 'signup/formField'], function(ko, Model, FormField) {
    var Form = {
        loading: ko.observable(false),
        disabled: ko.observable(true),
        validateDeffered: function validateDeffered(response) {
            if (response.success === true) {
                this.fillErrors(response.data.errors);
            }
            return response;
        },
        turnDisabled: function turnDisabled() {
            if (this.disabled() !== false) {
                this.disabled(false);
            }
        },
        validate: function validate() {
            this.loading(true);
            this.turnDisabled();
            return Model
                .get(this.validateUrl, { attributes: this.getValues() })
                .then(this.validateDeffered.bind(this));
        },
        fillErrors: function(errors) {
            var attribute;
            for (attribute in this.fields) {
                if (errors[attribute] !== undefined) {
                    this.fields[attribute].errors(errors[attribute]);
                } else {
                    this.fields[attribute].errors([]);
                }
            }
        },
        getValues: function() {
            var values = {};
            for (var key in this.fields) {
                values[key] = this.fields[key].value();
            }
            return values;
        },
        setValues: function(values) {
            for (var key in values) {
                if (this.fields.hasOwnProperty(key)) {
                    this.fields[key].value(values[key]);
                }
            }
        },
        clear: function() {
            for (var attribute in this.fields) {
                this.fields[attribute].value('');
            }
        },
        setFilled: function() {
            for (var attribute in this.fields) {
                this.fields[attribute].isFilled(true);
            }
        },
        submit: function(callback, validate) {
            this.loading(true);
            this.setFilled();
            if (validate) {
                this.validate(function(validateResponse) {
                    if (validateResponse.success) {
                        this.submitInternal(callback);
                    }
                });
            } else {
                this.submitInternal(callback);
            }
        },
        submitInternal: function(callback) {
            Model.get(this.submitUrl, { attributes: this.getValues() }).done(function(response) {
                callback(response);
                this.loading(false);
            });
        }
    };

    return Form;
});