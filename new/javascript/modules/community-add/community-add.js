define(['knockout', 'text!community-add/community-add.html', 'ko_community', 'common'], function CommunityAddHandler(ko, template, CommunitySubscription) {
    function CommunityAdd(params) {
        this.forumId = params.forumId;
        this.clubId = params.clubId;
        this.subsCount = params.subsCount;
        this.clubSubscription = params.clubSubscription;
        this.communitySubscription = new CommunitySubscription(this.clubSubscription, this.clubId, this.subsCount);
    }

    return {
        viewModel: CommunityAdd,
        template: template
    };
});