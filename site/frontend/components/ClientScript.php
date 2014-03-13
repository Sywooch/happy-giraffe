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

    const POS_AMD = 1000;
    
    public $amd = array();
    public $amdFile = false;
    public $useAMD = false;

    public function renderHead(&$output)
    {
        if($this->amdFile && $this->useAMD)
            $this->renderAMDConfig();

        return parent::renderHead($output);
    }
    
    public static function log($data)
    {
        echo CHtml::tag('pre', array(), var_export($data, true));
    }

    public function renderAMDConfig()
    {
        parent::registerScriptFile($this->amdFile, self::POS_HEAD);
        $this->amd['urlArgs'] = 'r=' . rand(0,1000);//Yii::app()->params['releaseId'];
        $this->addPackagesToAMDConfig();
        $conf = $this->amd;
        $eval = $conf['eval'];
        unset($conf['eval']);
        //self::log($this->amd); die;
        parent::registerScript('amd', 'require.config(' . CJSON::encode($this->amd) . ");\n" . $eval, self::POS_HEAD);
    }
    
    public function addPackagesToAMDConfig()
    {
        $shim = array();
        $paths = array();
        $fake = array();

        // переберём все пакеты, в которых есть js и
        // составим конфиг shim для requirejs
        foreach ($this->packages as $name => $config)
            if (isset($config['js']) && !empty($config['js']))
            {
                $i = 0;
                $baseUrl = $this->getPackageBaseUrl($name);
                // Если один файл в пакете
                if (count($config['js']) == 1)
                {
                    $shim[$name] = array('deps' => array());
                    $url = $baseUrl . '/' . str_replace('.js' , '', $config['js'][0]);
                    if (!isset($paths[$url]))
                        $paths[$url] = $name;
                    // Допишем зависимости от других модулей
                    if(isset($config['depends']))
                        foreach ($config['depends'] as $depend)
                            $shim[$name]['deps'][] = $depend;
                }
                else
                // не один файл в пакете
                {
                    $fakeName = 'package-' . $name;
                    // Добавим фейковый модуль с группой зависимостей
                    $fake[$name] = array();
                    $pre = false;
                    foreach ($config['js'] as $script)
                    {
                        $url = $baseUrl . '/' . str_replace('.js' , '', $script);
                        if (!isset($paths[$url]))
                            $paths[$url] = $fakeName . '(' . $i++ . ')';
                        $shim[$paths[$url]] = array();
                        $fake[$name][] = $paths[$url];
                        // Добавим предыдущий модуль в зависимости (необходимо для загрузки цепочкой)
                        if($pre)
                            $shim[$paths[$url]]['deps'][] = $pre;
                        // Запомним предыдущий модуль
                        $pre = $paths[$url];
                    }
                    // Допишем зависимости от других модулей
                    if(isset($config['depends']))
                        foreach ($config['depends'] as $depend)
                            $fake[$name][] = $depend;
                }
                // добавим опцию для пакетов в clientScript,
                // соответствующую опции exports в shim
                if (isset($config['exports']))
                    $shim[$name]['exports'] = $config['exports'];
                // если не было зависимостей, то удалим пустой массив
                if (empty($shim[$name]['deps']))
                    unset($shim[$name]['deps']);
            }

        // Запишем собранное в конфиг
        $paths = array_flip($paths);
        $this->amd = CMap::mergeArray(array(
                'paths' => $paths,
                'shim' => $shim,
        ), $this->amd);
        // Для фейковых модулей нужно выполнить их иницмализацию
        if (!isset($this->amd['eval']))
            $this->amd['eval'] = '';
        foreach ($fake as $name => $deps)
            $this->amd['eval'].= "define(\"" . $name . "\", " . CJSON::encode($deps) . ", function() { return null; });\n";
    }
    
    public function registerAMD($id, $depends, $script = '')
    {
        if (!is_array($depends))
            $depends = array($depends);
        $modules = array_values($depends);
        $params = array();
        if (!isset($depends[0]))
        {
            $params = array_keys($depends);
        }
        return $this->registerScript($id, "require(" . CJSON::encode($modules) . ", function( " . implode(', ', $params) . " ) {\n" . $script . "\n})", self::POS_AMD);
    }

    public function registerAMDFile($depends, $file)
    {
        return $this->registerScript($file, 'require(' . CJSON::encode($depends) . ', function() { require(["' . $file . '"]); })', self::POS_AMD);
    }

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
    
    protected function exception()
    {
        throw new Exception ('Необходимо использовать метод ClientScript::registerAMD для работы в режиме AMD');
    }

    public function registerScript($id, $script, $position = null, array $htmlOptions = array())
    {
        if ($this->useAMD && $position != self::POS_AMD)
            $this->exception();
        else
            return parent::registerScript($id, $script, $position == self::POS_AMD ? self::POS_HEAD : $position, $htmlOptions);
    }

    public function registerCoreScript($name)
    {
        if ($this->useAMD)
            $this->exception();
        else
            return parent::registerCoreScript($name);
    }

    public function registerPackage($name)
    {
        if ($this->useAMD)
            $this->exception();
        else
            return parent::registerPackage($name);
    }

    public function registerScriptFile($url,$position=null,array $htmlOptions=array())
    {
        if($this->useAMD)
            $this->exception();
        else
            return parent::registerScriptFile($url, $position, $htmlOptions);
    }

    public function registerCssFile($url,$media='')
    {
        return parent::registerCssFile($this->addReleaseId($url), $media);
    }

    public function renderCoreScripts()
    {
        if($this->coreScripts===null)
            return;
        $cssFiles=array();
        $jsFiles=array();
        foreach($this->coreScripts as $name=>$package)
        {
            $baseUrl=$this->getPackageBaseUrl($name);
            if(!empty($package['js']))
            {
                foreach($package['js'] as $js)
                    $jsFiles[$baseUrl.'/'.$this->addReleaseId($js)]=$baseUrl.'/'.$js;
            }
            if(!empty($package['css']))
            {
                foreach($package['css'] as $css)
                    $cssFiles[$baseUrl.'/'.$css]='';
            }
        }
        // merge in place
        if($cssFiles!==array())
        {
            foreach($this->cssFiles as $cssFile=>$media)
                $cssFiles[$cssFile]=$media;
            $this->cssFiles=$cssFiles;
        }
        if($jsFiles!==array())
        {
            if(isset($this->scriptFiles[$this->coreScriptPosition]))
            {
                foreach($this->scriptFiles[$this->coreScriptPosition] as $url => $value)
                    $jsFiles[$url]=$value;
            }
            $this->scriptFiles[$this->coreScriptPosition]=$jsFiles;
        }
    }

    protected function addReleaseId($url)
    {
        $r = Yii::app()->params['releaseId'];
        $url .= (strpos($url, '?') === false) ? '?r=' . $r : '&r=' . $r;
        return $url;
    }
}