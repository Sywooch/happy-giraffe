<style type="text/css">
    input {
        border: 1px solid #000;
    }
</style>
<script type="text/javascript">
    var conf = new Array();

    $(function () {
        conf[11] = 0.0025249;
        conf[14] = 0.00196;
        conf[16] = 0.001694;
        conf[18] = 0.0014689;
        conf[20] = 0.001272;
        conf[22] = 0.0010958;

        $('#calc-threads').click(function () {
            var krestikov = parseInt($('#krestikov').val());
            var kanva = parseInt($('#kanva').val());
            var s = parseInt($('#sl').val());

            var threads = krestikov * conf[kanva] * s;
            var str = threads.toFixed(1) + ' метров или ';
            var bundles = Math.ceil(threads / 8);
            str += bundles + ' ';
            var last_digit = bundles.toString();

            var last_2digit = last_digit.substring(last_digit.length - 2, last_digit.length);
            last_digit = last_digit.substring(last_digit.length - 1, last_digit.length);
            var bundle_word = 'мотков';
            if (last_digit == 1)
                bundle_word = 'моток';
            if (last_digit > 1 && last_digit < 5)
                bundle_word = 'мотка';

            if (last_2digit > 4 && last_2digit < 20)
                bundle_word = 'мотков';

            $('#res1').text(str+bundle_word+' (8 метров моток)');
            return false;
        });
    });
</script>

<h1>Калькулятор для расчета ниток</h1>
<form method="post">
    <table>
        <tbody>
        <tr>
            <th>Кол-во крестиков:</th>
            <td><input type="text" value="" id="krestikov" name="kr" class="text"></td>
        </tr>
        <tr>
            <th>Номер канвы Aida:</th>
            <td><select id="kanva">
                <option selected="true" value="11">11</option>
                <option value="14">14</option>
                <option value="16">16</option>
                <option value="18">18</option>
                <option value="20">20</option>
                <option value="22">22</option>
            </select></td>
        </tr>
        <tr>
            <th>Сложений нити:</th>
            <td><select id="sl">
                <option selected="true" value="1">1</option>
                <option value="2">2</option>
                <option value="3">3</option>
                <option value="4">4</option>
                <option value="5">5</option>
                <option value="6">6</option>
            </select></td>
        </tr>
        <tr>
            <th></th>
            <td><a href="#" id="calc-threads">Расчитать</a></td>
        </tr>
        </tbody>
    </table>
    <span id="res1"></span>
</form>