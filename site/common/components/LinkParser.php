<?php
/**
 * Парсер статьи, возвращает название статьи, небольшой текст и картинку
 * Картинка должна быть типа jpeg или png и шириной не менее 150px
 *
 * @author Alex Kireev <alexk984@gmail.com>
 */
class LinkParser
{
    const PHOTO_WIDTH = 150;
    /**
     * @var LinkParser
     */
    private static $_instance;

    /**
     * домен сайта этой страницы
     * @var string
     */
    private $domain;

    /**
     * урл страницы которую парсим
     * @var string
     */
    private $url;

    /**
     * @return LinkParser
     */
    public static function getInstance()
    {
        if (null === self::$_instance) {
            self::$_instance = new self();
        }

        return self::$_instance;
    }

    private function __construct()
    {
    }

    /**
     * Возращает данные о странице - название, текст и url картинки
     *
     * @param string $url
     * @return array
     */
    public function parse($url)
    {
        $this->url = $url;

        try {
            $html = $this->file_get_contents_utf8($url);
            $pq = phpQuery::newDocument($html);
        } catch (Exception $err) {
            return false;
        }

        return array(
            'title' => $this->getTitle($pq),
            'text' => $this->getText($pq),
            'image' => $this->getImage($pq),
        );
    }

    /**
     * Получение страницы под видом бота гугл
     *
     * @param string $url url страницы
     * @return string
     */
    function file_get_contents_utf8($url)
    {
        $curl = curl_init();

        $header[0] = "Accept: text/html,application/xhtml+xml,application/xml;q=0.9,*/*;q=0.8;";
        $header[] = "Cache-Control: max-age=0";
        $header[] = "Connection: keep-alive";
        $header[] = "Keep-Alive: 300";
        $header[] = "Content-Type: text/html; charset=windows-1251";
        $header[] = "Accept-Language: ru-ru,ru;q=0.8,en-us;q=0.5,en;q=0.3";
        $header[] = "Pragma: ";

        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_USERAGENT, 'Mozilla/5.0');
        curl_setopt($curl, CURLOPT_HTTPHEADER, $header);
        curl_setopt($curl, CURLOPT_ENCODING, 'gzip,deflate');
        curl_setopt($curl, CURLOPT_AUTOREFERER, true);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curl, CURLOPT_TIMEOUT, 15);

        $html = curl_exec($curl);
        curl_close($curl);

        return $html;
    }

    /**
     * Возвращает заголовок страницы
     *
     * @param phpQueryObject $pq
     * @return string заголовок страницы
     */
    private function getTitle($pq)
    {
        return Str::truncate($pq->find("title")->text(), 200);
    }

    /**
     * Ищет текст для превью
     *
     * @param phpQueryObject $pq
     * @return string текст для превью
     */
    private function getText($pq)
    {
        $description = $pq->find('meta[property="og:description"]')->attr('content');
        if (empty($description))
            $description = $pq->find('meta[name="description"]')->attr('content');
        if (empty($description))
            $description = $this->getPageText();

        return Str::truncate($description, 300);
    }

    private function getPageText()
    {
        return '';
    }

    /**
     * Ищет картинку для превью и возвращает ее url
     *
     * @param phpQueryObject $pq
     * @return string
     */
    private function getImage($pq)
    {
        $image = $pq->find('meta[property="og:image"]')->attr('content');
        if (empty($image))
            $image = $this->findProperImage($pq);

        return $image;
    }

    /**
     * Ищет картинку на странице шириной на менее 200 пикселей
     * Максимум проверяем 30 картинок
     *
     * @param phpQueryObject $pq
     * @return string
     */
    private function findProperImage($pq)
    {
        $url_info = parse_url($this->url);
        $this->domain = $url_info['scheme'].'://'.$url_info['host'];

        $count = 0;
        foreach ($pq->find('img') as $image) {
            $url = pq($image)->attr('src');
            if (!$this->startsWith($url, 'http'))
                $url = $this->domain.$url;

            if ($this->goodPhoto($url))
                return $url;

            $count++;
            if ($count > 30)
                break;
        }

        return '';
    }

    /**
     * Проверяет подходит ли картинка для превью
     *
     * @param string $url url картинки
     * @return bool
     */
    private function goodPhoto($url)
    {
        if (empty($url))
            return false;

        $dir = Yii::getPathOfAlias('site.common.uploads.photos.temp');
        $file_name = $dir . DIRECTORY_SEPARATOR . md5($url . time());
        file_put_contents($file_name, file_get_contents($url));

        return $this->goodImageMimeType($file_name) && $this->goodImageSize($file_name);
    }

    /**
     * Подходит ли картинка по типу
     *
     * @param string $file_name
     * @return bool
     */
    private function goodImageMimeType($file_name)
    {
        $finfo = finfo_open(FILEINFO_MIME_TYPE);
        $mimetype = finfo_file($finfo, $file_name);
        finfo_close($finfo);

        return ($mimetype == 'image/jpeg' || $mimetype == 'image/png');
    }

    /**
     * Подходит ли фото по размеру
     * @param string $file_name
     * @return bool
     */
    private function goodImageSize($file_name)
    {
        list($width) = getimagesize($file_name);

        return $width >= self::PHOTO_WIDTH;
    }

    function startsWith($haystack, $needle)
    {
        return !strncmp($haystack, $needle, strlen($needle));
    }
}