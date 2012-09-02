<?php
/**
 * Author: alexk984
 * Date: 13.05.12
 */
class SController extends CController
{
    public $pageTitle = '';
    public $fast_nav = array();

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

    public function getUserModules()
    {
        $menu = array();
        if (Yii::app()->user->checkAccess('superuser'))
            $menu = array(
                'Ключевые слова' => $this->createUrl('/competitors/default/index'),
                'Готовое' => $this->createUrl('/writing/existArticles/index'),
                'Продвижение' => $this->createUrl('/promotion/queries/admin'),
                'Статистика' => $this->createUrl('/statistic/stat/groups'),
                'Индексация' => $this->createUrl('/indexing/default/index'),
            );

        if (Yii::app()->user->checkAccess('editor'))
            $menu = array(
                'Ключевые слова' => $this->createUrl('/competitors/default/index'),
                'Продвижение' => $this->createUrl('/promotion/queries/admin'),
                'Статистика' => $this->createUrl('/statistic/stat/groups'),
            );

        if (Yii::app()->user->checkAccess('admin'))
            $menu = array(
                'Ключевые слова' => $this->createUrl('/competitors/default/index'),
                'Продвижение' => $this->createUrl('/promotion/queries/admin'),
                'Статистика' => $this->createUrl('/statistic/stat/groups'),
                'Индексация' => $this->createUrl('/indexing/default/index'),
            );

        if (Yii::app()->user->checkAccess('commentator-manager-panel'))
            $menu ['Комментаторы'] = $this->createUrl('/commentators/default/index');

        return $menu;
    }

    public function addEntityToFastList($list_name, $entity_id)
    {
        $entities = Yii::app()->user->getState($list_name);
        if (!is_array($entities))
            $entities = array($entity_id);
        elseif (!in_array($entity_id, $entities))
            $entities[] = $entity_id;
        Yii::app()->user->setState($list_name, $entities);
    }
}
