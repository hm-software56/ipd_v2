<?php

/**
 * This is the model base class for the table "fee".
 * DO NOT MODIFY THIS FILE! It is automatically generated by giix.
 * If any changes are necessary, you must set or override the required
 * property or method in class "Fee".
 *
 * Columns in table "fee" available as properties of the model,
 * followed by relations of table "fee" available as properties of the model.
 *
 * @property integer $id
 * @property string $fee_description
 * @property integer $amount_to_budget
 * @property integer $amount_to_department
 *
 * @property IncDocument[] $incDocuments
 */
abstract class BaseFee extends GxActiveRecord {

	public static function model($className=__CLASS__) {
		return parent::model($className);
	}

	public function tableName() {
		return 'fee';
	}

	public static function label($n = 1) {
		return Yii::t('app', 'Fee|Fees', $n);
	}

	public static function representingColumn() {
		return 'fee_description';
	}

	public function rules() {
		return array(
			array('fee_type', 'required'),
			array('amount_to_budget, amount_to_department', 'numerical', 'integerOnly'=>true),
			array('fee_description,fee_type', 'length', 'max'=>45),
			array('fee_description, amount_to_budget, amount_to_department', 'default', 'setOnEmpty' => true, 'value' => null),
			array('id, fee_description, amount_to_budget, amount_to_department', 'safe', 'on'=>'search'),
		);
	}

	public function relations() {
		return array(
			'incDocuments' => array(self::HAS_MANY, 'IncDocument', 'fee_id'),
		);
	}

	public function pivotModels() {
		return array(
		);
	}

	public function attributeLabels() {
		return array(
			'id' => Yii::t('app', 'ID'),
			'fee_description' => Yii::t('app', 'Fee Description'),
			'fee_type' => Yii::t('app', 'Fee type'),
			'amount_to_budget' => Yii::t('app', 'Amount To Budget'),
			'amount_to_department' => Yii::t('app', 'Amount To Department'),
			'incDocuments' => null,
		);
	}

	public function search() {
		$criteria = new CDbCriteria;

		$criteria->compare('id', $this->id);
		$criteria->compare('fee_description', $this->fee_description, true);
		$criteria->compare('fee_type', $this->fee_type, true);
		$criteria->compare('amount_to_budget', $this->amount_to_budget);
		$criteria->compare('amount_to_department', $this->amount_to_department);

		return new CActiveDataProvider($this, array(
			'criteria' => $criteria,
		));
	}
}