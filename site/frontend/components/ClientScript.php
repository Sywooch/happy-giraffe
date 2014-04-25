<?php
/**
 * Created by JetBrains PhpStorm.
 * User: mikita
 * Date: 6/28/13
 * Time: 11:23 AM
 * To change this template use File | Settings | File Templates.
 */

class ClientScript extends CClientScript
{
    const RELEASE_ID_KEY = 'Yii.ClientScript.releaseidkey';
    const URLS_STYLE_NONE = 0;
    const URLS_STYLE_GET = 1;
    const URLS_STYLE_FILENAME = 2;

    public $jsCombineEnabled;

    public $cssDomain;
    public $jsDomain;
    public $imagesDomain;

    public $staticUrlsStyle = self::URLS_STYLE_NONE;

    public function getHasNoindex()
    {
        $robotsTxt = array(
            'albums',
            'signup',
            'search',
            'messaging',
        );

        foreach ($robotsTxt as $segment)
            if (strpos(Yii::app()->request->requestUri, '/' . $segment) === 0)
                return true;


        foreach ($this->metaTags as $tag)
            if (isset($tag['name']) && isset($tag['content']) && $tag['name'] == 'robots' && $tag['content'] == 'noindex')
                return true;

        return false;
    }

    protected function addReleaseId($url)
    {
        $r = $this->getReleaseId();
        switch ($this->staticUrlsStyle) {
            case self::URLS_STYLE_NONE:
                break;
            case self::URLS_STYLE_GET:
                $url .= (strpos($url, '?') === false) ? '?r=' . $r : '&r=' . $r;
                break;
            case self::URLS_STYLE_FILENAME:
                $dotPosition = strrpos($url, '.');
                if ($dotPosition !== false) {
                    $url = substr_replace($url, '.' . $r .  '.', $dotPosition, 1);
                }
        }
        return $url;
    }

    public function getReleaseId()
    {
        $id = Yii::app()->getGlobalState(self::RELEASE_ID_KEY);
        if ($id === null) {
            $id = Yii::app()->securityManager->generateRandomString(32, false);
            Yii::app()->setGlobalState(self::RELEASE_ID_KEY, $id);
        }
        return $id;
    }

    public function render(&$output)
    {
        if(!$this->hasScripts)
            return;

        $this->renderCoreScripts();

        if(!empty($this->scriptMap))
            $this->remapScripts();

        $this->unifyScripts();

        $this->processCssFiles();
        $this->processJsFiles();
        $this->processImages($output);

        $this->renderHead($output);
        if($this->enableJavaScript)
        {
            $this->renderBodyBegin($output);
            $this->renderBodyEnd($output);
        }
    }

    protected function processCssFiles()
    {
        foreach ($this->cssFiles as $url => $media) {
            unset($this->cssFiles[$url]);
            if ($this->getCssStaticDomain() !== null && strpos($url, '/') === 0)
                $url = $this->getCssStaticDomain() . $url;
            $url = $this->addReleaseId($url);
            $this->cssFiles[$url] = $media;
        }
    }

    protected function processJsFiles()
    {
        foreach ($this->scriptFiles as $position => $scriptFiles) {
            foreach ($scriptFiles as $scriptFile => $scriptFileValue) {
                unset($this->scriptFiles[$position][$scriptFile]);
                if ($this->getJsStaticDomain() !== null && strpos($scriptFile, '/') === 0)
                    $scriptFile = $this->getJsStaticDomain() . $scriptFile;
                $scriptFile = $this->addReleaseId($scriptFile);
                $this->scriptFiles[$position][$scriptFile] = $scriptFileValue;
            }
        }
    }

    public function renderCoreScripts()
    {
        if ($this->jsCombineEnabled !== true) {
            parent::renderCoreScripts();
            return;
        }

        if (Yii::app()->request->isAjaxRequest)
            return;

        $scriptFilesTemp = $this->scriptFiles;
        $this->scriptFiles = array();
        foreach ($this->packages as $package => $settings)
            $this->registerPackage($package);
        parent::renderCoreScripts();

        $releaseId = $this->getReleaseId();
        $combinedScripts = array();
        foreach ($this->scriptFiles as $position => $scriptFiles) {
            $hash = md5($releaseId . $position);
            $dir = substr($hash, 0, 2);
            $file = substr($hash, 2);
            $dirPath = Yii::getPathOfAlias('application.www-submodule.jsd') . DIRECTORY_SEPARATOR . $dir;
            $path = $dirPath . DIRECTORY_SEPARATOR . $file . '.js';
            if (! file_exists($path)) {
                $js = '';
                foreach ($scriptFiles as $scriptFile => $scriptFileValue) {
                    if (strpos($scriptFile, '/') === 0)
                        $scriptFile = Yii::getPathOfAlias('webroot') . $scriptFile;
                    $fileSrc = file_get_contents($scriptFile);
                    $js .= $fileSrc . ';';
                }

                if (! is_dir($dirPath))
                    mkdir($dirPath);
                file_put_contents($path, $js);
            }

            $url = '/jsd/' . $dir . '/' . $file . '.js';
            if ($this->getJsStaticDomain())
                $url = $this->getJsStaticDomain() . $url;
            $combinedScripts[$position] = $url;
        }

        $this->scriptFiles = array();
        foreach ($combinedScripts as $position => $val)
            $this->scriptFiles[$position][$url] = $url;
        foreach ($scriptFilesTemp as $position => $scriptFiles)
            foreach ($scriptFiles as $scriptFile => $scriptFileValue)
                $this->scriptFiles[$position][$scriptFile] = $scriptFileValue;
    }

    protected function processImages(&$content)
    {
        if ($this->getImagesStaticDomain() !== null) {
            $content = preg_replace('#img src="(\/[^"]*)"#', 'img src="' . $this->getImagesStaticDomain() . "$1\"", $content);
        }
    }

    protected function getCssStaticDomain()
    {
        return $this->cssDomain;
    }

    protected function getJsStaticDomain()
    {
        return $this->jsDomain;
    }

    protected function getImagesStaticDomain()
    {
        return $this->imagesDomain;
    }
}