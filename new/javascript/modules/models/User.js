define(['knockout', 'models/Model', 'user-config'], function PresetManagerHandler(ko, Model, userConfig) {
    var User = {
        isGuest: userConfig.isGuest,
        isModer: userConfig.isModer,
        userId: userConfig.userId
    };
    return User;
});