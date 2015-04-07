<?php
/**
 * @author Никита
 * @date 10/03/15
 */

class MailSenderGeneric extends MailSender
{
    protected $debugMode = self::DEBUG_TESTING;

    public $templateFile;

    public function __construct($templateFile)
    {
        $this->templateFile = $templateFile;
    }

    public function process(User $user)
    {
        $message = new MailMessageGeneric($user, array(
            'templateFile' => $this->templateFile,
        ));
        Yii::app()->postman->send($message);
    }

//    protected function getUsersCriteria()
//    {
//        $criteria = parent::getUsersCriteria();
//        $criteria->join .= ' LEFT OUTER JOIN commentators__contests_participants p ON t.id = p.userId LEFT OUTER JOIN mail__delivery d ON t.id = d.user_id AND d.type = ""';
//        $criteria->addCondition('p.userId IS NULL AND d.id IS NULL');
//        return $criteria;
//    }
}