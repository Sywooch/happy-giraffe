<?php

class DefaultController extends HController
{

    public $layout = '//layouts/lite/main';
    public $showAddBlock = false;

    public function actionIndex()
    {
        Yii::app()->clientScript->useAMD = true;
        $this->render('yandex');
    }

    /* public function actionIndex($query = '')
      {
      $menu = array_map(function($title, $entity) {
      return compact('title', 'entity');
      }, $this->module->entities, array_keys($this->module->entities));

      $data = compact('menu', 'query');

      $this->pageTitle = 'Поиск';
      $this->render('index', compact('data'));
      }

      public function actionGet($query, $scoring, $perPage, $entity = null)
      {
      $search = SearchManager::search($query, $scoring, $perPage, $entity);

      $data = array(
      'total' => $search['total'],
      'results' => $this->renderPartial('get', array('results' => $search['results']), true),
      'facets' => $search['facets'],
      );

      echo CJSON::encode($data);
      } */
}