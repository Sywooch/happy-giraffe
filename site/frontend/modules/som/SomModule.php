<?php

namespace site\frontend\modules\som;

/**
 * Модуль, являющийся родительским для сервисно-ориентированных модулей (реализующих SOA)
 * Модуль будет отвечать за деградацию отдельных модулей,
 * может управлять компонентом логирования для запросов к API.
 *
 * @author Кирилл
 */
class SomModule extends \CWebModule
{

    public function init()
    {
        // Используем новый AuthManager
        \Yii::app()->setComponent('authManager', array(
            'class' => '\site\frontend\components\AuthManager',
        ));
        // Прописываем список модулей
        $this->setModules(array(
            'status' => array(
                'class' => 'site\frontend\modules\som\modules\status\StatusModule',
            ),
            'photopost' => array(
                'class' => 'site\frontend\modules\som\modules\photopost\PhotopostModule',
            ),
            'activity' => array(
                'class' => 'site\frontend\modules\som\modules\activity\ActivityModule',
            ),
            'community' => array(
                'class' => 'site\frontend\modules\som\modules\community\CommunityModule',
            ),
            'qa' => array(
                'class' => 'site\frontend\modules\som\modules\qa\QaModule',
            ),
        ));
    }

}
