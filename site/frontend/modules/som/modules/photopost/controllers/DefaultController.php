<?php

namespace site\frontend\modules\som\modules\photopost\controllers;

use site\frontend\modules\som\modules\photopost\models\Photopost;
use site\frontend\modules\photo\models\api\Attach;

/**
 * Description of DefaultController
 *
 * @author Кирилл
 */
class DefaultController extends \site\frontend\modules\posts\controllers\PostController
{

    public $attachNumber = null;
    public $layout = 'site.frontend.modules.posts.views.layouts.newBlogPost';
    protected $_photopost = null;
    protected $_collection = null;
    protected $_attach = null;

    public function getPhotopost()
    {
        if (is_null($this->_photopost)) {
            $this->_photopost = Photopost::model()->findByPk($this->post->originEntityId);
        }

        return $this->_photopost;
    }
    
    public function getCollection()
    {
        if(is_null($this->_collection)) {
            $this->_collection = Collection::model()->findByPk($this->photopost->collectionId);
        }
        
        return $this->_collection;
    }
    
    public function getAttach()
    {
        if(is_null($this->_attach)) {
            $this->_attach = Attach::model()->findByCollection($this->photopost->collectionId, $this->attachNumber);
        }
        
        return $this->_attach;
    }

    public function actionPhotoView($content_id, $attach = 0)
    {
        $this->attachNumber = $attach;
        $this->actionView($content_id, 'nppost');
    }
    
}
