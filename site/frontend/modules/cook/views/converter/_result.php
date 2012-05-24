<?php
if ($result) {
    echo round($result['qty'], 2) . ' ' . HDate::GenerateNoun(array($result['unit']->title, $result['unit']->title2, $result['unit']->title3), round($result['qty']));
} else {
    echo 'Ошибка конвертации';
}

?>