/**
 * Author: alexk984
 * Date: 21.08.13
 */
function CommunitySubscription(active, community_id, count) {
    var self = this;
    self.active = ko.observable(active);
    self.count = ko.observable(count);
    self.community_id = community_id;
    self.subscribe = function () {
        if (userIsGuest)
            $('a[href=#login]').trigger('click');
        else
            $.post('/community/subscribe/', {community_id: self.community_id}, function (response) {
                if (response.status) {
                    self.active(true);
                    self.count(self.count() + 1);
                }
            }, 'json');
    }
}