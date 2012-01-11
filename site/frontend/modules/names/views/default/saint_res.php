<?php
/* @var $this Controller
 * @var $data Array
 */

foreach ($data as $key => $SaintDay) {
    echo $key . ' '.HDate::ruMonth($month).'<br>';
    foreach ($SaintDay as $model) {
        $this->renderPartial('_name', array('data' => $model, 'like_ids' => $like_ids));
    }
}