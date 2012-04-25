<? if (count($areas)) { ?>
<table>
    <?php foreach ($areas as $key => $area) { ?>
    <tr>
        <td><?=$area['title']?></td>
        <td><?=$area['height']?> x <?=$area['width']?> м.</td>
        <td><?=$area['qty']?> шт.</td>
        <td><?php echo CHtml::link('убрать', array('paint/removearea', 'id' => $key), array('onclick' => 'Paint.AreaDelete($(this).attr("href")); return false;')); ?></td>
    </tr>
    <?php
}
    ?>
</table>
<?
}
?>
