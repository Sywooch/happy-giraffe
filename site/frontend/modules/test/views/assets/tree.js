var Test = {
    Init:function () {

    },
    Start:function () {
        $('#step0').fadeOut(300, function () {
            $('#step1').fadeIn(300);
        });
    },
    Next:function (input) {
        console.log($(input).attr('data-next-question'));

        if ($(input).attr('data-next-question') != undefined) {
            var q_num = $(input).attr('data-next-question');
            console.log(q_num);

            $(input).parents('div.step').fadeOut(300, function () {
                $('div.question-div').each(function (index, el) {
                    var num = $(el).attr('data-number');

                    if (num == q_num) {
                        $(el).fadeIn(300);
                    }
                });
            });
        }
        if ($(input).attr('data-result') != undefined) {
            Test.Finish(input);
        }
    },
    Finish:function (input) {
        var result_id = $(input).attr('data-result');
        console.log(result_id);

        $(input).fadeOut(300, function () {
            $('div.result-div').each(function (index, el) {
                var num = $(el).attr('data-number');

                if (num == result_id) {
                    $(el).fadeIn(300);
                }
            });
        });
    },
    Restart:function () {

    }
}