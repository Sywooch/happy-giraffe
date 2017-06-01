<?php


class CommonHActiveRecord extends HActiveRecord
{

    /**
     * При запросе свойств модели, проверяется наличие геттера
     * Имя свойства anyProp или any_prop
     * преобразуется в имя метода getAnyProp
     */
    public function __get($name)
    {
        $splitted = [];
        preg_match_all('/[a-z]+_*?/', $name, $splitted);
        array_walk($splitted[0], function(&$item) {
            $item = ucfirst(strtolower($item));
        });
        $method = 'get' . implode('', $splitted[0]);
        if (method_exists($this, $method) &&
            is_callable(array($this, $method))) {
            return $this->$method();
        }
        return parent::__get($name);
    }

    /**
     * В моделях:
     * /frontend/modules/posts/models/Content.php
     * /frontend/modules/som/modules/qa/models/QaQuestion.php
     * при сохранении данных сохраняется абсолютный путь.
     * Данный метод возвращает относительный путь
     *
     * @return string
     */
    public function getUrl()
    {
        return parent::__get('url') ? (new \Uri(parent::__get('url')))->getPath() : null;
    }

}
