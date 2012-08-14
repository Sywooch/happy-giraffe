var Test = {
    step:0,
    path:'',
    Init:function () {
        Test.path = document.location.href;
    },
    Start:function () {
        Test.Init();
        $('.step:visible').fadeOut(300, function () {
            $('.step.q:first .q-number span').text(Test.step);
            $('.step.q:first').fadeIn(300);
        });
    },
    Next:function (el) {
        Test.step++;
        Test.logPage();
        var input = $(el);
        var nextId = parseInt(input.attr('data-next'));
        var resultPoints = parseInt(input.attr('data-points'));
        if (nextId > 0) {
            $('.step:visible').fadeOut(300, function () {
                $('.step.q[data-id="' + nextId + '"] .q-number span').text(Test.step);
                $('.step.q[data-id="' + nextId + '"]').fadeIn(300);
            });
        }
        else if (resultPoints != 0) {
            Test.Finish(resultPoints);
        }
    },
    Finish:function (resultPoints) {
        $('.step:visible').fadeOut(300, function () {
            $('.step.r[data-points="' + resultPoints.toString() + '"]').fadeIn(300);
        });
    },

    Restart:function () {
        $(".step input:radio:checked").removeAttr("checked");
        Test.Start();
    },
    logPage:function () {
        if (typeof(window.history.pushState) == 'function') {
            window.history.pushState(null, null, Test.path + '?step=' + Test.step);
            _gaq.push(['_trackPageview', Test.path + '?step=' + Test.step]);
            yaCounter11221648.hit(Test.path + '?step=' + Test.step);
        }
    }
}