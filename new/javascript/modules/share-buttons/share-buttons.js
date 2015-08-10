define(['jquery', 'knockout', 'text!share-buttons/share-buttons.html', 'facebook', 'ok', 'vk'], function($, ko, template, FB, OK, VK) {
    FB.init({
        appId: "412497558776154"
    });

    function ShareButtons(params) {
        this.url = params.url;

        ko.bindingHandlers.okShare = {
            init: function(element, valueAccessor, allBindings, viewModel, bindingContext) {
                var url = valueAccessor();
                var id = Date.now();
                $(element).attr('id', id);
                OK.CONNECT.insertShareWidget(id, url, '{width:150, height:21, st: \'straight\', sz:20, ck:2}');
            }
        };

        ko.bindingHandlers.vkShare = {
            init: function(element, valueAccessor, allBindings, viewModel, bindingContext) {
                var url = valueAccessor();
                $(element).html(VK.Share.button(false, {type: "round", text: "Поделиться"}));
            }
        };

        ko.bindingHandlers.fbShare = {
            init: function(element, valueAccessor, allBindings, viewModel, bindingContext) {
                var url = valueAccessor();
                FB.XFBML.parse($(element).parent()[0]);
            }
        };
    }

    return {
        viewModel: ShareButtons,
        template: template
    };
});