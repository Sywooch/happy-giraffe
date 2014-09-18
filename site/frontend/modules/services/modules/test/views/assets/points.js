var Test = {
    service_id:null,
    step:0,
    path:'',
    Init:function () {
        Test.path = document.location.href;
    },
    Start:function () {
        Test.Init();
        $('.step:visible').fadeOut(300, function () {
            $('#step1').fadeIn(300);
        });
    },
    Next:function (el) {
        var input = $(el);
        Test.logPage();
        if (input.attr('data-last') == "1") {
            input.closest('div.question-div').fadeOut(300, function () {
                Test.Finish();
            });
            return;
        }
        $('.step:visible').fadeOut(300, function () {
            if (input.closest('div.question-div').next('div.question-div').length) {
                input.closest('div.question-div').next('div.question-div').fadeIn(300);
            } else {
                Test.Finish();
            }
        });
    },
    Finish:function () {
        var points = 0;
        $('div.question input[type="radio"]:checked').each(function (index, el) {
            points += parseInt($(el).attr('data-points'));
        });

        var finished = false;
        $('div.result-div').each(function (index, el) {
            if (finished)
                return;
            var result_points = parseInt($(el).attr('data-points'));
            if (points >= result_points) {
                $(el).fadeIn(300);
                finished = true;
            }
        });

        service_used(9);
    },
    Restart:function () {
        $(".step input:radio:checked").removeAttr("checked");
        Test.Start();
    },
    logPage:function () {
        Test.step++;
        if (typeof(window.history.pushState) == 'function') {
            window.history.pushState(null, null, Test.path + '?step=' + Test.step);
            ga('send', 'pageview', Test.path + '?step=' + Test.step);
            yaCounter11221648.hit(Test.path + '?step=' + Test.step);
        }
        $('#pix').attr('src', 'http://ad.adriver.ru/cgi-bin/rle.cgi?sid=1&bt=21&ad=420214&pid=1313272&bid=2833663&bn=2833663&rnd=' + Math.floor((Math.random()*9999999999)+1000000000));

    }
}