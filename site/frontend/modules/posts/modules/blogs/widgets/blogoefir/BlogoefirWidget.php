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
     * Comet канал
     * 
     * @var string
     */
    const CHANNEL_ID = 'efir'; 
    
    /**
     * Лимит записей в блоке
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
        $cometJs = 'comet.connect(\'http://' . \Yii::app()->comet->host . '\', \'' . \Yii::app()->comet->namespace . '\', \'' . self::CHANNEL_ID . '\');';
        
        $cs = \Yii::app()->clientScript;
        
        $cs
            ->registerAMD('Realplexor-reg', array('common', 'comet'), $cometJs)
        ;
        
        $this->_limit = $this->controller->module->getConfig('itemsCountBlogoefir');
        
        $itemsList = $this->_getItemsList();
       
        if (! empty($itemsList))
        {
            $itemsDataJSON = \CJSON::encode($itemsList);
            $itemsDataJSON = str_replace('"', '\'', $itemsDataJSON);
            
            $this->render('view', [
                'itemsDataJSON' => $itemsDataJSON,
                'limit'         => $this->_limit
            ]);
        }
    }
    
    //-----------------------------------------------------------------------------------------------------------
    
    /**
     * Данные
     * 
     * @return NULL|string
     */
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
        
        return $itemsList;
    }
    
}