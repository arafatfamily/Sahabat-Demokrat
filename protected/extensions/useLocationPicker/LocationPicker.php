<?php

class LocationPicker extends CWidget
{
	public $latId;
	public $lonId;
	public $height = "240px";
	public $searchLabel = "Cari..";
	public $model;
	
	public function init() {
		echo CHtml::openTag('div', array("id"=>"divsearch", "class"=>"input-group"));
		echo CHtml::tag("input", array("id"=>"searchtext", "type"=>"text", "class"=>"form-control", "placeholder"=>"Cari lokasi ..."));
		echo CHtml::openTag('span', array("class"=>"input-group-btn"));
		echo CHtml::openTag('button', array("id"=>"searchbutton", "class"=>"btn btn-primary apple"));
		echo CHtml::openTag('i', array("class"=>"fa fa-search"));
		echo CHtml::closeTag('i');
		echo CHtml::closeTag('button');
		echo CHtml::closeTag('div');
		echo CHtml::openTag('div', array("class"=>"clearfix"));
		echo CHtml::closeTag('div');
		echo CHtml::openTag('div',array("id"=>"clocationmap", "class"=>"", "style"=>"height:".$this->height))."\n";
		echo CHtml::closeTag('div');
		
		$randNumber = rand(0, 100000);
		$className = get_class($this->model);
		
		echo CHtml::hiddenField($className."[".$this->latId."]", $this->model->latitude, array("class"=>"lat_".$randNumber));
		echo CHtml::hiddenField($className."[".$this->lonId."]", $this->model->latitude, array("class"=>"lon_".$randNumber));
		
		echo CHtml::openTag('style');
		echo "#clocationmap img { max-width: none; }
			#divsearch { text-align : right }
			#divsearch { margin-bottom : 5px }";
		echo CHtml::closeTag('style');
		
		ob_start();
		include("picker.js");
		$picker = ob_get_clean();
		
		Yii::app()->getClientScript()
                  ->registerScript('CLocationPicker',$picker);
	}

	/**
	 * Calls {@link renderMenu} to render the menu.
	 */
	public function run()
	{
		
	}
}