<?php
/**
 * Created by PhpStorm.
 * User: mikita
 * Date: 21/07/14
 * Time: 16:30
 */

class AdsWidget extends CWidget
{
    const VERSION_MOBILE = 0;
    const VERSION_TABLET = 1;
    const VERSION_DESKTOP = 2;

    private $_queries = array(
        self::VERSION_MOBILE => '(max-width: 480px)',
        self::VERSION_TABLET => '(min-width: 481px) and (max-width: 1024px)',
        self::VERSION_DESKTOP => '(min-width: 1025px)',
    );

    public $show;
    public $dummyTag;
    public $responsiveConfig;

    public function init()
    {
        if ($this->show === null) {
            $this->show = Yii::app()->ads->showAds;
        }

        if ($this->show && ! $this->isResponsive()) {
            ob_start();
        }
    }

    public function run()
    {
        if (! $this->show) {
            return;
        }

        $this->registerScripts();
        if ($this->isResponsive()) {
            foreach ($this->responsiveConfig as $version => $view) {
                $code = $this->render('ads/' . $view, null, true);
                $this->render('AdsWidget', array(
                    'contents' => $this->prepareContents($code),
                    'mediaQuery' => $this->_queries[$version],
                ));
            }
        } else {
            $this->render('AdsWidget', array(
                'contents' => ob_get_clean(),
                'mediaQuery' => null,
            ));
        }
    }

    protected function isResponsive()
    {
        return $this->responsiveConfig !== null;
    }

    protected function registerScripts()
    {
        $cs = Yii::app()->clientScript;
        if ($this->isResponsive()) {
            $this->registerLazyAds();
        }
        if ($cs->useAMD) {
            $cs->registerScriptFile('/javascripts/fox.js', ClientScript::POS_AMD);
        }
    }

    protected function registerLazyAds()
    {
        /** @var ClientScript $cs */
        $cs = Yii::app()->clientScript;
        if ($cs->useAMD) {
            $cs->registerAMDFile(array(), '/new/javascript/modules/lazyad-loader.js');
        } else {
            $cs->registerScriptFile('/new/javascript/modules/lazyad-loader.js');
        }
    }

    protected function prepareContents($contents)
    {
        $contents = preg_replace('#<!--(.*?)-->#', '', $contents);
        $contents = str_replace('<!--', '', $contents);
        $contents = str_replace('// -->', '', $contents);
        $contents = str_replace('<script', '<!-- <script', $contents);
        $contents = str_replace('</script>', '</script> -->', $contents);
        return $contents;
    }
} 