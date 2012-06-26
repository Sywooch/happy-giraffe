var Paint = {
    Calculate:function () {
        $.ajax({
            url:$("#paint-calculate-form").attr('action'),
            data:$("#paint-calculate-form").serialize(),
            type:"POST",
            dataType:'json',
            success:function (data) {
                $("div#repair-paint div.recommendation").fadeOut(100, function () {
                    $("div#repair-paint div.recommendation div.left span").text(data.volume + ' ' + data.noun);
                    $("div#repair-paint div.recommendation").fadeIn(100);
                });
                $('html,body').animate({scrollTop:$('#result').offset().top}, 'fast');
            }
        });
        return false;
    },
    AreaCreate:function () {
        $.ajax({
            url:$("#empty-area-form").attr("action"),
            data:$("#empty-area-form").serialize(),
            type:"POST",
            success:function (data) {
                $('.except-area').hide();
                $("#emptyareas").fadeOut(100, function () {
                    $("#emptyareas").html(data);
                    $("#emptyareas").fadeIn(100);
                });

            }
        });
        return false;
    },
    AreaDelete:function (url) {
        $.post(url, function (data) {
            $("#emptyareas").fadeOut(100, function () {
                $("#emptyareas").html(data);
                $("#emptyareas").fadeIn(100);
                return false;
            });
        });
        return false;
    },
    SurfaceSwitch:function (surface) {

        //$('#paint-calculate-form')[0].reset();
        $('#repair-paint div.recommendation').fadeOut(200);

        $('#repair-paint div.recommendation div.left div').text('Краски для ' + $(surface).text() + ' нужно');

        var title = $(surface).parent().attr('data-title');
        $('#repair-paint div.form div.form-in form#paint-calculate-form div.row-switcher big').text(title);
        $('#PaintForm_surface').val(title);

        $('#repair-paint div.form div.form-in form#paint-calculate-form div.row-switcher div.a-right span').show();
        $(surface).parent().hide();

        $('div#repair-paint div.recommendation div.left img').hide();
        $('div#repair-paint div.recommendation div.left img[data-title="' + title + '"]').show();

        if (title == 'Стены') {
            $('#empty-area-form').show();
            $('#repair-paint div.form div.form-in form#paint-calculate-form div.row div.row-elements div.col:last').fadeIn(200);
        } else {
            $('#empty-area-form').hide();
            $('#repair-paint div.form div.form-in form#paint-calculate-form div.row div.row-elements div.col:last').fadeOut(200);
        }

        return false;
    }
}