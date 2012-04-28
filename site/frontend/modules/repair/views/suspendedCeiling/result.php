<div>
<div class="title">Материалов потребуется:</div>

<ul>
    <?php foreach($result as $title=>$value){ ?>
        <li>
            <span class="count"><?=$value?>&nbsp; шт.</span>
            <span><?=$title?></span>
        </li>
    <?php } ?>
</ul>

</div>