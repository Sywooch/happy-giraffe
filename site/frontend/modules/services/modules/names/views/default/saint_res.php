<?php
/* @var $this Controller
 * @var $data Array
 */
foreach ($data as $key => $SaintDay) {

    echo '<div class="list_names"><div class="clearfix"><div class="calendar"><span>'.$key .'</span>' . HDate::ruMonth($month) . '</div>';
    $num = 1;
    foreach ($SaintDay as $model) {
        $this->renderPartial('_name', array('data' => $model, 'like_ids' => $like_ids, 'num' => $num));
        $num++;
    }?>
    </div>
</div>
<?php } ?>