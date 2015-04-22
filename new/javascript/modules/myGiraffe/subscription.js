define(['jquery', 'knockout', 'text!myGiraffe/subscription.html'], function($, ko, template) {
    function SubscriptionView() {
        var self = this;

        self.clubIds = ko.observableArray([]);

        self.toggle = function(clubId) {
            if (self.clubIds.indexOf(clubId) < 0) {
                self.clubIds.push(clubId);
            } else {
                self.clubIds.remove(clubId);
            }

        };

        self.isActive = function(clubId) {
            return ko.computed(function() {
                return self.clubIds.indexOf(clubId) >= 0;
            });
        }
    }

    return {
        viewModel: SubscriptionView,
        template: template
    };
});