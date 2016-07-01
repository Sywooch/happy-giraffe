<?php

namespace site\frontend\modules\posts\modules\blogs\widgets\blogoefir;

use site\frontend\modules\posts\models\Content;
use site\frontend\modules\posts\models\Label;

/**
 * @author Sergey Gubarev
 */
class BlogoefirWidget extends \CWidget
{
    
    /**
     * Лимит постов в блоке
     * 
     * @var integer
     */
    private $_limit;
    
    //-----------------------------------------------------------------------------------------------------------
    
    /**
     * {@inheritDoc}
     * @see CWidget::run()
     */
    public function run()
    {   
        $this->_limit = $this->controller->module->getConfig('itemsCountBlogoefir');
        
        // $data = $this->_getItemsData();
        
        $itemsList = $this->_getItemsList();
        
        // echo count($itemsList);
        // return;
        
        if (! empty($itemsList))
        {
            // $renderItems = $this->render('_items', compact('rows'), TRUE);
            // echo count($itemsList);
            
            $itemsDataJSON = \CJSON::encode($itemsList);
            $itemsDataJSON = str_replace('"', '\'', $itemsDataJSON);
            
            $this->render('view', [
                // 'items' => $renderItems
                'itemsDataJSON' => $itemsDataJSON,
                'limit'         => $this->_limit
            ]);
        }
    }
    
    //-----------------------------------------------------------------------------------------------------------
    
    // private function _getItemsData()
    private function _getItemsList()
    {
        $models = Content::model()
            ->byLabels([
                Label::LABEL_BLOG
            ])
            ->orderDesc()
            ->findAll([
                'limit' => $this->_limit
            ]);
        ;
        
        $itemsList = [];
        
        if (! empty($models))
        {
            foreach ($models as $model)
            {
                $itemsList[] = [
                    'avatarUrl'  => $model->user->avatarUrl,
                    'profileUrl' => $model->user->profileUrl,
                    'fullName'   => $model->user->fullName,
                    'timeTag'    => \HHtml::timeTag($model, ['class' => '']),
                    'title'      => $model->title,
                    'parsedUrl'  => $model->parsedUrl
                ];
            }
        }
        
        /* echo '<pre>';
        print_r($itemsList);
        echo '</pre>'; */
        
        return $itemsList;
        // return $rows;
    }
    
}