<?php
class Location extends CFormModel {
	public $location;
	public $latitude;
	public $longitude;
	public $zoom;
	
	public function rules() {
		return array(
			array('location, latitude, longitude', 'required'),
		);
	}

}