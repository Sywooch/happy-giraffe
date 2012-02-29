<?php
class AutoTimestampBehavior extends CActiveRecordBehavior 
{
    public $created = 'creation_date';
	public $updated = 'updated_date';
 
    public function beforeValidate($on) {
        $now = date('Y-m-d H:i');
        if ($this->Owner->isNewRecord)
            $this->Owner->{$this->created} = $now;
		if($this->Owner->hasAttribute($this->updated))
			$this->Owner->{$this->updated} = $now;
        return true;
    }
} 