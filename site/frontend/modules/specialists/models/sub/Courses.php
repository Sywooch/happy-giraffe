<?php
/**
 * @author Никита
 * @date   26/08/16
 */

namespace site\frontend\modules\specialists\models\sub;

class Courses extends Common
{
    
    /**
     * @var string organization
     */
    public $organization;
    
    /**
     * @var string spec
     */
    public $spec;
    
    public function attributeLabels()
    {
        return array_merge(parent::attributeLabels(), [
            'spec'         => 'Специализация',
            'organization' => 'Организация',
        ]);
    }
    
    /**
     * @inheritdoc
     * @return array
     */
    public function attributeNames()
    {
        return array_merge(parent::attributeNames(), ['spec', 'organization']);
    }
    
    /**
     * @inheritdoc
     * @return array
     */
    public function toJSON()
    {
        return array_merge(parent::toJSON(), [
            'spec'         => $this->spec,
            'organization' => $this->organization,
        ]);
    }
}