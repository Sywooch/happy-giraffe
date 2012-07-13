<?php
/**
 * Author: alexk984
 * Date: 04.07.12
 */
class PageMetaTag extends EMongoDocument
{
    public $route;
    public $params;

    public $description;
    public $title;
    public $keywords;

    public $author_id;
    public $created;

    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    public function getCollectionName()
    {
        return 'page_meta_tags';
    }

    public function rules()
    {
        return array(
            array('description, title, keywords', 'safe'),
        );
    }

    public function beforeSave()
    {
        if ($this->isNewRecord) {
            $this->created = time();
        }
        $this->author_id = (int)Yii::app()->user->id;

        return parent::beforeSave();
    }

    /**
     * @static
     * @param string $route
     * @param array $params
     * @param bool $create
     * @return \PageMetaTag
     */
    public static function getModel($route, $params, $create = false)
    {
        $criteria = new EMongoCriteria;
        $params2 = array();
        foreach($params as $param)
            $params2[] = utf8_encode($param);

        $criteria->route('==', $route);
        $criteria->params('==', $params2);
        $model = self::model()->find($criteria);
        if ($model === null && $create) {
            $model = new PageMetaTag();
            $model->route = $route;
            $model->params = $params;
            $model->description = '';
            $model->keywords = '';
            $model->save();
        }

        return $model;
    }

    /**
     * @return Page
     */
    public function getPage()
    {
        $url = 'http://www.happy-giraffe.ru' . Yii::app()->createUrl($this->route, $this->params);
        //$url = Yii::app()->createAbsoluteUrl($model->route, $model->params);

        return Page::model()->findByAttributes(array('url' => $url));
    }

    /**
     * @param $page
     * @return CActiveDataProvider
     */
    public function getPhrases($page)
    {
        if ($page !== null) {
            $criteria = new CDbCriteria;
            $criteria->compare('page_id', $page->id);
            $dataProvider = new CActiveDataProvider('PagesSearchPhrase', array(
                'criteria' => $criteria,
                'pagination' => array('pageSize' => 7),
            ));
            $paginator = $dataProvider->getPagination();
            $paginator->setCurrentPage(isset($_GET['page'])?$_GET['page'] - 1:0);
            $dataProvider->setPagination($paginator);

            return $dataProvider;
        }
        return null;
    }
}