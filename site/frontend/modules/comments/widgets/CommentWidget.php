<?php

namespace site\frontend\modules\comments\widgets;

/**
 * Виджет, предназначенный для вывода комментариев
 *
 * @author Кирилл
 */
class CommentWidget extends \CWidget
{
    public $model;
    
    public function run()
    {
        echo 'comments';
    }
}

?>
