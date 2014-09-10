<?php

/**
 * Created by PhpStorm.
 * User: mikita
 * Date: 05/08/14
 * Time: 17:03
 * 
 * @property string $pageTitle Тег title, переопределяется через PageMetaTag
 * @property string $metaDescription Мета-тег description, переопределяется через PageMetaTag
 * @property string $metaKeywords Мета-тег keywoeds, переопределяется через PageMetaTag
 * @property string|array $metaCanonical Мета-тег canonical
 */
class LiteController extends HController
{
    
    protected $_metaCanonical = null;

    public $layout = '//layouts/lite/main';

    public function init()
    {
        header('Vary: User-Agent');
        $this->dnsPrefetch();
        parent::init();
    }

    public function filters()
    {
        $filters = parent::filters();

        /*if (Yii::app()->user->isGuest)
        {
            $filters [] = array(
                'COutputCache',
                'duration' => 300,
                'varyByParam' => array_keys($_GET),
                'varyByExpression' => 'Yii::app()->vm->getVersion()',
            );
        }*/

        return $filters;
    }

    public function getPageTitle()
    {
        //return is_null($this->meta_title) ? parent::getPageTitle() : Str::truncate(trim($this->meta_title), 70);
        return is_null($this->meta_title) ? parent::getPageTitle() : $this->meta_title;
    }

    public function setPageTitle($value)
    {
        if (is_null($this->meta_title))
            parent::setPageTitle($value);
    }

    public function getMetaDescription()
    {
        return $this->meta_description;
    }

    public function setMetaDescription($var)
    {
        $this->meta_description = is_null($this->page_meta_model) ? $var : $this->meta_description;
        ;
    }

    public function getMetaKeywords()
    {
        return $this->meta_keywords;
    }

    public function setMetaKeywords($var)
    {
        $this->meta_keywords = is_null($this->page_meta_model) ? $var : $this->meta_keywords;
        ;
    }
    
    public function getMetaCanonical()
    {
        return $this->_metaCanonical;
    }

    public function setMetaCanonical($var)
    {
        $this->_metaCanonical = $var;
        ;
    }

    protected function afterRender($view, &$output)
    {
        $cs = Yii::app()->clientScript;
        if (!empty($this->meta_description))
        {
            $cs->registerMetaTag(Str::truncate(strip_tags(trim($this->meta_description)), 250), 'description');
        }

        if ($this->meta_keywords !== null)
        {
            $cs->registerMetaTag(trim($this->meta_keywords), 'keywords');
        }
        
        if(!empty($this->metaCanonical))
        {
            $canonical = $this->metaCanonical;
            if(is_array($canonical))
            {
                $route = array_shift($canonical);
                $canonical = $this->createAbsoluteUrl('/' . $route, $canonical);
            }
            $cs->registerLinkTag('canonical', null, $canonical);
        }

        /* if ($this->meta_title !== null)
          {
          $this->pageTitle = Str::truncate(trim($this->meta_title), 70);
          } */

        parent::afterRender($view, $output);
    }

    protected function dnsPrefetch()
    {
        if (YII_DEBUG)
            return;
        /**
         * @var ClientScript $cs
         */
        $cs = Yii::app()->clientScript;
        $cs->registerMetaTag('on', null, 'x-dns-prefetch-control');
        $cs->registerLinkTag('dns-prefetch', null, '//plexor.www.happy-giraffe.ru');
        $cs->registerLinkTag('dns-prefetch', null, '//img.happy-giraffe.ru');
    }

}

