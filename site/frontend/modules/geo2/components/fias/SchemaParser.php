<?php
/**
 * @author Никита
 * @date 22/02/17
 */

namespace site\frontend\modules\geo2\components\fias;


use site\frontend\modules\geo2\components\fias\Field;

class SchemaParser
{
    public $path;

    public function __construct($path)
    {
        $this->path = $path;
    }

    public function parse()
    {
        $doc = new \DOMDocument();
        $doc->loadXML(file_get_contents($this->path));

        $xpath = new \DOMXPath($doc);
        $attributes = $xpath->query('/xs:schema/xs:element[1]/xs:complexType[1]/xs:sequence[1]/xs:element[1]/xs:complexType[1]/xs:attribute');
        
        $tableComment = $xpath->query('/xs:schema/xs:element[1]/xs:annotation[1]/xs:documentation')[0]->nodeValue;
        $fields = [];
        /** @var \DOMElement $attribute */
        foreach ($attributes as $attribute) {
            $name = $attribute->getAttribute('name');
            $comment = $xpath->query('xs:annotation/xs:documentation', $attribute)[0]->nodeValue;
            
            $restrictionNode = $xpath->query('xs:simpleType/xs:restriction', $attribute)[0];
            $type = ($attribute->getAttribute('type')) ? $attribute->getAttribute('type') : $restrictionNode->getAttribute('base');

            $field = new Field();
            $field->name = $name;
            $field->comment = $comment;
            $field->required = $attribute->getAttribute('use') == 'required';

            switch ($type) {
                case 'xs:integer':
                    $field->length = $xpath->query('xs:totalDigits', $restrictionNode)[0]->getAttribute('value');
                    $field->type = Field::TYPE_INTEGER;
                    break;
                case 'xs:string':
                    $field->type = Field::TYPE_STRING;
                    if ($xpath->query('xs:maxLength', $restrictionNode)->length > 0) {
                        $field->length = $xpath->query('xs:maxLength', $restrictionNode)[0]->getAttribute('value');
                    } elseif ($xpath->query('xs:length', $restrictionNode)->length > 0) {
                        $field->length = $xpath->query('xs:length', $restrictionNode)[0]->getAttribute('value');
                    } else {
                        switch ($name) {
                            case 'REGIONCODE':
                                $field->length = 2;
                                break;
                            case 'DOCNAME':
                                $field->length = 100;
                                break;
                            default:
                                throw new \CException(\Yii::t('geo2', 'Undefined length in {field}', ['{field}' => $name]));
                        }
                    }
                    break;
                case 'xs:byte':
                case 'xs:int':
                    $field->type = Field::TYPE_INTEGER;
                    $field->length = 1;
                    break;
                case 'xs:date';
                    $field->type = Field::TYPE_DATE;
                    break;
            }

            $fields[] = $field;
        }
        
        return [
            'comment' => $tableComment,
            'fields' => $fields,
        ];
    }
}