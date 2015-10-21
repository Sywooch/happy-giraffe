define(['jquery', 'knockout', 'text!md-redactor/components/gif-image/gif-image.html', 'ko_library'], function($, ko, template) {
    function GifImage(params) {
        this.link = params.link;
        this.animated = ko.observable(params.animated);
        this.running = ko.observable(false);

        this.run = function() {
            this.running(true);
            this.animated.valueHasMutated(); // нужно для того, чтобы гифка запустилась заново
        };

        this.stop = function() {
            this.running(false);
        };

        this.toggle = function() {
            if (this.running()) {
                this.stop();
            } else {
                this.run();
            }
        };
    }

    return {
        viewModel: GifImage,
        template: template
    };
});