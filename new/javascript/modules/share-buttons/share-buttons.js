define(['jquery', 'knockout', 'text!share-buttons/share-buttons.html', 'facebook', 'ok', 'vk', 'jquery.iframetracker'], function($, ko, template, FB, OK, VK) {
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

                jQuery(document).ready(function($){
                    setTimeout(function(){
                        $(element).iframeTracker({
                            blurCallback: function(){
                                dataLayer.push({"event": "okShare"});
                            }
                        });
                    }, 5000);
                });
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

                jQuery(document).ready(function($){
                    setTimeout(function(){
                        $(element).iframeTracker({
                            blurCallback: function(){
                                dataLayer.push({"event": "fbShare"});
                            }
                        });
                    }, 5000);
                });
            }
        };
    }

    return {
        viewModel: ShareButtons,
        template: template
    };
});