var Tile = {
    Calculate:function () {
        $.ajax({
            url:$("#tile-calculate-form").attr('action'),
            data:$("#tile-calculate-form").serialize(),
            type:"POST",
            dataType:'json',
            success:function (data) {
                $("div#repair-bathroom-tile div.recommendation").fadeOut(100, function () {
                    $("div#repair-bathroom-tile div.recommendation div.left span").html(data.qty + ' ' + data.noun);
                    $("div#repair-bathroom-tile div.recommendation").fadeIn(100);
                });
                $('html,body').animate({scrollTop:$('#result').offset().top}, 'fast');
            }
        });
        return false;
    },
    CalcSq:function(){
        $('#tile-calculate-form div.form-in div.row div.img').each(function(){
            a = $(this).next().find('input').val().replace (/\,/g, '.');;
            b = $(this).next().next().find('input').val().replace (/\,/g, '.');;
            sq = parseFloat(a) * parseFloat(b);
            if (sq > 0) {
                $(this).find('div.val').text(sq.toFixed(1));
            } else {
                $(this).find('div.val').text('');
            }
            console.log(a);
            console.log(b);
        })
    }
}


$(function(){
    $('#tile-calculate-form .row input[type="text"]').bind('change', function(){
        Tile.CalcSq()
    });
})