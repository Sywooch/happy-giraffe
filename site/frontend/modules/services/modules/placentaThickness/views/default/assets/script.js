/**
 * Author: alexk984
 * Date: 25.04.12
 */

var placentaThickness = {
    calc:function () {
        $.ajax({
            url:'/placentaThickness/calculate/',
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