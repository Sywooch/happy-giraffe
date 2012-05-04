<?php

/**
 * public function behaviors() {
 *     return array('ManyToManyBehavior');
 * }
 *
 * $post = new Post();
 * $post->categories = Category::model()->findAll();
 * $post->save();
 *
 * $category = new Category();
 * $category->posts = array(5, 6, 7, 10);
 * $caregory->save();
 */

class ManyToManyBehavior extends CActiveRecordBehavior
{
    public function afterSave($on)
    {
        $this->writeManyManyTables();
        return true;
    }

    /**
     * At first, this function cycles through each MANY_MANY Relation. Then
     * it checks if the attribute of the Object instance is an integer, an
     * array or another ActiveRecord instance. It then builds up the SQL-Query
     * to add up the needed Data to the MANY_MANY-Table given in the relation
     * settings.
     */
    public function writeManyManyTables()
    {
        Yii::trace('writing MANY_MANY data for ' . get_class($this->owner), 'system.db.ar.CActiveRecord');

        foreach ($this->owner->relations() as $key => $relation)
        {
            if ($relation['0'] == CActiveRecord::MANY_MANY) // ['0'] equals relationType
            {
                if (isset($this->owner->$key)) {
                    if (is_object($this->owner->$key) || is_numeric($this->owner->$key)) {
                        $this->executeManyManyEntry($this->makeManyManyDeleteCommand(
                                                        $relation[2],
                                                        $this->owner->{$this->owner->tableSchema->primaryKey}));
                        $this->executeManyManyEntry($this->owner->makeManyManyInsertCommand(
                                                        $relation[2],
                                                        (is_object($this->owner->$key))
                                                                ? $this->owner->$key->{$this->owner->$key->tableSchema->primaryKey}
                                                                : $this->owner->{$key}));
                    }
                    else if (is_array($this->owner->$key) && $this->owner->$key != array()) {
                        $this->executeManyManyEntry($this->makeManyManyDeleteCommand(
                                                        $relation[2],
                                                        $this->owner->{$this->owner->tableSchema->primaryKey}));
                        foreach ($this->owner->$key as $foreignobject)
                        {
                            $this->executeManyManyEntry($this->makeManyManyInsertCommand(
                                                            $relation[2],
                                                            (is_object($foreignobject))
                                                                    ? $foreignobject->{$foreignobject->tableSchema->primaryKey}
                                                                    : $foreignobject));
                        }
                    }
                }
            }
        }
    }

    // We can't throw an Exception when this query fails, because it is possible
    // that there is not row available in the MANY_MANY table, thus execute()
    // returns 0 and the error gets thrown falsely.
    public function executeManyManyEntry($query)
    {
        $this->owner->getDbConnection()->createCommand($query)->execute();
    }

    // It is important to use insert IGNORE so SQL doesn't throw an foreign key
    // integrity violation
    public function makeManyManyInsertCommand($model, $rel)
    {
        return sprintf("insert into %s values ('%s', '%s')", $model, $this->owner->{$this->owner->tableSchema->primaryKey}, $rel);
    }

    public function makeManyManyDeleteCommand($model, $rel)
    {
        return sprintf("delete from %s where %s = '%s'", $this->getManyManyTable($model), $this->getRelationNameForDeletion($model), $rel);
    }

    public function getManyManyTable($model)
    {
        if (($ps = strpos($model, '(')) !== FALSE) {
            return substr($model, 0, $ps);
        }
        else
            return $model;
    }

    public function getRelationNameForDeletion($model)
    {
        preg_match('/\((.*),/', $model, $matches);
        return substr($matches[0], 1, strlen($matches[0]) - 2);
    }
}
