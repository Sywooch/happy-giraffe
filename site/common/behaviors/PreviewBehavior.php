<?php

class PreviewBehavior extends CActiveRecordBehavior
{
    const LIMIT_SMALL = 180;
    const LIMIT_BIG = 500;
    public $small_preview = false;

    public function afterSave($event)
    {
        parent::afterSave($event);

        $this->owner->content->preview = $this->generatePreview($this->owner->text);
        $this->owner->content->save(false);
    }

    /**
     * Создает превью из полного текста
     * @param string $text
     * @return string
     */
    private function generatePreview($text)
    {
        include_once Yii::getPathOfAlias('site.frontend.vendor.simplehtmldom_1_5') . DIRECTORY_SEPARATOR . 'simple_html_dom.php';
        $doc = str_get_html($text);

        if (Str::htmlTextLength($text) == 0)
            return '';

        if ($this->small_preview || strstr($text, '<img') === TRUE) {
            //если есть фото или известно что нужно показаться короткое превью, берем первый параграф
            $p_list = $doc->find('p');

            if (count($p_list) == 0)
                return '<p>' . Str::getDescription($text, self::LIMIT_SMALL*2) . '</p>';

            foreach ($p_list as $p) {
                $p_text = trim($p->plaintext);
                if (!empty($p_text))
                    return '<p>' . Str::getDescription($p_text, self::LIMIT_SMALL*2) . '</p>';
            }
            return '';
        } else {
            $preview = '';
            $p_list = $doc->find('p');
            if (count($p_list) == 0)
                return '<p>' . Str::getDescription($text, self::LIMIT_BIG*2) . '</p>';

            foreach ($p_list as $p) {
                $p_text = trim(pq($p)->text());
                if (self::LIMIT_BIG - Str::htmlTextLength($preview) < 100)
                    return $preview;

                if (!empty($p_text))
                    $preview .= '<p>' . Str::getDescription($p_text, (self::LIMIT_BIG - Str::htmlTextLength($preview))*2) . '</p>';

                if (self::LIMIT_BIG - Str::htmlTextLength($preview) < 10)
                    return $preview;
            }

            return $preview;
        }
    }
}