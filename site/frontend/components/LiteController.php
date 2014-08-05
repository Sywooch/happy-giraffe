<?php
/**
 * Created by PhpStorm.
 * User: mikita
 * Date: 05/08/14
 * Time: 17:03
 */

class LiteController extends HController
{
    protected function beforeRender($view)
    {
        if (parent::beforeRender($view)) {

            $cs = Yii::app()->clientScript;
            if ($this->meta_description !== null) {
                $cs->registerMetaTag(html_dStr::truncate(trim($this->meta_description), 250), 'description');
            }

            if ($this->meta_keywords !== null) {
                $cs->registerMetaTag(trim($this->meta_keywords), 'keywords');
            }

            if ($this->meta_title !== null) {
                $this->pageTitle = Str::truncate(trim($this->meta_title), 70);
            }

            return true;
        }
    }
} 