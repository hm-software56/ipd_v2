<?php

/**
 * This is the model base class for the table "appform_district".
 * DO NOT MODIFY THIS FILE! It is automatically generated by giix.
 * If any changes are necessary, you must set or override the required
 * property or method in class "District".
 *
 * Columns in table "appform_district" available as properties of the model,
 * followed by relations of table "appform_district" available as properties of the model.
 *
 * @property integer $id
 * @property integer $province_id
 * @property string $district_name
 *
 * @property Province $province
 * @property ElectricProjectSite[] $electricProjectSites
 * @property GeneralProjectSite[] $generalProjectSites
 * @property MiningProjectSite[] $miningProjectSites
 * @property RepOffice[] $repOffices
 * @property Village[] $villages
 */
abstract class BaseDistrict extends GxActiveRecord {

	public static function model($className=__CLASS__) {
		return parent::model($className);
	}

	public function tableName() {
		return 'appform_district';
	}

	public static function label($n = 1) {
		return Yii::t('app', 'District|Districts', $n);
	}

	public static function representingColumn() {
		return 'district_name';
	}

	public function rules() {
		return array(
			array('province_id, district_name', 'required'),
			array('province_id', 'numerical', 'integerOnly'=>true),
			array('district_name', 'length', 'max'=>255),
			array('id, province_id, district_name', 'safe', 'on'=>'search'),
		);
	}

	public function relations() {
		return array(
			'province' => array(self::BELONGS_TO, 'Province', 'province_id'),
			'electricProjectSites' => array(self::HAS_MANY, 'ElectricProjectSite', 'district_id'),
			'generalProjectSites' => array(self::HAS_MANY, 'GeneralProjectSite', 'district_id'),
			'miningProjectSites' => array(self::HAS_MANY, 'MiningProjectSite', 'district_id'),
			'repOffices' => array(self::HAS_MANY, 'RepOffice', 'district_id'),
			'villages' => array(self::HAS_MANY, 'Village', 'district_id'),
		);
	}

	public function pivotModels() {
		return array(
		);
	}

	public function attributeLabels() {
		return array(
			'id' => Yii::t('app', 'ID'),
			'province_id' => null,
			'district_name' => Yii::t('app', 'District Name'),
			'province' => null,
			'electricProjectSites' => null,
			'generalProjectSites' => null,
			'miningProjectSites' => null,
			'repOffices' => null,
			'villages' => null,
		);
	}

	public function search() {
		$criteria = new CDbCriteria;

		$criteria->compare('id', $this->id);
		$criteria->compare('province_id', $this->province_id);
		$criteria->compare('district_name', $this->district_name, true);

		return new CActiveDataProvider($this, array(
			'criteria' => $criteria,
		));
	}
}