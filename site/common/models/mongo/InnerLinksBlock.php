<?php
/**
 * Author: alexk984
 * Date: 21.10.12
 */
class InnerLinksBlock extends EMongoDocument
{
    public $url;
    public $html;

    /**
     * @param string $className
     * @return InnerLinksBlock
     */
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    public function getCollectionName()
    {
        return 'inner_links_block';
    }

    public function getLinkCount()
    {
        $page = Page::model()->findByAttributes(array('url' => $this->url));
        if (strpos($this->url, '/view/content_id/') !== false){
            if ($page !== null)
                echo "page is not null";
            else
                echo "page null";
        }
        if ($page !== null)
            return $page->outputLinksCount;
        return 0;
    }

    public function getHtmlByUrl($url){
        $model = InnerLinksBlock::model()->findByAttributes(array('url' => $url));
        if ($model !== null)
            return $model->html;

        return '';
    }

    public function Sync($command)
    {
        echo "update \n";
        $pageIds = Yii::app()->db_seo->createCommand()
            ->selectDistinct('page_id')
            ->from('inner_linking__links')
            ->queryColumn();

        $i = 0;
        foreach ($pageIds as $page_id) {
            $page = Page::model()->findByPk($page_id);
            $html = $command->renderFile(Yii::getPathOfAlias('site.common.tpl.innerLinks') . '.php',
                array('link_pages' => $page->outputLinks), true);

            $exist = InnerLinksBlock::model()->findByAttributes(array('url' => $page->url));
            if ($exist === null) {
                $exist = new InnerLinksBlock;
                $exist->html = $html;
                $exist->url = $page->url;
                $exist->save();
                $i++;
            } else {
                if ($exist->html != $html) {
                    $exist->html = $html;
                    $exist->save();
                    $i++;
                }
            }
        }
        echo "updated: $i \n";
        $this->RemoveDeleted();
    }

    public function RemoveDeleted()
    {
        echo "remove deleted\n";

        $criteria = new EMongoCriteria();
        $criteria->limit(100);
        $i = 0;
        $models = array(0);
        while (!empty($models)) {
            $models = InnerLinksBlock::model()->findAll($criteria);
            foreach ($models as $model) {
                if ($model->getLinkCount() == 0){
                    $model->delete();
                    $i++;
                }
            }

            $criteria->setOffset($criteria->getOffset() + 100);
        }

        echo "removed: $i \n";
    }
}
