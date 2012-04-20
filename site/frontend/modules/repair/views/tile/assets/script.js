var Tile = {
    Calculate:function () {
        $.ajax({
            url:$("#tile-calculate-form").attr('action'),
            data:$("#tile-calculate-form").serialize(),
            type:"POST",
            success:function (data) {
                $("#result").fadeOut(100, function () {
                    $("#result").html(data);
                    $("#result").fadeIn(100);
                });
            }
        });
        return false;
    },
    AreaCreate:function () {
        $.ajax({
            url:$("#area-form").attr("action"),
            data:$("#area-form").serialize(),
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
    AreaDelete:function (url) {
        $.ajax({
            url:url,
            data:$("#area-form").serialize(),
            type:"POST",
            success:function (data) {
                $("#emptyareas").fadeOut(100, function () {
                    $("#emptyareas").html(data);
                    $("#emptyareas").fadeIn(100);
                });
            }
        });
        return false;
    }
}