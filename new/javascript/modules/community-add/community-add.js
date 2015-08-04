define(['knockout', 'text!community-add/community-add.html', 'ko_community', 'user-config', 'common'], function CommunityAddHandler(ko, template, CommunitySubscription, userConfig) {
    function CommunityAdd(params) {
        this.forumId = params.forumId;
        this.clubId = params.clubId;
        this.subsCount = params.subsCount;
        this.clubSubscription = params.clubSubscription;
        this.communitySubscription = new CommunitySubscription(this.clubSubscription, this.clubId, this.subsCount);
        this.userConfig = userConfig;
        userIsGuest = userConfig.isGuest;
    }

    return {
        viewModel: CommunityAdd,
        template: template
    };
});