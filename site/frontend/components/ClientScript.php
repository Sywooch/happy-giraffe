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

    /**
     * Специальная константа, для вставки скриптов в обход исключений, при вставке скрипта подменяется на CClientScript::POS_HEAD
     */
    const POS_AMD = 1000;
    const URLS_STYLE_NONE = 0;
    const URLS_STYLE_GET = 1;
    const URLS_STYLE_FILENAME = 2;

    /**
     * @var array Настройки amd (requireJS)
     */
    public $amd = array('paths' => array(), 'shim' => array());

    /**
     * @var string URL до файла, загружаемого первым, должен содержать requireJS
     */
    public $amdFile = false;
    
    /**
     * @var int Позиция для подключения скрипта из ClientScript::amdFile
     */
    public $amdFilePos = false;

    /**
     * @var bool Если true, то используется AMD, обычное использование методов registerScript и подобных приведёт к генерации исключения 
     */
    public $useAMD = false;
    
    /**
     * @var array Конфигурация стилей для lite-версии 
     */
    public $litePackages = array();
    
    /**
     * @var array Подключенные пакеты lite версии
     */
    protected $liteScripts = array();


    // настройки оптимизации отдачи статики
    public $jsCombineEnabled;
    public $cssDomain;
    public $jsDomain;
    public $imagesDomain;
    public $staticUrlsStyle = self::URLS_STYLE_GET;

    public function render(&$output)
    {
        $this->renderLite();
        
        if ($this->amdFile && $this->useAMD)
            $this->renderAMDConfig();

        if (!$this->hasScripts)
            return;

        $this->renderCoreScripts();

        if (!empty($this->scriptMap))
            $this->remapScripts();

        $this->unifyScripts();

        $this->processCssFiles();
        $this->processJsFiles();
        $this->processImages($output);

        $this->renderHead($output);
        if ($this->enableJavaScript)
        {
            $this->renderBodyBegin($output);
            $this->renderBodyEnd($output);
        }
    }

    /**
     * Метод добавляет скрипты для вставки в HEAD страницы, необходимые для работы requireJS
     */
    protected function renderAMDConfig()
    {
        // Соберём конфиги
        $this->amd['urlArgs'] = 'r=' . rand(0, 1000); 
        $this->releaseId;
        $this->addPackagesToAMDConfig();
        $conf = $this->amd;
        $id = Yii::app()->user->id;
        $isGuest = CJSON::encode(Yii::app()->user->isGuest);
        $mod = <<<JS
define("userConfig", function () {
    var userConfig = {
        userId: {$id},
        isGuest: {$isGuest},
        isModer: false
    };

    return userConfig;
});
JS;
        $eval = $conf['eval'] . $mod;
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
            'amd' => 'require.config(' . CJSON::encode($conf) . ");\n" . $eval . " require(['happyDebug'], function(happyDebug) {happyDebug.log('main', 'info', 'RequireJS инициализирован', " . CJSON::encode($this->amd) . ")})",
            ) + $this->scripts[self::POS_HEAD];
    }

    /**
     * Метод добавляет настройки, портированные из пакетов ClientScript в настройки shim для requireJS
     */
    protected function addPackagesToAMDConfig()
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
                        $shim[$name]['deps'] = CMap::mergeArray($config['depends'], $shim[$name]['deps']);
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
                        if ($pre)
                            $shim[$paths[$url]]['deps'][] = $pre;
                        // Запомним предыдущий модуль
                        $pre = $paths[$url];
                    }
                    // Допишем зависимости от других модулей
                    if (isset($config['depends']))
                        $fake[$name] = CMap::mergeArray($config['depends'], $fake[$name]);
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

    /**
     * Метод предназначен для преобразования путей из оригинального через scriptMap в путь, пригодный для requireJS
     * 
     * @param string $baseUrl BaseURL
     * @param string $script Оригинальный адрес скрипта
     * @return string Преобразованный путь
     */
    protected function remapAMDScript($baseUrl, $script)
    {
        $name = basename($script);
        if (isset($this->scriptMap[$name]) && $this->scriptMap[$name] !== false)
            $script = $this->scriptMap[$name];
        else
            $script = $baseUrl . '/' . $script;
        return str_replace('.js', '', $script);
    }

    /**
     * Метод для подключения AMD скрипта, генерирующий в итоге скрипт:
     * $(document).ready(function() { require(<Зависимости>, function( <Аргументы функции> ) { <Скрипт> }); });
     * 
     * @param string $id Уникальный идентификатор скрипта (исключает повторное подключение)
     * @param array $depends Массив с зависимостями, если ассоциативный, то ключи будут использоваться в качесте аргументов функции
     * @param string $script Тело скрипта
     * @return ClientScript
     */
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

    /**
     * Метод, подключающий скрипт из файла, предварительно загрузив зависимости
     * 
     * @param array $depends Массив зависимостей
     * @param string $file URL до файла
     * @return ClientScript
     */
    public function registerAMDFile($depends, $file)
    {
        return $this->registerScript($file, '$(document).ready(function() { require(' . CJSON::encode($depends) . ', function() { require(["' . $file . '"]); }); });', self::POS_AMD);
    }

    /**
     * Метод, добавляющий в конфиг amd скрипт, описанный в corePackages.
     * 
     * @param string $name
     * @return ClientScript
     */
    public function registerAMDCoreScript($name)
    {
        if (isset($this->packages[$name])) // есть в конфиге clientScript, сам загрузится из зависимостей requirejs
            return $this;
        if (isset($this->amd['shim'][$name])) // уже описан в конфиге amd
            return $this;
        if (is_null($this->corePackages))
            $this->corePackages = require(YII_PATH . '/web/js/packages.php');
        if (isset($this->corePackages[$name]) && isset($this->corePackages[$name]['js']))
        {
            $package = $this->corePackages[$name];
            // опубликуем скрипт
            if (isset($package['basePath']))
                $baseUrl = Yii::app()->getAssetManager()->publish(Yii::getPathOfAlias($package['basePath']));
            else
                $baseUrl = $this->getCoreScriptUrl();
            /** @todo Есть несколько пакетов, в которых не один скрипт. Необходимо дописать как в addPackagesToAMDConfig */
            $url = $baseUrl . '/' . substr($package['js'][0], 0, -3);
            // добавим скрипт в конфиг
            $this->amd['paths'][$name] = $url;
            $this->amd['shim'][$name] = array();
            // загрузим зависимости
            if (isset($package['depends']))
                foreach ($package['depends'] as $dependence)
                {
                    $this->registerAMDCoreScript($dependence);
                    $this->amd['shim'][$name][] = $dependence;
                }
        }
        
        return $this;
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

    /**
     * Метод, генерирующий исключение
     * 
     * @throws Exception
     */
    protected function exception()
    {
        throw new Exception('Необходимо использовать метод ClientScript::registerAMD для работы в режиме AMD');
    }

    /**
     * Смотри CClientScript::registerScript.
     * 
     * @throws Exception В случае, если метод используется с вклученным флагом ClientScript::useAMD
     * @param type $id
     * @param type $script
     * @param type $position
     * @param array $htmlOptions
     * @return ClientScript
     */
    public function registerScript($id, $script, $position = null, array $htmlOptions = array())
    {
        if ($this->useAMD && $position != self::POS_AMD)
            $this->exception();
        else
            return parent::registerScript($id, $script, $position == self::POS_AMD ? self::POS_HEAD : $position, $htmlOptions);
    }

    /**
     * Смотри CClientScript::registerCoreScript.
     * 
     * @throws Exception В случае, если метод используется с вклученным флагом ClientScript::useAMD
     * @param type $name
     * @return ClientScript
     */
    public function registerCoreScript($name)
    {
        if ($this->useAMD)
            $this->exception();
        else
            return parent::registerCoreScript($name);
    }

    /**
     * Смотри CClientScript::registerPackage.
     * 
     * @throws Exception В случае, если метод используется с вклученным флагом ClientScript::useAMD
     * @param type $name
     * @return ClientScript
     */
    public function registerPackage($name)
    {
        if ($this->useAMD)
            $this->exception();
        else
            return parent::registerPackage($name);
    }
    
    /**
     * Смотри CClientScript::registerScriptFile.
     * 
     * @throws Exception В случае, если метод используется с вклученным флагом ClientScript::useAMD
     * @param type $url
     * @param type $position
     * @param array $htmlOptions
     * @return ClientScript
     */
    public function registerScriptFile($url, $position = null, array $htmlOptions = array())
    {
        if ($this->useAMD && $position != self::POS_AMD)
            $this->exception();
        else
            return parent::registerScriptFile($url, $position == self::POS_AMD ? self::POS_HEAD : $position, $htmlOptions);
    }

    /**
     * Добавляет id релиза к URL
     * @param $url
     * @return string
     */
    protected function addReleaseId($url)
    {
        $r = $this->getReleaseId();
        switch ($this->staticUrlsStyle)
        {
            case self::URLS_STYLE_NONE:
                break;
            case self::URLS_STYLE_GET:
                $url .= (strpos($url, '?') === false) ? '?r=' . $r : '&r=' . $r;
                break;
            case self::URLS_STYLE_FILENAME:
                $dotPosition = strrpos($url, '.');
                if ($dotPosition !== false)
                {
                    $url = substr_replace($url, '.' . $r . '.', $dotPosition, 1);
                }
        }
        return $url;
    }

    public function getReleaseId()
    {
        $id = Yii::app()->getGlobalState(self::RELEASE_ID_KEY);
        if ($id === null)
        {
            $id = Yii::app()->securityManager->generateRandomString(32, false);
            Yii::app()->setGlobalState(self::RELEASE_ID_KEY, $id);
        }
        return $id;
    }

    /**
     * Объединяет все файлы, перечисленные в packages в несколько файлов, по количеству равное позициям вставки
     * клиент-скрипта. Исходные файлы удаляет из scriptFiles, полученные добавляет
     */
    public function renderCoreScripts()
    {
        if ($this->jsCombineEnabled !== true)
        {
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
        foreach ($this->scriptFiles as $position => $scriptFiles)
        {
            $hash = md5($releaseId . $position);
            $dir = substr($hash, 0, 2);
            $file = substr($hash, 2);
            $dirPath = Yii::getPathOfAlias('application.www-submodule.jsd') . DIRECTORY_SEPARATOR . $dir;
            $path = $dirPath . DIRECTORY_SEPARATOR . $file . '.js';
            if (!file_exists($path))
            {
                $js = '';
                foreach ($scriptFiles as $scriptFile => $scriptFileValue)
                {
                    if (strpos($scriptFile, '/') === 0)
                        $scriptFile = Yii::getPathOfAlias('webroot') . $scriptFile;
                    $fileSrc = file_get_contents($scriptFile);
                    $js .= $fileSrc . ';';
                }

                if (!is_dir($dirPath))
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

    /**
     * Трансформирует относительные ссылки в абсолютные, подставляя домен
     */
    protected function processCssFiles()
    {
        foreach ($this->cssFiles as $url => $media)
        {
            if (strpos($url, '/') === 0 && strpos($url, '/', 1) !== 0)
            {
                unset($this->cssFiles[$url]);
                if ($this->getCssStaticDomain() !== null)
                {
                    $url = $this->getCssStaticDomain() . $url;
                }
                $url = $this->addReleaseId($url);
                $this->cssFiles[$url] = $media;
            }
        }
    }

    /**
     * Трансформирует относительные ссылки в абсолютные, подставляя домен
     */
    protected function processJsFiles()
    {
        foreach ($this->scriptFiles as $position => $scriptFiles)
        {
            foreach ($scriptFiles as $scriptFile => $scriptFileValue)
            {
                if (strpos($scriptFile, '/') === 0 && strpos($scriptFile, '/', 1) !== 0)
                {
                    unset($this->scriptFiles[$position][$scriptFile]);
                    if ($this->getJsStaticDomain() !== null) {
                        $scriptFile = $this->getJsStaticDomain() . $scriptFile;
                    }
                    $scriptFile = $this->addReleaseId($scriptFile);
                    $this->scriptFiles[$position][$scriptFile] = $scriptFileValue;
                }
            }
        }
    }

    /**
     * Трансформирует относительные ссылки изображений верстки в абсолютные, подставляя домен
     *
     * Необходимо учитывать, что изображения, вставленные с помощью CCaptchaWidget - тоже изображения, но
     * их этот метод обрабатывать не должен, иначе они не будут отображаться
     *
     * @todo Сейчас регулярка неуниверсальна, работает только если атрибут src первым в img
     * @param $content
     */
    protected function processImages(&$content)
    {
        if ($this->getImagesStaticDomain() !== null)
        {
            $content = preg_replace('#img src="(\/[^"]*)"#', 'img src="' . $this->getImagesStaticDomain() . "$1\"", $content);
        }
    }

    /**
     * Возвращает домен для css
     *
     * Вынесено в отдельный метод, потому что в будущем может появиться необходимость ротации доменов в зависимости
     * от имени файла
     *
     * @return mixed
     */
    protected function getCssStaticDomain()
    {
        return $this->cssDomain;
    }

    /**
     * Возвращает домен для скриптов
     *
     * Вынесено в отдельный метод, потому что в будущем может появиться необходимость ротации доменов в зависимости
     * от имени файла
     *
     * @return mixed
     */
    protected function getJsStaticDomain()
    {
        return $this->jsDomain;
    }

    /**
     * Возвращает домен для изображения
     *
     * Вынесено в отдельный метод, потому что в будущем может появиться необходимость ротации доменов в зависимости
     * от имени файла
     *
     * @return mixed
     */
    protected function getImagesStaticDomain()
    {
        return $this->imagesDomain;
    }

    /**
     * Метод для подключения стилей из litePackages
     * 
     * @param string $name Имя пакета
     * @return ClientScript
     */
    public function registerLitePackage($name)
    {
        if (isset($this->litePackages[$name]))
        {
            $package = $this->litePackages[$name];
            if(isset($package['depends']))
                foreach ($package['depends'] as $depend)
                    if (!isset($this->liteScripts[$depend]))
                        $this->registerLitePackage($depend);
            $this->liteScripts[$name] = $this->litePackages[$name];
        }

        return $this;
    }

    /**
     * Метод, выполняющий подключение необходимых стилей из пакетов, зарегистрированных через ClientScript::registerLitePackage
     */
    protected function renderLite()
    {
        $v = Yii::app()->user->isGuest ? 'guest' : 'user';
        foreach ($this->liteScripts as $config)
        {
            foreach ($config[$v] as $css => $attrs)
            {
                $baseUrl = isset($config['baseUrl']) ? $config['baseUrl'] : '/';
                if (!is_array($attrs))
                {
                    $css = $attrs;
                    $attrs = array();
                }
                if (isset($attrs['inline']) && $attrs['inline'])
                {
                    /** @todo Реализовать */
                    throw new Exception('Вставка стилей в inline-блоке пока не реализована.');
                }
                else
                {
                    //$this->registerCss
                }
            }
        }
    }

}