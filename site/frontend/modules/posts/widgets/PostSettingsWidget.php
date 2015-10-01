<?php

namespace site\frontend\modules\posts\widgets;

/**
 * Description of PostSettingsWidget
 *
 * @author Кирилл
 */
class PostSettingsWidget extends \CWidget
{

    public $manageInfo = array();
    public $model = false;
    public $tagName = false;
    public $htmlOptions = array();

    public function run()
    {
        $this->fillTagName();
        $this->fillAttributes();
        $this->renderTag();
    }

    public function renderTag()
    {
        echo \CHtml::tag($this->tagName, $this->htmlOptions, '', true);
    }

    public function fillTagName()
    {
        if (isset($this->manageInfo['params']) && $this->manageInfo['params']) {
            $this->tagName = 'post-settings';
        } else {
            $this->tagName = 'article-settings';
        }
    }

    public function fillAttributes()
    {
        if ($this->tagName == 'article-settings') {
            $this->htmlOptions['params'] = \CJSON::encode(array(
                        'articleId' => (int) $this->model->originEntityId,
                        'editUrl' => \Yii::app()->createUrl('/blog/tmp/index', array('id' => $this->model->originEntityId)),
            ));
        } else {
            $this->htmlOptions['params'] = \CJSON::encode($this->manageInfo['params']);
        }
    }

}
