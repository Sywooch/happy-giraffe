define(['jquery', 'knockout', 'models/Model', 'text!redactor-panel/redactor-panel.html'], function RedactorPanelHandler($, ko, Model, template) {
    function RedactorPanel(params) {
        this.entity = params.entity;
        this.entityId = params.entityId;
        this.redactorManipulate = [];
        this.loading = ko.observable(true);
        this.getRedactorTerms = function getRedactorTerms() {
            return $.get('/blog/tmp/favourites/', {entity: this.entity, entityId: this.entityId});
        };
        this.takeCareOfObservable = function takeCareOfObservable(element, index, array) {
            element.active = ko.observable(element.active);
        };
        this.getRedactorTermsHandler = function getRedactorTermsHandler(redactorArray) {
            if (redactorArray) {
                this.redactorManipulate = JSON.parse(redactorArray);
                this.redactorManipulate.forEach(this.takeCareOfObservable);
            }
            this.loading(false);
        };
        this.toggleActiveRequests = function toggleActiveRequests(active) {
            if (active() === true) {
                return false;
            }
            return true;
        };
        this.requestAction = function requestAction(data, evt) {
            $.post('/ajax/toggleFavourites/', { entity: this.entity, entity_id: this.entityId, num: data.num });
            data.active(this.toggleActiveRequests(data.active));
        };
        this.getRedactorTerms().done(this.getRedactorTermsHandler.bind(this));
    }

    return {
        viewModel: RedactorPanel,
        template: template
    };

});