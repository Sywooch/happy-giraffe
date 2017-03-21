<?php

use ElephantIO\Client;
use ElephantIO\Engine\SocketIO\Version1X;

class SocketIO {
    /**@var \ElephantIO\Client $client*/
    protected static $client;
    /**@var string $namespace*/
    protected static $namespace;

    protected static function getClient()
    {
        if (self::$client == null) {
            /**@todo: move to config*/
            self::$client = new Client(new Version1X('https://localhost:8123'));
        }

        return self::$client;
    }

    /**
     * @param string $namespace
     */
    public static function toNamespace($namespace)
    {
        self::$namespace = "/{$namespace}";
    }

    public static function clearNamespace()
    {
        self::$namespace = null;
    }

    /**
     * @param string $event
     * @param array $data
     */
    public static function sendOnce($event, $data)
    {
        self::getClient()->initialize();

        if (self::$namespace) {
            self::getClient()->of(self::$namespace);
        }

        self::getClient()->emit($event, $data);

        self::close();
    }

    /**
     * @param string $event
     * @param array $data
     */
    public static function send($event, $data)
    {
        self::getClient()->initialize();

        if (self::$namespace) {
            self::getClient()->of(self::$namespace);
        }

        self::getClient()->emit($event, $data);
    }

    public static function close()
    {
        if (self::$client) {
            self::$client->close();
        }

        self::$namespace = null;
    }
}