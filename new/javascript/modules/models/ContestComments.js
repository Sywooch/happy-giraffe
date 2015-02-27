define(['knockout', 'models/Model', 'models/User', 'models/Contest'], function ContestCommentsHandler(ko, Model, User, Contest) {
    var ContestComments = Object.create(Contest);
    ContestComments.getRatingList = function getRatingList() {
        return Model.get(this.getRatingListUrl, { contestId: this.id, limit: this.limit, offset: this.offset});
    };
    ContestComments.getContestComments = function getContestComments(userId) {
        return Model.get(this.getContestCommentsUrl, { contestId: this.id, limit: this.limit, offset: this.offset, userId: userId });
    };
    ContestComments.init = function initContestComments(object) {
        this.participantId = this.participantId;
        this.place = object.place;
        this.score = object.score;
        this.user = Object.create(User);
        this.user = User.init(object.user);
        this.userId = object.userId;
        return this;
    };
    Object.defineProperties(ContestComments, {
        "getRatingListUrl": {
            value: '/api/commentatorsContest/ratingList/',
            writable: false
        },
        "getContestCommentsUrl": {
            value: '/api/commentatorsContest/comments/',
            writable: false
        },
        "limit": {
            value: 3,
            writable: true
        },
        "offset": {
            value: null,
            writable: true
        },
        "userId": {
            value: null,
            writable: true
        },
        "place": {
            value: null,
            writable: true
        },
        "score": {
            value: null,
            writable: true
        },
        "user": {
            value: Object.create(User),
            writable: true
        },
        "comments": {
            value: [],
            writable: true
        }
    });
    return ContestComments;
});
