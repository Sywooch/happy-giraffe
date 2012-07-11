<?php
/**
 * Author: alexk984
 * Date: 25.04.12
 */

class VoteWidget extends CWidget
{
    public $template = null;
    /**
     * JQuery selectors for link buttons
     * @var array
     */
    public $links = null;
    /**
     * JQuery selectors for result inserts
     * @var array
     */
    public $result = null;
    /**
     * JQuery selectors for insert total count
     * @var string
     */
    public $total = null;
    /**
     * JQuery selectors for insert rating (votes amount with code 1 - votes amount with code 0)
     * @var string
     */
    public $rating = null;
    public $main_selector = null;
    /**
     * All user votes in array
     * @var array
     */
    public $all_votes = null;

    public $depends = array();
    /**
     * @var VoteBehavior
     */
    public $model = null;

    public $js = '';

    public $init = false;

    public function run()
    {
        if (!$this->init)
            $this->GenerateTemplate();
        $this->GenerateScript();
    }

    private function GenerateTemplate()
    {
        if ($this->all_votes === null)
            $vote = $this->model->getCurrentVote(Yii::app()->user->id);
        else{
            if (isset($this->all_votes[$this->model->owner->id]))
                $vote = $this->all_votes[$this->model->owner->id];
            else
                $vote = null;
        }

        //insert values in template
        foreach ($this->model->vote_attributes as $key => $value) {
            $this->template = str_replace('{vote' . $key . '}', $this->model->$value, $this->template);
            $this->template = str_replace('{vote_percent' . $key . '}', $this->model->getPercent($key), $this->template);

            if ($vote !== null && $vote == $key)
                $this->template = str_replace('{active' . $key . '}', ' active', $this->template);
            else
                $this->template = str_replace('{active' . $key . '}', '', $this->template);
        }

        echo $this->template;
        echo CHtml::hiddenField('id', $this->model->id, array('class' => 'obj_id'));
        if (!empty($this->depends)){
            foreach($this->depends as $key=>$value){
                echo CHtml::hiddenField('depends['.$key.']', $value, array('class' => 'depends','rel'=>$key));
            }
        }
    }


    private function GenerateScript()
    {
        $insert_result = '';
        foreach ($this->model->vote_attributes as $key => $value) {
            $arr = $this->result[$key];
            $insert_result .= "main_bl.find('" . $arr[0] . "').text(response.$value);\n";
            $insert_result .= "main_bl.find('" . $arr[1] . "').text(response." . $value . "_percent);\n";
        }

        //form javascript
        if (! Yii::app()->user->isGuest) {
            $js = "$('body').delegate('$this->main_selector a', 'click', function(e) {
                e.preventDefault();
                if ($(this).hasClass('active'))
                    return false;

                var button = $(this);
                var vote = button.attr('vote');
                var main_bl = $(this).parents('$this->main_selector');
                var object_id = $(this).parents('$this->main_selector').find('.obj_id').val();

                var request = 'object_id='+object_id+'&vote='+vote+'&model=" . get_class($this->model) . "&';
                var depends = main_bl.find('input.depends');
                depends.each(function(index, Element) {
                    request += 'depends['+$(this).attr('rel')+']='+$(this).val()+'&';
                });

                $.ajax({
                    dataType: 'JSON',
                    type: 'POST',
                    url: '" . Yii::app()->createUrl('ajax/vote') . "',
                    data: request,
                    success: function(response) {
                        main_bl.find('a').removeClass('active');
                        $(this).addClass('active');
                        $insert_result
                        main_bl.find('$this->rating').text(response.rating);
                    },
                    context:$(this)
                });
            });";
        } else {
            $js = "
                $('body').delegate('$this->main_selector a', 'click', function(e) {
                    e.preventDefault();
                    $('a[href=\"#register\"]').click();
                });
            ";
        }
        $this->js = $js;

        Yii::app()->clientScript->registerScript('vote-' . get_class($this->model), $js);
    }
}