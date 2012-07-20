<style type="text/css">
    #result table {
        border-collapse: collapse;
    }

    #result table td {
        padding: 5px;
        border: 1px solid #EEE
    }
</style>

<table>
<?php if (isset($result['days'])): ?>
<thead>
<tr>
    <th valign="middle">
        <span id="txt">Вы беременны <?php echo floor($result['days'] / 7) ?>  недель и <?php echo $result['days'] % 7 ?> дней</span>
    </th>
</tr>
</thead>
    <?php endif; ?>
<tbody>
<tr>
    <td width="200px">
        Предполагаемая дата зачатия:
    </td>
    <td width="200px"><b><?php echo HDate::GetFormattedTimestamp($result['conception']) ?></b></td>
    <td>&nbsp;</td>
</tr>
<tr>
    <td>
        Предполагаемая дата родов:
    </td>
    <td><b><?php echo HDate::GetFormattedTimestamp($result['finish']) ?></b></td>
    <td>&nbsp;</td>
</tr>
<tr>
    <td>
        Положительный результат теста (5 неделя):
    </td>
    <td><b><?php echo HDate::GetFormattedTimestamp(strtotime($result['start_str'] . ' + 5 weeks')) ?></b></td>
    <td>&nbsp;</td>
</tr>
<tr>
    <td>
        Начало формирования органов (5 неделя):
    </td>
    <td><b><?php echo HDate::GetFormattedTimestamp(strtotime($result['start_str'] . ' + 5 weeks')) ?></b></td>
    <td>&nbsp;</td>
</tr>
<tr>
    <td>
        Основные органы сформированы (10 неделя):
    </td>
    <td><b><?php echo HDate::GetFormattedTimestamp(strtotime($result['start_str'] . ' + 10 weeks')) ?></b></td>
    <td>&nbsp;</td>
</tr>
<tr>
    <td>
        Конец первого триместа (12 неделя):
    </td>
    <td><b><?php echo HDate::GetFormattedTimestamp(strtotime($result['start_str'] . ' + 12 weeks')) ?></b></td>
    <td>&nbsp;</td>
</tr>
<tr>
    <td>
        К этому сроку Вам необходимо встать на учет в женской консультации. УЗИ 1.
        Двойной тест (св. β-субъединица ХГЧ + PAPP-A) (10-13 неделя):
    </td>
    <td><b>с <?php echo HDate::GetFormattedTimestamp(strtotime($result['start_str'] . ' + 10 weeks')) ?>
        <br>по <?php echo HDate::GetFormattedTimestamp(strtotime($result['start_str'] . ' + 13 weeks')) ?></b></td>
    <td>
        Посещение акушера-гинеколога (измерение веса, артериального давления, размеров живота). Взятие на
        анализ мазков на флору и цитологию. Общий анализ крови, мочи, крови на сахар, кровь на гемосиндром,
        кровь из вены на СПИД, сифилис, гепатиты В и С, группу крови, биохимический анализ крови. Посещение
        терапевта, эндокринолога, окулиста, отоларинголога. Окончание эмбрионального периода. Скрининг
        риска синдрома Дауна и синдрома Эдвардса по УЗИ («воротниковое пространство») и биохимическим
        маркерам.
    </td>
</tr>
<tr>
    <td>
        АФП + ХГЧ + св. эстриол (оптимальные сроки) (16-18 неделя):
    </td>
    <td>
        <b>
            <?php echo HDate::GetFormattedTimestamp(strtotime($result['start_str'] . ' + 16 weeks')) ?><br>
            <?php echo HDate::GetFormattedTimestamp(strtotime($result['start_str'] . ' + 18 weeks')) ?>
        </b>

    </td>
    <td>
        Анализ крови на АФП, ХГЧ, эстриол, общий анализ крови, мочи.
    </td>
</tr>
<tr>
    <td>
        14-20 неделя (возможные сроки):
    </td>
    <td>
        <b>
            <?php echo HDate::GetFormattedTimestamp(strtotime($result['start_str'] . ' + 14 weeks')) ?><br>
            <?php echo HDate::GetFormattedTimestamp(strtotime($result['start_str'] . ' + 20 weeks')) ?>
        </b>
    </td>
    <td>
        Скрининг синдрома Дауна, синдрома Эдвардса и дефектов нервной трубки.
    </td>
