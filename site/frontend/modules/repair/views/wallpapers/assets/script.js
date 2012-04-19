var Wallpapers = {
    StartCalc:function () {
        $.ajax({
            url:"/repair/wallpapers/calculate/",
            data:$("#wallpapers-calculate-form").serialize(),
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

var Area = {
    create:function () {
        $.ajax({
            url:"/repair/wallpapers/addemptyarea/",
            data:$("#empty-area-form").serialize(),
            type:"POST",
            success:function (data) {
                $("#emptyareas").fadeOut(100, function () {
                    $("#emptyareas").html(data);
                    $("#emptyareas").fadeIn(100);
                });
            }
        });
        return false;
    },
    delete:function (url) {
        $.post(url, function (data) {
            $("#emptyareas").fadeOut(100, function () {
                $("#emptyareas").html(data);
                $("#emptyareas").fadeIn(100);
                return false;
            });
        });
        return false;
    }
}