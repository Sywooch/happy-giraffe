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

//    public function registerScriptFile($url,$position=null,array $htmlOptions=array())
//    {
//        return parent::registerScriptFile($this->addReleaseId($url), $position, $htmlOptions);
//    }
//
//    public function registerCssFile($url,$media='')
//    {
//        return parent::registerCssFile($this->addReleaseId($url), $media);
//    }
//
//    public function renderCoreScripts()
//    {
//        if($this->coreScripts===null)
//            return;
//        $cssFiles=array();
//        $jsFiles=array();
//        foreach($this->coreScripts as $name=>$package)
//        {
//            $baseUrl=$this->getPackageBaseUrl($name);
//            if(!empty($package['js']))
//            {
//                foreach($package['js'] as $js)
//                    $jsFiles[$baseUrl.'/'.$this->addReleaseId($js)]=$baseUrl.'/'.$js;
//            }
//            if(!empty($package['css']))
//            {
//                foreach($package['css'] as $css)
//                    $cssFiles[$baseUrl.'/'.$css]='';
//            }
//        }
//        // merge in place
//        if($cssFiles!==array())
//        {
//            foreach($this->cssFiles as $cssFile=>$media)
//                $cssFiles[$cssFile]=$media;
//            $this->cssFiles=$cssFiles;
//        }
//        if($jsFiles!==array())
//        {
//            if(isset($this->scriptFiles[$this->coreScriptPosition]))
//            {
//                foreach($this->scriptFiles[$this->coreScriptPosition] as $url => $value)
//                    $jsFiles[$url]=$value;
//            }
//            $this->scriptFiles[$this->coreScriptPosition]=$jsFiles;
//        }
//    }
//
//    protected function addReleaseId($url)
//    {
//        $r = Yii::app()->params['releaseId'];
//        $url .= (strpos($url, '?') === false) ? '?r=' . $r : '&r=' . $r;
//        return $url;
//    }
}