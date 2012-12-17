<div class="cook-diabets">
    <!--
    Диаграмма для диабетиков имеет 4 состояния на сколько не подходит
    val0 (по умолчанию даже без класса)
    val33
    val66
    val100
    -->
    <div class="cook-diabets-chart <?=$recipe->getBakeryItemsCssClass() ?>">
        <span class="text"><?=$recipe->bakeryItems?></span>
    </div>
    <div class="cook-diabets-desc"><?=$recipe->getBakeryItemsText() ?></div>
</div>