<?php
/**
 * Author: alexk984
 * Date: 30.05.12
 */

class SpiceColumns
{
    /**
     * @var SpiceColumn[]
     */
    public $columns = array();
    public $models = array();
    /**
     * @var SpiceGroup[]
     */
    public $groups = array();

    public function addModel($model)
    {
        $this->models[] = $model;
        $first_letter = mb_strtoupper(substr($model->title, 0, 2), 'utf8');
        foreach ($this->groups as $group)
            if ($group->letter == $first_letter) {
                $group->models [] = $model;
                return;
            }

        $group = new SpiceGroup();
        $group->letter = $first_letter;
        $group->models [] = $model;

        $this->groups[] = $group;
    }

    public function calcColumns()
    {
        $part_size = count($this->models) / 4;
        $col = new SpiceColumn;
        foreach ($this->groups as $group) {
            if ($col->count() + count($group->models) / 2 > $part_size && count($this->columns) < 3) {
                $this->columns[] = $col;
                $col = new SpiceColumn;
            }

            $col->alphabetGroups[] = $group;
        }

        $this->columns[] = $col;
    }
}

class SpiceColumn
{
    /**
     * @var SpiceGroup[]
     */
    public $alphabetGroups = array();

    public function count()
    {
        $count = 0;
        foreach ($this->alphabetGroups as $group) {
            $count += count($group->models);
        }

        return $count;
    }
}

class SpiceGroup
{
    public $letter = '';
    public $models = array();
}