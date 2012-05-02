var Test = {
    Init:function () {
    },
    Start:function () {
        Test.Step = 1;
        $('.step:visible').fadeOut(300, function () {
            $('.step.q:first .q-number span').text(Test.Step);
            $('.step.q:first').fadeIn(300);
        });
    },
    Next:function (el) {
        Test.Step++;
        var input = $(el);
        var nextId = parseInt(input.attr('data-next'));
        var resultPoints = parseInt(input.attr('data-points'));
        if (nextId > 0) {
            $('.step:visible').fadeOut(300, function () {
                $('.step.q[data-id="' + nextId + '"] .q-number span').text(Test.Step);
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
        $('.step input[type="radio"]:checked').each(function () {
            $(this).prop('checked', false);
        });
        Test.Start();
    }
}