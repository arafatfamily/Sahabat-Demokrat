<?php
class LocationWidget extends CWidget {
	public $model = null;
	public $map_key = '';
	public $locationAttribute = 'location';
	public $latitudeAttribute = 'latitude';
	public $longitudeAttribute = 'longitude';
	public $zoomAttribute = 'zoom';
	public $label = null;
	public $assets;
	public $defaultLocation = 'Jakarta, Indonesia';
	public $defaultZoom = '5';
	
	public function init()
	{
		$this->assets = Yii::app()->getAssetManager()->publish(dirname(__FILE__) . '/assets'); //, false, -1, true
		$cs = Yii::app()->clientScript;
		$cs->registerCoreScript('jquery');
		$cs->registerScriptFile('http://maps.googleapis.com/maps/api/js?key=' . $this->map_key . '&sensor=false');
		$cs->registerScriptFile($this->assets . '/jquery-gmaps-latlon-picker.js');
		$cs->registerCssFile($this->assets . '/jquery-gmaps-latlon-picker.css');
	}

	public function run()
	{

		$model = $this->model;

		if (!isset($model->{$this->locationAttribute})) $model->{$this->locationAttribute} = $this->defaultLocation;
		if (!isset($model->{$this->zoomAttribute})) $model->{$this->zoomAttribute} = $this->defaultZoom;
		?>

<style>
.map_canvas img {
	max-width: none !important;
}

.map_canvas {
	margin-left: 20px;
	padding: 5px;
}
</style>
<div id="gmap" class="map_canvas" />
<fieldset id="_MAP_783" class="gllpLatlonPicker">
	<div class="row">
		<div class="row">
			<div class="gllpMap">Google Maps</div>
		</div>
		<div class="row">
			<?php echo CHtml::activeTextField($model,$this->latitudeAttribute, array('class'=>'gllpLatitude', 'style'=>'display: none;')); ?>
			<?php echo CHtml::activeTextField($model,$this->longitudeAttribute, array('class'=>'gllpLongitude', 'style'=>'display: none;')); ?>
		</div>
	</div>
</fieldset>
</div>
<?php

	}
}