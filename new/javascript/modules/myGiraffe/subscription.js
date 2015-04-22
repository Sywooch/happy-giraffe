define(['jquery', 'knockout', 'text!myGiraffe/subscription.html', 'models/Model', 'user-config'], function($, ko, template, Model, userConfig) {
    function SubscriptionView() {
        var self = this;

        self.readUrl = '/api/community/getUserSubscriptions/';
        self.saveUrl = '/api/community/setUserSubscriptions/';
        self.redirectUrl = '/my/';

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
        };

        self.save = function() {
            Model.get(self.saveUrl, {
                userId: userConfig.userId,
                subscriptions: self.clubIds()
            }).done(function() {
                document.location.href = self.redirectUrl;
            });
        };

        self.init = function() {
            Model.get(self.readUrl, {
                userId: userConfig.userId
            }).done(function(response) {
                for (var i in response.data) {
                    self.clubIds.push(response.data[i].id);
                }
            });
        };

        self.init();
    }

    return {
        viewModel: SubscriptionView,
        template: template
    };
});