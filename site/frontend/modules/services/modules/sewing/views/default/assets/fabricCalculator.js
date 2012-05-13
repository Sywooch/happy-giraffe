/**
 * Author: alexk984
 * Date: 25.04.12
 */

var fabricCalculator = {
    calc:function () {
        var LEN = document.getElementById("FabricCalculatorForm1_canva").value;
        var NIT = document.getElementById("FabricCalculatorForm1_threads_num").value;
        var PLUS = document.getElementById("FabricCalculatorForm1_additional").value;
        var W = document.getElementById("FabricCalculatorForm1_width").value;
        var H = document.getElementById("FabricCalculatorForm1_height").value;
        if (!parseInt(PLUS) && parseInt(PLUS) != 0 || !parseInt(W) || !parseInt(H) || !parseInt(NIT)) {
            return;
        }
        LEN = parseInt(LEN);
        NIT = parseInt(NIT);
        PLUS = parseInt(PLUS);
        W = parseInt(W);
        H = parseInt(H);
        var RES_W = W * NIT / LEN * 2.54 + PLUS * 2;
        var RES_H = H * NIT / LEN * 2.54 + PLUS * 2;
        RES_W = Math.round(RES_W);
        RES_H = Math.round(RES_H);
        document.getElementById("res").innerHTML = RES_W + " x " + RES_H + " см";
        $("#res").show();
    },
    calc2:function () {
        var AIDA = document.getElementById("FabricCalculatorForm2_canva").value;
        var PLUS1 = document.getElementById("FabricCalculatorForm2_additional").value;
        if (PLUS1 == "")
            PLUS1 = 0;
        var W1 = document.getElementById("FabricCalculatorForm2_width").value;
        var H1 = document.getElementById("FabricCalculatorForm2_height").value;
        if (!parseInt(PLUS1) && parseInt(PLUS1) != 0 || !parseInt(W1) || !parseInt(H1)) {
            return;
        }
        AIDA = parseInt(AIDA);
        PLUS = parseInt(PLUS1);
        W1 = parseInt(W1);
        H1 = parseInt(H1);
        var RES_W = W1 / AIDA * 2.54 + PLUS1 * 2;
        var RES_H = H1 / AIDA * 2.54 + PLUS1 * 2;
        RES_W = Math.round(RES_W);
        RES_H = Math.round(RES_H);
        document.getElementById("res1").innerHTML = RES_W + " x " + RES_H + " см";
        $("#res1").show();
    }
}