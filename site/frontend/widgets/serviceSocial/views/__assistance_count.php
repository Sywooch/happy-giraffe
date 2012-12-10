<?php
/**
 * @var $exp int
 * @var $count int
 */
$val = floor($count / pow(10, $exp));

if (floor($count / pow(10, $exp)) != 0)
    echo '<span class="assistance-count_item active">' . ($val % 10) . '</span>';
else
    echo '<span class="assistance-count_item">' . ($val % 10) . '</span>';