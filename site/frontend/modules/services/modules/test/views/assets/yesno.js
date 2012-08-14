var Test = {
    step:0,
    path:'',
    Init:function () {
        Test.Yes = 0;
        Test.No = 0;
        Test.path = document.location.href;
    },
    Start:function () {
        Test.Init();
        $('.step:visible').fadeOut(300, function () {
            $('.step.q:first').fadeIn(300);
        });
    },
    Next:function (el, a) {
        var link = $(el);
        if (parseInt(link.attr('data-answer')) == 1)
            Test.Yes++;
        else
            Test.No++;
        Test.logPage();

        $('.step:visible').fadeOut(300, function () {
            if (link.closest('.step.q').next('.step.q').length) {
                link.closest('.step.q').next('.step.q').fadeIn(300);
            } else {
                Test.Finish();
            }
        });

    },
    Finish:function () {
        rYes = $('.step.r[data-number="1"]');
        rNo = $('.step.r[data-number="0"]');
        if (Test.Yes >= parseInt(rYes.attr('data-points'))) {
            rYes.fadeIn(300);
        }
        if (Test.No >= parseInt(rNo.attr('data-points'))) {
            rNo.fadeIn(300);
        }
    },

    Restart:function () {
        Test.Start();
    },
    logPage:function () {
        Test.step++;
        if (typeof(window.history.pushState) == 'function') {
            window.history.pushState(null, null, Test.path + '?step=' + Test.step);
            _gaq.push(['_trackPageview', Test.path + '?step=' + Test.step]);
            yaCounter11221648.hit(Test.path + '?step=' + Test.step);
        }
    }
}