</tr>
<tr>
    <td>
        18 неделя:
    </td>
    <td><b><?php echo HDate::GetFormattedTimestamp(strtotime($result['start_str'] . ' + 18 weeks')) ?></b></td>
    <td>
        Общий анализ мочи. Посещение акушера-гинеколога (измерение веса, артериального давления,
        размеров живота). Первое ощущение шевелений плода у повторнородящих женщин.
    </td>
</tr>
<tr>
    <td>
        20 неделя:
    </td>
    <td><b><?php echo HDate::GetFormattedTimestamp(strtotime($result['start_str'] . ' + 20 weeks')) ?></b></td>
    <td>
        Общий анализ мочи. Посещение акушера-гинеколога (измерение веса, артериального давления,
        размеров живота). Первое ощущение шевелений плода у первородящих женщин.
    </td>
</tr>
<tr>
    <td>
        УЗИ 2 (22 неделя):
    </td>
    <td><b><?php echo HDate::GetFormattedTimestamp(strtotime($result['start_str'] . ' + 22 weeks')) ?></b></td>
    <td>
        Общий анализ мочи. Общий анализ крови. Определение состояния плода по органам. Для оценки развития
        плода, состояния плаценты, вод, выявления угрозы прерывания беременности. На этом сроке вам могут
        сообщить пол ребенка.
    </td>
</tr>
<tr>
    <td>
        Допплер 1 (24 неделя):
    </td>
    <td><b><?php echo HDate::GetFormattedTimestamp(strtotime($result['start_str'] . ' + 24 weeks')) ?></b></td>
    <td>
        Общий анализ мочи. Допплерометрическое исследование кровотока плаценты. Исключение риска
        развития плацентарной недостаточности.
    </td>
</tr>
<tr>
    <td>
        Тест О'Салливан (26 неделя):
    </td>
    <td><b><?php echo HDate::GetFormattedTimestamp(strtotime($result['start_str'] . ' + 26 weeks')) ?></b></td>
    <td>
        Общий анализ мочи. Общий анализ крови. Глюкозотолерантный тест. Исключение гестационного диабета.
    </td>
</tr>
<tr>
    <td>
        Конец второго триместра (27 неделя):
    </td>
    <td><b><?php echo HDate::GetFormattedTimestamp(strtotime($result['start_str'] . ' + 27 weeks')) ?></b></td>
    <td>&nbsp;</td>
</tr>
<tr>
    <td>
        28 неделя:
    </td>
    <td><b><?php echo HDate::GetFormattedTimestamp(strtotime($result['start_str'] . ' + 28 weeks')) ?></b></td>
    <td>
        Конец второго триместра. Дородовой отпуск у беременных двойней. Риск гестоза и пиелонефрита.
    </td>
</tr>
<tr>
    <td>
        30 неделя:
    </td>
    <td><b><?php echo HDate::GetFormattedTimestamp(strtotime($result['start_str'] . ' + 30 weeks')) ?></b></td>
    <td>
        Посещение окулиста. Три четверти позади. Дородовой отпуск у большинства беременных.
        С 30 недели &mdash; еженедельно или каждые 10 дней посещение гинеколога. Перед каждым приемом &mdash;
        общий анализ мочи.
    </td>
</tr>
<tr>
    <td>
        УЗИ 3 (32 неделя):
    </td>
    <td><b><?php echo HDate::GetFormattedTimestamp(strtotime($result['start_str'] . ' + 32 weeks')) ?></b></td>
    <td>
        Определение состояния плода и плаценты &mdash; положение, предлежание плода, состояние плаценты,
        соответствие размеров плода сроку беременности, сердцебиение и дыхательные движения плода, околоплодные
        воды. На 30-34 неделе беременности желательно провести кардиотокографическое исследование &mdash; выявление
        хронических заболеваний сердца будущей мамы.<br>
        На 34 неделе &mdash; общий анализ крови.<br>
        На 36 неделе &mdash; мазок на флору, общий анализ крови, мочи, кровь на гемосиндром, кровь из вены на
        СПИД, сифилис, гепатиты В и С.
    </td>
</tr>
<tr>
    <td>
        38 неделя:
    </td>
    <td><b><?php echo HDate::GetFormattedTimestamp(strtotime($result['start_str'] . ' + 38 weeks')) ?></b></td>
    <td>
        Общий анализ крови, мочи. Доношенная беременность. Врач выдаст вам обменную карту, в которой будут внесены
        все данные о вашей беременности, результаты анализов и заключения врачей-специалистов. Эта обменная карта
        необходима в роддоме. Она должна быть всегда с вами на случай, если придется в роддоме оказаться раньше
        срока.
    </td>
</tr>
</tbody>
</table>