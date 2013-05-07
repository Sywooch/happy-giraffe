<?php
class PageSearchView extends EMongoDocument
{
    public $path;
    public $month;
    public $count = 0;

    public function getCollectionName()
    {
        return 'page_search_views';
    }

    /**
     * @param string $className
     * @return PageSearchView
     */
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    public function indexes()
    {
        return array(
            'main_index' => array(
                'key' => array(
                    'path' => EMongoCriteria::SORT_ASC,
                    'month' => EMongoCriteria::SORT_ASC
                ),
                'unique' => true,
            ),
        );
    }

    public function findPage($path, $month)
    {
        $criteria = new EMongoCriteria;
        $criteria->path('==', $path);
        $criteria->month('==', $month);
        return self::model()->find($criteria);
    }

    public function inc($path)
    {
        $model = $this->findPage($path, date("Y-m"));
        if ($model === null) {
            $model = new PageSearchView;
            $model->month = date("Y-m");
            $model->path = $path;
            $model->count = 1;
            $model->save();
        } else {
            $modifier = new EMongoModifier();
            $modifier->addModifier('count', 'inc', 1);

            $criteria = new EMongoCriteria();
            $criteria->addCond('path', '==', $path);
            $criteria->addCond('month', '==', date("Y-m"));

            PageSearchView::model()->updateAll($modifier, $criteria);
        }
    }

    public function sync($month)
    {
        $criteria = new EMongoCriteria;
        $criteria->month('==', $month);
        $criteria->count('!=', 0);
        $models = PageSearchView::model()->findAll($criteria);
        echo count($models)."\n";

        foreach ($models as $model) {
            //TEST
            //$model->path = str_replace('http://happy-giraffe.com/', 'http://www.happy-giraffe.ru/', $model->path);
            //end test
            $page = Page::getPage($model->path);
            if ($page && in_array($page->entity, array('CommunityContent', 'BlogContent', 'CookRecipe')))
                SearchEngineVisits::addVisits($page->id, $model->count);

            $modifier = new EMongoModifier();
            $modifier->addModifier('count', 'inc', -$model->count);

            //TEST
            //$model->path = str_replace('http://www.happy-giraffe.ru/', 'http://happy-giraffe.com/', $model->path);
            //end test

            $criteria = new EMongoCriteria();
            $criteria->addCond('path', '==', $model->path);
            $criteria->addCond('month', '==', $month);

            PageSearchView::model()->updateAll($modifier, $criteria);
        }
    }
}
