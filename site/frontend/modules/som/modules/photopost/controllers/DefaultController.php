<?php

namespace site\frontend\modules\som\modules\photopost\controllers;

use site\frontend\modules\som\modules\photopost\models\Photopost;
use site\frontend\modules\photo\models\api\Attach;
use site\frontend\modules\photo\models\api\Collection;

/**
 * Description of DefaultController
 *
 * @author Кирилл
 */
class DefaultController extends \site\frontend\modules\posts\controllers\PostController
{

    public $photoId = null;
    public $layout = 'site.frontend.modules.posts.views.layouts.newBlogPost';
    protected $_photopost = null;
    protected $_collection = null;
    protected $_attach = null;
    protected $_attaches = null;
    protected $_prevAttach = null;
    protected $_nextAttach = null;

    public function getPhotopost()
    {
        if (is_null($this->_photopost)) {
            $this->_photopost = Photopost::model()->findByPk($this->post->originEntityId);
        }

        return $this->_photopost;
    }

    public function getCollection()
    {
        if (is_null($this->_collection)) {
            $this->_collection = Collection::model()->findByPk($this->photopost->collectionId);
        }

        return $this->_collection;
    }

    public function getAttach()
    {
        if (is_null($this->_attach)) {
            if ($this->photoId) {
                foreach ($this->attaches as $i => $attach) {
                    if ($attach->photo['id'] == $this->photoId) {
                        $this->_attach = $attach;
                        if (isset($this->attaches[$i - 1])) {
                            $this->_prevAttach = $this->attaches[$i - 1];
                            if ($i == 1) {
                                $this->_prevAttach->url = '';
                            }
                        }
                        if (isset($this->attaches[$i + 1])) {
                            $this->_nextAttach = $this->attaches[$i + 1];
                        }
                        break;
                    }
                }
                if (!$this->_attach) {
                    throw new \CHttpException(404);
                }
            } else {
                $this->_attach = $this->attaches[0];
                $this->_nextAttach = $this->attaches[1];
            }
        }

        return $this->_attach;
    }

    public function getPrevAttach()
    {
        $this->getAttach();
        return $this->_prevAttach;
    }

    public function getNextAttach()
    {
        $this->getAttach();
        return $this->_nextAttach;
    }

    public function getAttaches()
    {
        if (is_null($this->_attaches)) {
            $this->_attaches = Attach::model()->findAllByCollection($this->photopost->collectionId);
        }

        return $this->_attaches;
    }

    public function actionPhotoView($content_id, $photoId = false)
    {
        if ($photoId) {
            $this->strictCheck = false;
        }

        $this->photoId = $photoId;
        $this->actionView($content_id, 'nppost');
    }

}
