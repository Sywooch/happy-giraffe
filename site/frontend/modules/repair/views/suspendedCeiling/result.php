<div id="results">
<div class="title">Материалов потребуется:</div>

<ul>
    <?php foreach($result as $title=>$value){ ?>
        <li>
            <span class="count"><?=$value?>&nbsp; шт.</span>
            <span><?=$title?></span>
        </li>
    <?php } ?>
</ul>
    <p style="display: none">
        Рассчитанное количество материалов является точным для потолка правильной прямоугольной формы. Если ваш
        потолок имеет сложную форму, то возьмите материалы с запасом от 10 до 25%.
    </p>

    <div style="text-align:right;">
        <a href="" class="pseudo" style="display: none" onclick="SuspendedCeiling.Recommendations(); event.preventDefault();">Показать результаты</a>
        <a href="" class="pseudo" onclick="SuspendedCeiling.Recommendations(); event.preventDefault();">Прочитать рекомендации</a>
    </div>

</div>