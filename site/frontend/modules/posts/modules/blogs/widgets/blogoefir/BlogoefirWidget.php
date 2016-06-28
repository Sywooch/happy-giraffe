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
        
        $rows = $this->_getItemsData();
        
        if (! empty($rows))
        {
            $this->render('view', compact('rows'));
        }
    }
    
    private function _getItemsData()
    {
        $rows = Content::model()
            ->byLabels([
                Label::LABEL_BLOG
            ])
            ->orderDesc()
            ->findAll([
                'limit' => $this->_limit
            ]);
        ;
            
        // var_dump($items);
        
        return $rows;
    }
    
}