<table>
<?php foreach ($_SESSION['wallpapersCalc']['emptyAreas'] as $key=>$area){ ?>
    <tr>
        <td><?=$area['title']?></td>
        <td><?=$area['height']?> x <?=$area['width']?> м.</td>
        <td><?php echo CHtml::link('убрать', array('wallpapers/removearea', 'id'=>$key ),array('class'=>'remove-area')) ; ?></td>
    </tr>
<?php } ?>
</table>