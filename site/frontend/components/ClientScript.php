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
    const POS_AMD = 1000;
    
    public $amd = array();
    public $amdFile = false;
    public $useAMD = false;

    public function render(&$output)
    {
        if($this->amdFile && $this->useAMD)
            $this->renderAMDConfig();

        if(!$this->hasScripts)
            return;

        $this->renderCoreScripts();

        if(!empty($this->scriptMap))
            $this->remapScripts();

        $this->unifyScripts();

        $this->renderHead($output);
        if($this->enableJavaScript)
        {
            $this->renderBodyBegin($output);
            $this->renderBodyEnd($output);
        }
    }
    
    public static function log($data)
    {
        echo CHtml::tag('pre', array(), var_export($data, true));
    }

    public function renderAMDConfig()
    {
        // Соберём конфиги
        $this->amd['urlArgs'] = 'r=' . rand(0,1000);//$this->releaseId;
        $this->addPackagesToAMDConfig();
        $conf = $this->amd;
        $eval = $conf['eval'];
        unset($conf['eval']);
        
        // Добавим наши скрипты в самое начало
        $this->hasScripts = true;
        if (!isset($this->scriptFiles[self::POS_HEAD]))
            $this->scriptFiles[self::POS_HEAD] = array();
        $this->scriptFiles[self::POS_HEAD] = array(
            $this->amdFile => $this->amdFile,
            ) + $this->scriptFiles[self::POS_HEAD];
        if (!isset($this->scripts[self::POS_HEAD]))
            $this->scripts[self::POS_HEAD] = array();
        $this->scripts[self::POS_HEAD] = array(
            'amd' => 'require.config(' . CJSON::encode($conf) . ");\n" . $eval . "console.log(" . CJSON::encode($this->amd) . ")",
            ) + $this->scripts[self::POS_HEAD];
    }
    
    public function addPackagesToAMDConfig()
    {
        $shim = array();
        $paths = array();
        $fake = array();

        // переберём все пакеты, в которых есть js и
        // составим конфиг shim для requirejs
        foreach ($this->packages as $name => $config)
            if (isset($config['amd']) && $config['amd'] && isset($config['js']) && !empty($config['js']))
            {
                $i = 0;
                $baseUrl = $this->getPackageBaseUrl($name);
                // Если один файл в пакете
                if (count($config['js']) == 1)
                {
                    $shim[$name] = array('deps' => array());
                    $url = $this->remapAMDScript($baseUrl, $config['js'][0]);
                    if (!isset($paths[$url]))
                        $paths[$url] = $name;
                    // Допишем зависимости от других модулей
                    if (isset($config['depends']))
                        $shim[$name]['deps'] = CMap::mergeArray ($config['depends'], $shim[$name]['deps']);
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
                        $url = $this->remapAMDScript($baseUrl, $script);
                        if (!isset($paths[$url]))
                            $paths[$url] = $fakeName . '(' . $i++ . ')';
                        $shim[$paths[$url]] = array('deps' => array());
                        $fake[$name][] = $paths[$url];
                        // Добавим зависимости от родительского модуля
                        if (isset($config['depends']))
                            $shim[$paths[$url]]['deps'] = $config['depends'];
                        // Добавим предыдущий модуль в зависимости (необходимо для загрузки цепочкой)
                        if($pre)
                            $shim[$paths[$url]]['deps'][] = $pre;
                        // Запомним предыдущий модуль
                        $pre = $paths[$url];
                    }
                    // Допишем зависимости от других модулей
                    if(isset($config['depends']))
                        $fake[$name] = CMap::mergeArray ($config['depends'], $fake[$name]);
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
    
    public function remapAMDScript($baseUrl, $script)
    {
        $name = basename($script);
        if (isset($this->scriptMap[$name]) && $this->scriptMap[$name] !== false)
            $script = $this->scriptMap[$name];
        else
            $script = $baseUrl . '/' . $script;
        return str_replace('.js' , '', $script);
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
        return $this->registerScript($id, "$(document).ready(function() { require(" . CJSON::encode($modules) . ", function( " . implode(', ', $params) . " ) {\n" . $script . "\n}); });", self::POS_AMD);
    }

    public function registerAMDFile($depends, $file)
    {
        return $this->registerScript($file, '$(document).ready(function() { require(' . CJSON::encode($depends) . ', function() { require(["' . $file . '"]); }); });', self::POS_AMD);
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
}