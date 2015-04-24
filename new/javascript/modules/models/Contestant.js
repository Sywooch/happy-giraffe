define(['knockout', 'models/Model', 'models/User'], function ContestantHandler(ko, Model, User) {
    var Contestant = Object.create({});
    Contestant.init = function initContestant(object) {
        this.id = object.id;
        this.place = object.place;
        this.score = object.score;
        this.userId = object.userId;
        this.user = Object.create(User);
        this.user = this.user.init(object.user);
        return this;
    };
    Object.defineProperties(Contestant, {
        "id": {
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
        "userId": {
            value: null,
            writable: true
        },
        "user": {
            value: null,
            writable: true
        },
    });

    return Contestant;
});
