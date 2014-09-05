<?php

namespace site\frontend\components\requirejsHelpers;

/**
 * Класс, позволяющий использовать CActiveForm как совместно, так и отдельно от requireJS
 *
 * @author Кирилл
 */
class ActiveForm extends \CActiveForm
{

    /**
     * @var string[] attribute IDs to be used to display error summary.
     * @since 1.1.14
     */
    private $_summaryAttributes = array();

    /**
     * Runs the widget.
     * This registers the necessary javascript code and renders the form close tag.
     */
    public function run()
    {
        if (is_array($this->focus))
            $this->focus = "#" . \CHtml::activeId($this->focus[0], $this->focus[1]);

        echo \CHtml::endForm();
        $cs = \Yii::app()->clientScript;
        if (!$this->enableAjaxValidation && !$this->enableClientValidation || empty($this->attributes))
        {
            if ($this->focus !== null)
            {
                if ($cs->useAMD)
                    $cs->registerAMD('CActiveForm#focus', array('jQuery' => 'jquery'), "
                        if(!window.location.hash)
                            jQuery('" . $this->focus . "').focus();
                    ");
                else
                    $cs
                        ->registerCoreScript('jquery')
                        ->registerScript('CActiveForm#focus', "
                            if(!window.location.hash)
                                jQuery('" . $this->focus . "').focus();
                        ");
            }
            return;
        }

        $options = $this->clientOptions;
        if (isset($this->clientOptions['validationUrl']) && is_array($this->clientOptions['validationUrl']))
            $options['validationUrl'] = \CHtml::normalizeUrl($this->clientOptions['validationUrl']);

        foreach ($this->_summaryAttributes as $attribute)
            $this->attributes[$attribute]['summary'] = true;
        $options['attributes'] = array_values($this->attributes);

        if ($this->summaryID !== null)
            $options['summaryID'] = $this->summaryID;

        if ($this->focus !== null)
            $options['focus'] = $this->focus;

        if (!empty(\CHtml::$errorCss))
            $options['errorCss'] = \CHtml::$errorCss;

        $options = \CJavaScript::encode($options);
        $id = $this->id;

        if ($id == 'question-form') {
            if ($cs->useAMD)
            {
                $cs
                    ->registerAMDCoreScript('yiiactiveform')
                    ->registerAMD(__CLASS__ . '#' . $id, array('$' => 'jquery', 'waitUntilExists', 'yiiactiveform'), "

                        $('#$id').waitUntilExists(function () {
                            $('#$id').yiiactiveform($options);
                        });
                    ");
            }
            else
            {
                $cs->registerCoreScript('yiiactiveform');
                $cs->registerScript(__CLASS__ . '#' . $id, "jQuery('#$id').yiiactiveform($options);");
            }
        }
        else {
            if ($cs->useAMD)
            {
                $cs
                    ->registerAMDCoreScript('yiiactiveform')
                    ->registerAMD(__CLASS__ . '#' . $id, array('$' => 'jquery', 'yiiactiveform'), "
                            $('#$id').yiiactiveform($options);
                    ");
            }
            else
            {
                $cs->registerCoreScript('yiiactiveform');
                $cs->registerScript(__CLASS__ . '#' . $id, "jQuery('#$id').yiiactiveform($options);");
            }
        }


    }

    /**
     * Displays a summary of validation errors for one or several models.
     * This method is very similar to {@link CHtml::errorSummary} except that it also works
     * when AJAX validation is performed.
     * @param mixed $models the models whose input errors are to be displayed. This can be either
     * a single model or an array of models.
     * @param string $header a piece of HTML code that appears in front of the errors
     * @param string $footer a piece of HTML code that appears at the end of the errors
     * @param array $htmlOptions additional HTML attributes to be rendered in the container div tag.
     * @return string the error summary. Empty if no errors are found.
     * @see CHtml::errorSummary
     */
    public function errorSummary($models, $header = null, $footer = null, $htmlOptions = array())
    {
        if (!$this->enableAjaxValidation && !$this->enableClientValidation)
            return \CHtml::errorSummary($models, $header, $footer, $htmlOptions);

        if (!isset($htmlOptions['id']))
            $htmlOptions['id'] = $this->id . '_es_';
        $html = \CHtml::errorSummary($models, $header, $footer, $htmlOptions);
        if ($html === '')
        {
            if ($header === null)
                $header = '<p>' . \Yii::t('yii', 'Please fix the following input errors:') . '</p>';
            if (!isset($htmlOptions['class']))
                $htmlOptions['class'] = \CHtml::$errorSummaryCss;
            $htmlOptions['style'] = isset($htmlOptions['style']) ? rtrim($htmlOptions['style'], ';') . ';display:none' : 'display:none';
            $html = \CHtml::tag('div', $htmlOptions, $header . "\n<ul><li>dummy</li></ul>" . $footer);
        }

        $this->summaryID = $htmlOptions['id'];
        foreach (is_array($models) ? $models : array($models) as $model)
            foreach ($model->getSafeAttributeNames() as $attribute)
                $this->_summaryAttributes[] = \CHtml::activeId($model, $attribute);

        return $html;
    }

}

?>
