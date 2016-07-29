<?php

namespace site\frontend\modules\quests;

/**
 * Description of PostsModule
 *
 * @author Кирилл
 */
class QuestsModule extends \CWebModule
{
    public $controllerNamespace = 'site\frontend\modules\quests\controllers';
    const QUEST_BEHAVIOR = '\site\frontend\modules\quests\behaviors\QuestBehavior';

    public function init()
    {

    }
}

?>
