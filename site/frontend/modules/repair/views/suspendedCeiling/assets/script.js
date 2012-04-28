var SuspendedCeiling = {
    Calculate:function () {
        $.ajax({
            url:$("#SuspendedCeiling-calculate-form").attr("action"),
            data:$("#SuspendedCeiling-calculate-form").serialize(),
            type:"POST",
            success:function (data) {
                $(".row-result").fadeOut(100, function () {
                    $(".row-result").html(data);
                    $(".row-result").fadeIn(100);
                });
            }
        });
        return false;
    },
    Recommendations:function(){
        $('#repair-ceiling #results div a.pseudo, #repair-ceiling #results p, #repair-ceiling #results ul').toggle();
    }
}