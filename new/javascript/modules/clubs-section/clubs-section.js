define(['knockout', 'text!clubs-section/clubs-section.html', 'models/Club'], function ClubsSectionHandler(ko, template, Club) {
    function ClubsSection(params) {
        this.userId = params.userId;
        this.clubs = ko.observableArray();
        this.loaded = ko.observable(false);
        this.mapClubs = function mapClubs(club) {
            var clubInst = Object.create(Club);
            clubInst.init(club);
            return clubInst;
        };
        this.getClubsHandler = function getClubsHandler(response) {
            if (response.success === true) {
                var responseArray = response.data;
                this.clubs(responseArray.map(this.mapClubs.bind(this)));
            }
            this.loaded(true);
        };
        Club.getClubs(this.userId).done(this.getClubsHandler.bind(this));

    }
    return {
        viewModel: ClubsSection,
        template: template
    };
});