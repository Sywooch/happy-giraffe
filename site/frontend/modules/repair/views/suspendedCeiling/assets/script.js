var SuspendedCeiling = {
    Calculate:function () {
        $.ajax({
            url:$("#SuspendedCeiling-calculate-form").attr("action"),
            data:$("#SuspendedCeiling-calculate-form").serialize(),
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