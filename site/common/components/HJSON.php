<?php

/**
 * Хелпер для преобразования объектов в JSON
 *
 * @author Кирилл
 */
class HJSON extends CJSON
{

    /**
     * Расширенный метод конвертирования объектов в JSON,
     * позволяет настраивать структуру JSON-объекта
     * 
     * @param mixed $var объект для конвертирования
     * @param array $config настройки структуры JSON
     * @param array $subConfig настройки структуры JSON, для рекурсивного обхода
     * @return string
     */
    public static function encode($var, $config = array(), $subConfig = array())
    {
        /* $config = func_num_args() > 1 ? func_get_arg(1) : array();
          $subConfig = func_num_args() > 2 ? func_get_arg(2) : array(); */
        switch (gettype($var))
        {
            case 'array':
                return self::encodeArray($var, $config, $subConfig);
                break;
            case 'object':
                return self::encodeModel($var, $config, $subConfig);
                break;
            default:
                return parent::encode($var);
        }
    }

    public static function nameValue($name, $value, $config = array(), $subConfig = array())
    {
        return self::encode(strval($name)) . ':' . self::encode($value, $config, $subConfig);
    }

    protected static function encodeModel($var, $config = array(), $subConfig = array())
    {
        if (($conf = self::getConfig($var, $subConfig)) || ($conf = self::getConfig($var, $config)))
        {
            $vars = array();
            foreach ($conf as $k => $v)
            {
                $field = $k;
                $fieldConf = $v;
                if (is_int($k))
                {
                    $field = $v;
                    $fieldConf = array();
                }
                $vars[] = self::nameValue($field, $var->{$field}, $config, $fieldConf);
            }

            return '{' . join(',', $vars) . '}';
        }
        elseif ($var instanceof CComponent && $var->asa('HToJSONBehavior'))
        {
            $vars = $var->asa('HToJSONBehavior')->toJSON();
        }
        elseif ($var instanceof IHToJSON)
        {
            $vars = $var->toJSON();
        }
        elseif ($var instanceof Traversable)
        {
            $vars = array();
            foreach ($var as $k => $v)
                $vars[$k] = $v;
        }
        else
            $vars = get_object_vars($var);

        return '{' .
            join(',', array_map(function($name, $value) use ($config)
                    {
                        return HJSON::nameValue($name, $value, $config);
                    }, array_keys($vars), array_values($vars)))
            . '}';
    }

    protected static function encodeArray($var, $config, $subConfig)
    {
        if (($conf = self::getConfig($var, $subConfig)) || ($conf = self::getConfig($var, $config)))
        {
            foreach ($conf as $k => $v)
            {
                $field = $k;
                $fieldConf = $v;
                if (is_int($k))
                {
                    $field = $v;
                    $fieldConf = array();
                }

                $vars[] = self::nameValue($field, $var[$field], $config, $fieldConf);
            }

            return '{' . join(',', $vars) . '}';
        }
        elseif (is_array($var) && count($var) && (array_keys($var) !== range(0, sizeof($var) - 1)))
        {
            return '{' .
                join(',', array_map(function($name, $value) use ($config)
                        {
                            return HJSON::nameValue($name, $value, $config);
                        }, array_keys($var), array_values($var)))
                . '}';
        }
        else
        {
            // treat it like a regular array
            return '[' . join(',', array_map(function($value) use ($config, $subConfig)
                        {
                            return HJSON::encode($value, $config, $subConfig);
                        }, $var)) . ']';
        }
    }

    protected static function getConfig($obj, $config)
    {
        $class = (is_object($obj) ? get_class($obj) : (is_array($obj) ? 'array' : 'plain'));
        if (isset($config[$class]))
            return $config[$class];

        if ($class == 'array')
            return false;

        foreach ($config as $class => $conf)
            if ($obj instanceof $class)
                return $conf;

        return false;
    }

}

?>
