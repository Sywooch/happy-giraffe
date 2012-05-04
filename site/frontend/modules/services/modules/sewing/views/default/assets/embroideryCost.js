/**
 * Author: alexk984
 * Date: 25.04.12
 */
var embroideryCost = {
    calc:function(stitchcount) {
            var w = parseInt(document.getElementById("EmbroideryCostForm_width").value);
            var h = parseInt(document.getElementById("EmbroideryCostForm_height").value);
            var crossprice = (document.getElementById("EmbroideryCostForm_cross_price").value).replace(',', '.');
            var pricematerals = parseInt(document.getElementById("EmbroideryCostForm_material_price").value);

            if (isNaN(w) || isNaN(h) || isNaN(crossprice) || isNaN(pricematerals) || crossprice === '' || pricematerals === ''){
                $('#result').html('');
                return false;
            }

            var ch1f = document.getElementById("EmbroideryCostForm_colors_count").value;
            var ch4f = document.getElementById("EmbroideryCostForm_canva").value;
            var ch7f = document.getElementById("EmbroideryCostForm_design_price").value;

            if (isNaN(ch1f) || ch1f === "") ch1f = 0;
            if (isNaN(ch4f) || ch4f === "") ch4f = 0;
            if (isNaN(ch7f) || ch7f === "") ch7f = 0;

            if (ch1f < 25) {
                ch1f = 0
            } else {
                ch1f = ch1f - 25
            }
            if (stitchcount.ch2.checked) {
                var ch2f = 20
            } else {
                ch2f = 0
            }
            if (stitchcount.ch3.checked) {
                var ch3f = 25
            } else {
                ch3f = 0
            }
            if (stitchcount.ch5.checked) {
                var ch5f = 25
            } else {
                ch5f = 0
            }
            if (stitchcount.ch6.checked) {
                var ch6f = 15
            } else {
                ch6f = 0
            }

            ch1f = parseInt(ch1f);
            ch2f = parseInt(ch2f);
            ch3f = parseInt(ch3f);
            ch4f = parseInt(ch4f);
            if (ch4f < 5) ch4f = 0;
            ch5f = parseInt(ch5f);
            ch6f = parseInt(ch6f);
            ch7f = parseInt(ch7f);

            var s = w * h;
            var allcrossprice = s * crossprice;

            if (s >= 40000) {
                var ch8f = allcrossprice * 0.15
            } else {
                ch8f = 0
            }
            var baseprice = allcrossprice + pricematerals;
            complexelemprice = (ch1f + ch2f + ch3f + ch4f + ch5f + ch6f) * allcrossprice / 100 + ch7f + ch8f;
            totalprice = baseprice + complexelemprice;
            baseprice = Math.round(baseprice);
            totalprice = Math.round(totalprice);
            complexelemprice = Math.round(complexelemprice);

            $('#result').html('<div class="total_block">' +
                '<p>Базовая стоимость работы:<span>' + baseprice +
                '</span></p>' +
                '<p>Стоимость усложняющих элементов:<span>' + complexelemprice +
                '</span>' +
                '</p><p class="big">ИТОГО:<span>' + totalprice +
                ' руб</span></p></div>');
            $('html,body').animate({scrollTop: $('#form-header').offset().top},'fast');
            return false;
    },
    activate:function(par, related_id){
        if (par.checked) {
            document.getElementById(related_id).disabled = false;
            $('#'+related_id).trigger("liszt:updated");
        }
        else {
            document.getElementById(related_id).disabled = true;
            $('#'+related_id).trigger("liszt:updated");
        }
    }
}