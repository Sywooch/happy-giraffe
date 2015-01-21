define(['jquery', 'knockout', 'eauth'], function SocialNetworksHandler($, ko) {
    var SocialNetwoks = {
        vkObj : {
            "popup": {
                "width": 585,
                "height": 350
            },
            "id": "vkontakte"
        },
        okObj : {
            "popup": {
                "width": 680,
                "height": 500
            },
            "id": "odnoklassniki"
        },
        init: function init(social, vkIdentity, okIdentity) {
            if (!social().hasOwnProperty('vkontakte')) {
                $(vkIdentity).eauth(this.vkObj);
            }
            if (!social().hasOwnProperty('odnoklassniki')) {
                $(okIdentity).eauth(this.okObj);
            }
        }
    };

    return SocialNetwoks;
});