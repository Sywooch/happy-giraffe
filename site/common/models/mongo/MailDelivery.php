<?php
/**
 * Author: alexk984
 * Date: 09.08.12
 */
class MailDelivery extends EMongoDocument
{
    const TYPE_IM = 1;

    public $user_id;
    public $type;
    public $created;
    public $last_send_time = null;

    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    public function getCollectionName()
    {
        return 'mail_delivery';
    }

    public function beforeSave()
    {
        if ($this->isNewRecord) {
            $this->created = time();
        }

        return parent::beforeSave();
    }

    /**
     * @return bool
     */
    public function needSend()
    {
        if ($this->type === self::TYPE_IM){
            if (empty($this->last_send_time)){
                 if (time() - $this->created > 600000)
                     return true;
            }else{
                if (time() - $this->last_send_time > 1200000)
                    return true;

                if (time() - $this->last_send_time > 1500000)
                    return false;
            }

            return false;
        }

        return false;
    }
}