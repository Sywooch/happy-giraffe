<?php
/**
 * Author: choo
 * Date: 04.08.2012
 */
class UserToken extends EMongoDocument
{
    public $user_id;
    public $expires;
    public $content;

    public static function model($className=__CLASS__)
    {
        return parent::model($className);
    }

    public function getCollectionName()
    {
        return 'user_tokens';
    }

    public function generate($user_id, $validFor)
    {
        $model = new self;
        $model->user_id = (int) $user_id;
        $model->expires = time() + $validFor;
        $model->content = str_shuffle(md5(microtime()));
        $model->save();
    }

    public function useToken($content)
    {
        $criteria = new EMongoCriteria;
        $criteria->content = $content;
        $criteria->expires('>', time());

        $token = UserToken::model()->find($criteria);
        if ($token !== null) {
            $user_id = $token->user_id;
            $token->delete();
            return $user_id;
        }

        return false;
    }
}
