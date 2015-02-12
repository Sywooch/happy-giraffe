define(['knockout', 'models/Model', 'text!ads-toggle/ads-toggle.html'], function(ko, Model, template) {
    function ToggleWidget(params) {
        console.log(params);

        this.active = ko.observable(params.isActive);
        this.loading = ko.observable(false);

        this.toggle = function toggle() {
            this.loading(true);
            Model.get('/api/ads/toggle/', params.params).done(function(obj) {
                this.loading(false);
                if (obj.success) {
                    this.active(! this.active());
                }
            }.bind(this));
        }
    }

    return {
        viewModel: ToggleWidget,
        template: template
    };
});