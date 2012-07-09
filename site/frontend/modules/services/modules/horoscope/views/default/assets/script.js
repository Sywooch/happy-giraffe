/**
 * Author: alexk984
 * Date: 25.04.12
 */

var Horoscope = {
    calc:function () {
        $.ajax({
            url:$('#placenta-thickness-form').attr('action'),
            data:$("#placenta-thickness-form").serialize(),
            type:"POST",
            success:function (data) {
                $("#result").fadeOut(100, function () {
                    $("#result").html(data);
                    $("#result").fadeIn(100);
                });
            }
        });
        return false;
    }
}