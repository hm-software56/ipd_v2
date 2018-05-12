<?php

/**
 * This is the model base class for the table "appform_electric_project_site".
 * DO NOT MODIFY THIS FILE! It is automatically generated by giix.
 * If any changes are necessary, you must set or override the required
 * property or method in class "ElectricProjectSite".
 *
 * Columns in table "appform_electric_project_site" available as properties of the model,
 * followed by relations of table "appform_electric_project_site" available as properties of the model.
 *
 * @property integer $id
 * @property integer $electric_application_form_id
 * @property integer $province_id
 * @property integer $district_id
 * @property integer $village_id
 *
 * @property District $district
 * @property Electric $electricApplicationForm
 * @property Province $province
 */
abstract class BaseElectricProjectSite extends GxActiveRecord {

	public static function model($className=__CLASS__) {
		return parent::model($className);
	}

	public function tableName() {
		return 'appform_electric_project_site';
	}

	public static function label($n = 1) {
		return Yii::t('app', 'ElectricProjectSite|ElectricProjectSites', $n);
	}

	public static function representingColumn() {
		return 'id';
	}

	public function rules() {
		return array(
			array('electric_application_form_id, province_id, district_id', 'required'),
			array('electric_application_form_id, province_id, district_id, village_id', 'numerical', 'integerOnly'=>true),
			array('village_id', 'default', 'setOnEmpty' => true, 'value' => null),
			array('id, electric_application_form_id, province_id, district_id, village_id', 'safe', 'on'=>'search'),
		);
	}

	public function relations() {
		return array(
			'district' => array(self::BELONGS_TO, 'District', 'district_id'),
			'electricApplicationForm' => array(self::BELONGS_TO, 'Electric', 'electric_application_form_id'),
			'province' => array(self::BELONGS_TO, 'Province', 'province_id'),
		);
	}

	public function pivotModels() {
		return array(
		);
	}

	public function attributeLabels() {
		return array(
			'id' => Yii::t('app', 'ID'),
			'electric_application_form_id' => null,
			'province_id' => null,
			'district_id' => null,
			'village_id' => Yii::t('app', 'Village'),
			'district' => null,
			'electricApplicationForm' => null,
			'province' => null,
		);
	}

	public function search() {
		$criteria = new CDbCriteria;

		$criteria->compare('id', $this->id);
		$criteria->compare('electric_application_form_id', $this->electric_application_form_id);
		$criteria->compare('province_id', $this->province_id);
		$criteria->compare('district_id', $this->district_id);
		$criteria->compare('village_id', $this->village_id);

		return new CActiveDataProvider($this, array(
			'criteria' => $criteria,
		));
	}
}