<script type="text/javascript">
    $(function () {
        $('.calculator_loops input[type=submit]').click(function (e) {
            e.preventDefault();
            var c1 = parseInt($('#c1').val());
            var c2 = parseInt($('#c2').val());
            var p1 = parseInt($('#p1').val());
            var p2 = parseInt($('#p2').val());

            var c3 = parseInt($('#c3').val());
            var c4 = parseInt($('#c4').val());

            Validate(c1, 'c1');
            Validate(c2, 'c2');
            Validate(c3, 'c3');
            Validate(c4, 'c4');
            Validate(p1, 'p1');
            Validate(p2, 'p2');

            if ((c1 <= 0 || isNaN(c1)) || (c2 <= 0 || isNaN(c2)) || (c3 <= 0 || isNaN(c3)) || (c4 <= 0 || isNaN(c4)) ||
                (p1 <= 0 || isNaN(p1)) || (p2 <= 0 || isNaN(p2)))
                return false;

            var p3 = Math.round(p1 * (c3 / c1));
            var p4 = Math.round(p2 * (c4 / c2));

            $('#result').html('<div class="form_block pink">' +
                '<p><span>' + p3 + '</span> петель</p>' +
                '<p><span>' + p4 + '</span> рядов</p>' +
                '<div class="clear"></div></div>');
        });
    });

    function Validate(p, str) {
        if (p <= 0 || isNaN(p)) {
            $('#result').html('');
        }
    }
</script>
<div class="right_block">
    <div class="calculator_loops">
        <h1>Калькулятор петель</h1>

        <form action="#">

            <div class="form_block green">
                <p class="form_header">Размер образца</p>

                <p>Введите размер образца и количество рядов и петель в нем:</p>

                <div class="left_column">
                    <p>Ширина</p>
                    <input type="text" id="c1" value="10"/><label>см</label>
                    <input type="text" id="p1" value=""/><label>петель</label>
                </div>
                <div class="right_column">
                    <p>Длина</p>
                    <input type="text" id="c2" value="10"/><label>см</label>
                    <input type="text" id="p2" value=""/><label>рядов</label>
                </div>
                <div class="clear"></div>
            </div>
            <div class="form_block blue">
                <p class="form_header">Размер изделия</p>

                <p>Введите размер изделия</p>

                <div class="left_column">
                    <p>Ширина</p>
                    <input type="text" id="c3" value=""/><label>см</label>
                </div>
                <div class="right_column">
                    <p>Длина</p>
                    <input type="text" id="c4" value=""/><label>см</label>
                </div>
                <div class="clear"></div>
            </div>
            <input type="submit" value="Рассчитать"/>

            <div id="result">
            </div>

            <div class="clear"></div>
        </form>
    </div>
</div>

<div class="seo-text">
    <h1 class="summary-title">Калькулятор петель</h1>

    <p>Начинаете вязать себе носок, делаете несколько рядов и понимаете, что он будет мал даже младшей дочке.
        Распускаете. Прибавляете несколько петель на каждой спице и начинаете заново. Через полчаса понимаете, что носок
        будет велик даже дедушке. Бывало у вас так?</p>

    <div class="brushed">
        <p>Чтобы подобной ситуации не возникало – создан наш сервис. Пользоваться им просто.</p>

        <p>Сначала нужно связать образец из выбранной пряжи в виде квадрата со сторонами примерно 12 сантиметров. Его
            нужно намочить, высушить, не растягивая, и чуть-чуть отпарить. Берём линейку – отмеряем, слегка отступив от
            края, 10 сантиметров в ширину и считаем, сколько в них поместилось петель. Потом измеряем длину и считаем,
            сколько в ней поместилось рядов. Если у вас получился образец меньшего размера – ничего страшного.
            Посчитайте, сколько петель и рядов помещается в 8 сантиметрах или даже в 5.</p>

        <p>Теперь всё просто.</p>
        <ul>
            <li>Вводим полученные данные в соответствующие поля специальной формы,</li>
            <li>Вводим желаемые длину и ширину изделия в специальные поля формы.</li>
        </ul>
        <p>Получаем результат: сколько нужно набрать петель, чтобы получилась необходимая ширина изделия, и сколько
            нужно провязать рядов, чтобы достичь нужной длины изделия.</p>
    </div>
    <p>Теперь нужный размер любого изделия, даже намного более сложного, чем носок, получится с первого раза. А это так
        приятно!</p>
</div>