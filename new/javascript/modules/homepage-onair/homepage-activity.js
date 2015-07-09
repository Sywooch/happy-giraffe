define(['jquery', 'knockout'], function($, ko) {
    function Activity() {
        this.homeUrl = '/';
        this.page = ko.observable(1);
        this.loading = ko.observable(false);

        this.loadPage = function loadPage(page) {
            this.loading(true);
            $.get(this.homeUrl, { page: page }, function(response) {
                $('#homepage-onair').replaceWith($(response).find('#homepage-onair'));
                this.loading(false);
            }.bind(this));
        };

        this.prev = function prev() {
            if (this.prevActive()) {
                this.page(this.page() - 1);
                this.loadPage(this.page());
            }
        };

        this.next = function next() {
            if (this.nextActive()) {
                this.page(this.page() + 1);
                this.loadPage(this.page());
            }
        };

        this.prevActive = function prevActive() {
            return this.page() > 1 && this.loading() === false;
        };

        this.nextActive = function nextActive() {
            return this.loading() === false;
        }
    }

    return Activity;
});
