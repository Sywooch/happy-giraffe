<?php
/**
 * Author: choo
 * Date: 11.07.2012
 */
class CopyScape
{
    public static function getUniquenessByText($text)
    {
        $data = array(
            'u' => 'mirasmurkov',
            'k' => 'e4mownmg6njsrhrg',
            'o' => 'csearch',
            'e' => 'UTF-8',
            't' => $text,
            'c' => '1',
        );

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, 'http://www.copyscape.com/api/');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        $res = curl_exec($ch);
        curl_close($ch);

        echo $res;
        die;
        $xml = new SimpleXMLElement($res);
        return (isset($xml->result[0]->percentmatched)) ? (100 - $xml->result[0]->percentmatched) : null;
    }
}
