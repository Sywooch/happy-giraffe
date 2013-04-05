<?php
/**
 * Author: alexk984
 * Date: 13.05.12
 */
class SController extends CController
{
    public $pageTitle = '';
    public $fast_nav = array();
    public $icon = 1;
    public $user;

    public function filters()
    {
        return array(
            'accessControl',
        );
    }

    public function accessRules()
    {
        return array(
            array('allow',
                'users' => array('@'),
            ),
            array('deny',
                'users' => array('*'),
            ),
        );
    }

    protected function beforeAction($action)
    {
        $this->user = Yii::app()->user->getModel();

        return parent::beforeAction($action);
    }

    public function getUserModules()
    {
        $menu = array();
        if (Yii::app()->user->checkAccess('superuser'))
            $menu = array(
                'Ключевые слова' => $this->createUrl('/writing/editor/tasks'),
                'Готовое' => $this->createUrl('/writing/existArticles/index'),
                'Продвижение' => $this->createUrl('/promotion/queries/admin'),
                'Статистика' => $this->createUrl('/statistic/stat/groups'),
                'Индексация' => $this->createUrl('/indexing/default/index'),
                'Трафик' => $this->createUrl('/traffic/default/index'),
            );

        if (Yii::app()->user->checkAccess('editor'))
            $menu = array(
                'Написание контента' => $this->createUrl('/writing/editor/tasks', array('rewrite' => 0)),
                'Рерайт' => $this->createUrl('/writing/editor/tasks', array('rewrite' => 1)),
                'Продвижение' => $this->createUrl('/promotion/queries/admin'),
                'Статистика' => $this->createUrl('/statistic/stat/groups'),
                'Трафик' => $this->createUrl('/traffic/default/index'),
            );

        if (Yii::app()->user->checkAccess('admin'))
            $menu = array(
                'Ключевые слова' => $this->createUrl('/writing/editor/tasks'),
                'Продвижение' => $this->createUrl('/promotion/queries/admin'),
                'Статистика' => $this->createUrl('/statistic/stat/groups'),
                'Индексация' => $this->createUrl('/indexing/default/index'),
                'Трафик' => $this->createUrl('/traffic/default/index'),
            );

        if (Yii::app()->user->checkAccess('commentator-manager-panel'))
            $menu ['Комментаторы'] = $this->createUrl('/commentators/default/index');
        if (Yii::app()->user->checkAccess('cook-manager-panel'))
            $menu ['Кулинария'] = $this->createUrl('/competitors/default/index', array('section' => 2));
        if (Yii::app()->user->checkAccess('externalLinks-manager-panel') || Yii::app()->user->checkAccess('externalLinks-manager'))
            $menu ['Внешние ссылки'] = $this->createUrl('/externalLinks/sites/index');
        if (Yii::app()->user->checkAccess('promotion'))
            $menu ['Перелинковка'] = $this->createUrl('/promotion/linking/autoLinking');
        if (Yii::app()->user->checkAccess('needlework-manager-panel'))
            $menu ['Рукоделие'] = '/needlework/tasks/';
        if (Yii::app()->user->checkAccess('needlework-manager-panel'))
            $menu ['Интерьеры'] = '/design/tasks/';

        if (Yii::app()->user->checkAccess('externalLinks-worker-panel') || Yii::app()->user->checkAccess('externalLinks-worker'))
            $menu ['Внешние ссылки'] = $this->createUrl('/externalLinks/tasks/index');
        if (Yii::app()->user->checkAccess('moderator-panel'))
            $menu ['Модератор'] = '/writing/moderator/';

        return $menu;
    }

    public function addEntityToFastList($list_name, $entity_id, $limit = null)
    {
        $entities = Yii::app()->user->getState($list_name);
        if (!is_array($entities))
            $entities = array($entity_id);
        elseif (!in_array($entity_id, $entities))
            $entities[] = $entity_id;
        if (!empty($limit) && count($entities) > $limit)
            array_shift($entities);
        Yii::app()->user->setState($list_name, $entities);
    }
}
