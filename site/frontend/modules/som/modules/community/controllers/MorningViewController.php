<?php

namespace site\frontend\modules\som\modules\community\controllers;

use \site\frontend\modules\posts\models\Content;

/**
 * Description of MorningViewController
 *
 * @author Кирилл
 */
class MorningViewController extends \site\frontend\modules\posts\controllers\PostController
{

    public $layout = 'morning';
    public $forum = null;
    public $rubric = null;

}
