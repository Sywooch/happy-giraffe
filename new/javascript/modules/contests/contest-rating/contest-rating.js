define(['jquery', 'knockout', 'models/Model', 'models/ContestComments', 'models/Contestant', 'models/User', 'text!contests/contest-rating/contest-rating.html', 'ko_library'], function ContestRatingViewHandler($, ko, Model, ContestComments, Contestant, User, template) {
    function ContestRatingViewModel(params) {
        this.contest = Object.create(ContestComments);
        this.contest.id = params.contestId;
        this.main = params.main;
        this.loadingCount = 10;
        this.contestants = ko.observableArray([]);
        this.overload = ko.observable(false);
        this.mappingContestantsArray = function mappingContestantsArray(object) {
            var contestant = Object.create(Contestant);
            return contestant.init(object);
        };
        this.checkingIfTheresMore = function checkingIfTheresMore(array) {
            return (array.length === this.contest.ratingLimit) ? false : true;
        };
        this.resolveContestRatings = function resolveContestRatings(response) {
            if (response.success === true) {
                this.overload(this.checkingIfTheresMore(response.data));
                this.contestants(ko.utils.arrayMap(response.data, this.mappingContestantsArray.bind(this)));
            }
        };
        this.loadMoreContestRatings = function resolveContestRatings(response) {
            if (response.success === true) {
                this.overload(this.checkingIfTheresMore(response.data));
                this.contestants.push.apply(this.contestants, ko.utils.arrayMap(response.data, this.mappingContestantsArray.bind(this)));
            }
        };
        this.loadMore = function loadMore() {
            this.contest.ratingLimit = this.loadingCount;
            this.contest.ratingOffset = this.contestants().length;
            this.contest.getRatingList().done(this.loadMoreContestRatings.bind(this));
        };
        this.contest.getRatingList().done(this.resolveContestRatings.bind(this));
    }
    return {
        viewModel: ContestRatingViewModel,
        template: template
    };
});
