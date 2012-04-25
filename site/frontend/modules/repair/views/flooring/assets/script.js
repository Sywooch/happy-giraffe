var Flooring = {
    typeChanged:function (select) {
        var t = parseInt($('input[name="t"]').val());
        var val = parseInt(select.val());
        if (val > t)
            $('#FlooringForm_flooringLength').parent().parent().hide();
        else
            $('#FlooringForm_flooringLength').parent().parent().show();

        return false;
    },
    Calculate:function () {
        $.ajax({
            url:$("#flooring-calculate-form").attr("action"),
            data:$("#flooring-calculate-form").serialize(),
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