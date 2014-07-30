<?php

$iterator = new CDataProviderIterator($dataProvider);
foreach ($iterator as $comment)
{
    $this->render('_comment', array('data' => $comment));
}
?>
