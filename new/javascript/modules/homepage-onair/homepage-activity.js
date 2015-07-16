define(['jquery', 'knockout'], function($, ko) {
    function Activity(vars) {
        this.vars = vars;
        this.homeUrl = '/onair/default/widget/';
        this.page = ko.observable(1);
        this.loading = ko.observable(false);

        this.loadPage = function loadPage(page) {
            this.loading(true);
            var data = this.vars;
            data.page = page;
            $.get(this.homeUrl, data, function(response) {
                $('#onair').replaceWith($(response).find('#onair'));
                $('#onair').find('time').each(function(index, element) {
                    ko.applyBindings({}, element);
                });
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
