<style type="text/css">
    input {
        border: 1px solid #000;
    }
</style>
<script type="text/javascript">
    $(function () {
        $('input.calc').click(function () {
            var c1 = parseInt($('#c1').val());
            var c2 = parseInt($('#c2').val());
            var p1 = parseInt($('#p1').val());
            var p2 = parseInt($('#p2').val());

            var c3 = parseInt($('#c3').val());
            var c4 = parseInt($('#c4').val());

            Validate(c1,'c1');
            Validate(c2,'c2');
            Validate(c3,'c3');
            Validate(c4,'c4');
            Validate(p1,'p1');
            Validate(p2,'p2');

            if ((c1 <= 0 || isNaN(c1)) || (c2 <= 0 || isNaN(c2)) || (c3 <= 0 || isNaN(c3)) || (c4 <= 0 || isNaN(c4)) ||
                (p1 <= 0 || isNaN(p1)) || (p2 <= 0 || isNaN(p2)))
                return false;

            var p3 = Math.round(p1 * (c3/c1));
            var p4 = Math.round(p2 * (c4/c2));

            $('#p3').text(p3);
            $('#p4').text(p4);
        });
    });

    function Validate(p, str){
        if (p <= 0 || isNaN(p))
            $('#'+str).css('background', 'red');
        else
            $('#'+str).css('background', 'none');
    }
</script>

<span>Размер образца</span>
<table id="sample" width="220" cellspacing="3" cellpadding="0" border="0">
    <tbody>
    <tr>
        <td class="tt">Ширина</td>
        <td width="61">&nbsp;</td>
        <td class="tt">Длина</td>
        <td width="14">&nbsp;</td>
    </tr>
    <tr>
        <td><input type="text" maxlength="5" id="c1" class="inp" value="10" size="6"></td>
        <td class="tt">см</td>
        <td><input type="text" maxlength="5" id="c2" class="inp" value="10" size="6" name="text2">
        </td>
        <td class="tt">см</td>
    </tr>
    <tr>
        <td><input type="text" maxlength="5" id="p1" class="inp" size="6" name="text" value="100"></td>
        <td class="tt">петель</td>
        <td><input type="text" maxlength="5" id="p2" class="inp" size="6" name="text3" value="100"></td>
        <td class="tt">рядов</td>
    </tr>
    </tbody>
</table>
<div>Размер изделия</div>
<table id="good" width="220" cellspacing="3" border="0">
    <tbody>
    <tr>
        <td class="tt">Ширина</td>
        <td width="61">&nbsp;</td>
        <td class="tt">Длина</td>
        <td width="14">&nbsp;</td>
    </tr>
    <tr>
        <td><input type="text" maxlength="5" id="c3" class="inp" size="6" value="95"></td>
        <td class="tt">см</td>
        <td><input type="text" maxlength="5" id="c4" class="inp" size="6" name="text2" value="23"></td>
        <td class="tt">см</td>
    </tr>
    </tbody>
</table>

<input type="button" value="Рассчитать!" class="calc">
<br>
<span id="p3"></span> петель,
<span id="p4"></span> рядов