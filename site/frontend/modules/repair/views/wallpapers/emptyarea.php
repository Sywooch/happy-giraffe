<? if (count($areas)) { ?>
<table>
    <?php foreach ($areas as $key => $area) { ?>
    <tr>
        <td><?=$area['title']?></td>
        <td><?=$area['height']?> x <?=$area['width']?> м.</td>
        <td><?php echo CHtml::link('убрать', array('wallpapers/removearea', 'id' => $key), array('onclick' => 'Area.delete($(this).attr("href")); return false;')); ?></td>
    </tr>
    <?php
}
    ?>
</table>
<?
}
?>
