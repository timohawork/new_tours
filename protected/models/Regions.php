<?php

class Regions extends ApModel
{
	public function tableName() {
		return 'regions';
	}

	public function rules() {
		return array(
			array('title', 'required'),
			array('parentId, startPointId, active', 'numerical', 'integerOnly' => true),
			array('title', 'length', 'max' => 128),
			array('description', 'safe')
		);
	}

	public function relations() {
		return array(
			'parent' => array(self::BELONGS_TO, 'Regions', 'parentId'),
			'regions' => array(self::HAS_MANY, 'Regions', 'parentId'),
			'points' => array(self::MANY_MANY, 'Points', 'point_regions(regionId, pointId)'),
			'routs' => array(self::MANY_MANY, 'Routs', 'rout_regions(regionId, routId)'),
			'tours' => array(self::HAS_MANY, 'Tours', 'regionId')
		);
	}

	public function attributeLabels() {
		return array(
			'id' => 'ID',
			'uid' => 'Uid',
			'parentId' => 'Parent',
			'title' => 'Title',
			'description' => 'Description',
			'startPointId' => 'Start Point',
			'active' => 'Active',
		);
	}

	public static function model($className = __CLASS__) {
		return parent::model($className);
	}
	
	public function save($runValidation = true, $attributes = null)
	{
		if ($this->isNewRecord) {
			$this->uid = md5(date("Y-m-d H:i:s").rand(1000, 10000));
		}
		parent::save($runValidation, $attributes);
	}
	
	public function getTours($date = null)
	{
		if ($date === null) {
			$date = date("Y-m-d");
		}
		return Tours::model()->findAll('regionId = :region AND startDate >= :start AND endDate <= :end', array(
			':region' => $this->id,
			':start' => $date.' 00:00:00',
			':end' => $date.' 23:59:59'
		));
	}
	
	public static function newRegion($regionId)
	{
		$model = new Regions();
		$model->title = empty($regionId) ? 'Регион' : 'Город';
		$model->parentId = !empty($regionId) ? $regionId : null;
		$model->save();
		return $model;
	}
	
	public function imageUrl()
	{
		if (empty($this->image)) {
			return null;
		}
		return RoutPhotos::DIR_NAME.'/regions/'.$this->id.'/'.$this->image.'_small.jpg';
	}
}
