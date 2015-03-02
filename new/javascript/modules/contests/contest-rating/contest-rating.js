define(['jquery', 'knockout', 'models/Model', 'models/ContestComments', 'models/Contestant', 'models/User', 'text!contests/contest-rating/contest-rating.html', 'ko_library'], function ContestRatingViewHandler($, ko, Model, ContestComments, Contestant, User, template) {
    function ContestRatingViewModel(params) {
        this.contest = Object.create(ContestComments);
        this.contest.id = params.contestId;
        this.main = params.main;
        this.contestants = ko.observableArray([]);
        this.mappingContestantsArray = function mappingContestantsArray(object) {
            var contestant = Object.create(Contestant);
            return contestant.init(object);
        };
        this.resolveContestRatings = function resolveContestRatings(response) {
            if (response.success === true) {
                this.contestants(ko.utils.arrayMap(response.data, this.mappingContestantsArray.bind(this)));
            }
        };
        this.contest.getRatingList().done(this.resolveContestRatings.bind(this));
    }
    return {
        viewModel: ContestRatingViewModel,
        template: template
    };
});
