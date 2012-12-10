<?php
/**
 * @var $exp int
 * @var $count int
 */
$val = floor($count / pow(10, $exp)) % 10;


if ($val > 0)
    echo '<span class="assistance-count_item active">' . $val . '</span>';
else
    echo '<span class="assistance-count_item">' . $val . '</span>';