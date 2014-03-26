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

    public $cssDomain;
    public $jsDomain;
    public $imagesDomain;

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
        $url .= (strpos($url, '?') === false) ? '?r=' . $r : '&r=' . $r;
        return $url;
    }

    protected function getReleaseId()
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

    public function init()
    {
        if (! isset($this->scriptMap['jquery.js']))
            $this->scriptMap['jquery.js'] = 'http://yandex.st/jquery/1.8.3/jquery.js';
        if (! isset($this->scriptMap['jquery.min.js']))
            $this->scriptMap['jquery.min.js'] = 'http://yandex.st/jquery/1.8.3/jquery.min.js';
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

//    protected function processJsFiles()
//    {
//        foreach ($this->scriptFiles as $position => $scriptFiles) {
//            $hash = md5(serialize($scriptFiles) . '1');
//
//            $dir = substr($hash, 0, 2);
//            $file = substr($hash, 2);
//            $dirPath = Yii::getPathOfAlias('application.www-submodule.jsd') . DIRECTORY_SEPARATOR . $dir;
//
//            $path = $dirPath . DIRECTORY_SEPARATOR . $file . '.js';
//
//            if (! file_exists($path)) {
//                $js = '';
//                foreach ($scriptFiles as $scriptFile => $scriptFileValue) {
//                    if (strpos($scriptFile, '/') === 0)
//                        $scriptFile = Yii::getPathOfAlias('webroot') . $scriptFile;
//                    $fileSrc = file_get_contents($scriptFile);
//                    $js .= $fileSrc . ';';
//                    unset($this->scriptFiles[$scriptFile]);
//                }
//
//                if (! is_dir($dirPath))
//                    mkdir($dirPath);
//                file_put_contents($path, $js);
//            }
//
//            $url = '/jsd/' . $dir . '/' . $file . '.js';
//            if ($this->getJsStaticDomain())
//                $url = $this->getJsStaticDomain() . $url;
//            $this->scriptFiles[$position] = array($url => $url);
//        }
//    }

//    public function processJsFiles()
//    {
//        foreach ($this->packages as $package => $settings)
//            $this->registerPackage($package);
//
//        $releaseId = $this->getReleaseId();
//        foreach ($this->scriptFiles as $position => $scriptFiles) {
//            $hash = md5($releaseId . $position);
//            $dir = substr($hash, 0, 2);
//            $file = substr($hash, 2);
//            $dirPath = Yii::getPathOfAlias('application.www-submodule.jsd') . DIRECTORY_SEPARATOR . $dir;
//            $path = $dirPath . DIRECTORY_SEPARATOR . $file . '.js';
//            if (! file_exists($path)) {
//                $js = '';
//                foreach ($scriptFiles as $scriptFile => $scriptFileValue) {
//                    if (strpos($scriptFile, '/') === 0)
//                        $scriptFile = Yii::getPathOfAlias('webroot') . $scriptFile;
//                    $fileSrc = file_get_contents($scriptFile);
//                    $js .= $fileSrc . ';';
//                }
//
//                if (! is_dir($dirPath))
//                    mkdir($dirPath);
//                file_put_contents($path, $js);
//            }
//
//            foreach ($scriptFiles as $scriptFile => $scriptFileValue)
//                unset($this->scriptFiles[$position[$scriptFile]]);
//
//            $url = '/jsd/' . $dir . '/' . $file . '.js';
//            if ($this->getJsStaticDomain())
//                $url = $this->getJsStaticDomain() . $url;
//            $this->scriptFiles[$position] = array($url => $url);
//        }
//    }

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

    protected function processImages(&$content)
    {
        if ($this->getImagesStaticDomain() !== null) {
            $dom = new DOMDocument();
            @$dom->loadHTML($content);

            foreach ($dom->getElementsByTagName('img') as $img) {
                $src = $img->getAttribute('src');
                if (strpos($src, '/') === 0)
                    $img->setAttribute('src', $this->getImagesStaticDomain() . $src);
            }

            $content = $dom->saveHTML();
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