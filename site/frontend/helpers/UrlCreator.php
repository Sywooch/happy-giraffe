<?php

class UrlCreator
{

    protected $uri;

    public function __construct(UriInterface $uri)
    {
        $this->uri = $uri;
    }

    /**
     * Построить ссылку на основе текущего адреса
     * @param  string $path
     * @param  array  $params
     * @return UriInterface
     */
    public static function create($path, $params = [])
    {
        $fullUrlPath = \Yii::app()->getRequest()->getHostInfo() . \Yii::app()->getRequest()->getUrl();
        $uri         = new Uri($fullUrlPath);
        if (!empty($path)) {
            $uri = $uri->withPath($path);
        }
        if (!empty($params)) {
            $uri = $uri->withQuery(http_build_query($params));
        }
        return $uri;
    }

}
