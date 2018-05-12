<?php

/**
 * This is the model base class for the table "items".
 * DO NOT MODIFY THIS FILE! It is automatically generated by giix.
 * If any changes are necessary, you must set or override the required
 * property or method in class "Items".
 *
 * Columns in table "items" available as properties of the model,
 * and there are no model relations.
 *
 * @property string $name
 * @property integer $type
 * @property string $description
 * @property string $bizrule
 * @property string $data
 *
 */
abstract class BaseItems extends GxActiveRecord {

	public static function model($className=__CLASS__) {
		return parent::model($className);
	}

	public function tableName() {
		return 'items';
	}

	public static function label($n = 1) {
		return Yii::t('app', 'Items|Items', $n);
	}

	public static function representingColumn() {
		return 'name';
	}

	public function rules() {
		return array(
			array('name, type', 'required'),
			array('type', 'numerical', 'integerOnly'=>true),
			array('name', 'length', 'max'=>64),
			array('description, bizrule, data', 'safe'),
			array('description, bizrule, data', 'default', 'setOnEmpty' => true, 'value' => null),
			array('name, type, description, bizrule, data', 'safe', 'on'=>'search'),
		);
	}

	public function relations() {
		return array(
		);
	}

	public function pivotModels() {
		return array(
		);
	}

	public function attributeLabels() {
		return array(
			'name' => Yii::t('app', 'Name'),
			'type' => Yii::t('app', 'Type'),
			'description' => Yii::t('app', 'Description'),
			'bizrule' => Yii::t('app', 'Bizrule'),
			'data' => Yii::t('app', 'Data'),
		);
	}

	public function search() {
		$criteria = new CDbCriteria;

		$criteria->compare('name', $this->name, true);
		$criteria->compare('type', $this->type);
		$criteria->compare('description', $this->description, true);
		$criteria->compare('bizrule', $this->bizrule, true);
		$criteria->compare('data', $this->data, true);

		return new CActiveDataProvider($this, array(
			'criteria' => $criteria,
		));
	}
}