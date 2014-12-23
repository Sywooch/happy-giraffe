define(['models/Model'], function(Model) {
    var Form = {
        validate: function(callback) {
            Model.get(this.validateUrl, { attributes: this.getValues() }).done(function(response) {
                self.fillErrors(response.data.errors);
                callback(response);
            }.bind(this));
        },
        fillErrors: function(errors) {
            console.log(errors);
            for (var attribute in this.fields) {
                if (errors[attribute] !== undefined) {
                    this.fields[attribute].errors(errors[attribute]);
                } else {
                    this.fields[attribute].errors([]);
                }
            }
        },
        getValues: function() {
            var values = {};
            for (var i in this.fields) {
                values[i] = this.fields[i].value();
            }
            return values;
        },
        setValues: function(values) {
            for (var key in values) {
                if (this.fields.hasOwnProperty(key)) {
                    this.fields[key].value(values[key]);
                }
            }
        }
    };

    return Form;
});