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
    }
}