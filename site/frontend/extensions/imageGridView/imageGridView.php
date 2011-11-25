<?php

/**
 * Description of imageGridView
 *
 * @author Slava Rudnev <slava.rudnev@gmail.com>
 */
Yii::import('zii.widgets.grid.CGridView');

class imageGridView extends CGridView
{
	public $enableSorting=false;

	public $width=100;
	public $height=130;

	public function init()
	{
		$this->htmlOptions['class'] = 'image-grid-view';

		if($this->baseScriptUrl===null)
			$this->baseScriptUrl=Yii::app()->getAssetManager()->publish(dirname(__FILE__).'/gridview');

		parent::init();
	}

	public function renderItems()
	{
		if($this->dataProvider->getItemCount() > 0 || $this->showTableOnEmpty)
		{
			echo "<div class=\"{$this->itemsCssClass}\">\n";
			ob_start();
			$this->renderTableBody();
			$body = ob_get_clean();
			echo $body; // TFOOT must appear before TBODY according to the standard.
			echo "</div>";
		}
		else
			$this->renderEmptyText();
	}

	public function renderTableBody()
	{
		$data = $this->dataProvider->getData();
		$n = count($data);

		if($n > 0)
		{
			for($row = 0; $row < $n; ++$row)
				$this->renderTableRow($row);
			echo '<div style="clear:both;">&nbsp;</div>';
		}
		else
		{
			echo '<div class="empty">';
			$this->renderEmptyText();
			echo "</div>\n";
		}
	}

	public function renderTableRow($row)
	{
		if($this->rowCssClassExpression !== null)
		{
			$data = $this->dataProvider->data[$row];
			echo '<div class="' . $this->evaluateExpression($this->rowCssClassExpression, array('row' => $row, 'data' => $data)) . '">';
		}
		else if(is_array($this->rowCssClass) && ($n = count($this->rowCssClass)) > 0)
			echo '<div class="' . $this->rowCssClass[$row % $n] . '"';
		else
			echo '<div';
		echo ' style="width: '.$this->width.'px; height: '.$this->height.'px;">';

		ob_start();
		foreach($this->columns as $column)
			$column->renderDataCell($row);
		$body = ob_get_clean();

		echo str_replace('td', 'div', $body);

		echo "</div>\n";
	}
}