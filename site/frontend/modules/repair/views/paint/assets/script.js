var Paint = {
    AreaCreate:function () {
        $.ajax({
            url:$("#empty-area-form").attr("action"),
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
    AreaDelete:function (url) {
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