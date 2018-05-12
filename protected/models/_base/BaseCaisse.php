<?php

/**
 * This is the model base class for the table "caisse".
 * DO NOT MODIFY THIS FILE! It is automatically generated by giix.
 * If any changes are necessary, you must set or override the required
 * property or method in class "Caisse".
 *
 * Columns in table "caisse" available as properties of the model,
 * followed by relations of table "caisse" available as properties of the model.
 *
 * @property integer $id
 * @property integer $inc_document_id
 * @property integer $amount_to_budget
 * @property integer $amount_to_department
 * @property string $create_date
 * @property string $payment_date
 * @property integer $payment_status
 * @property integer $user_id
 *
 * @property IncDocument $incDocument
 * @property User $user
 */
abstract class BaseCaisse extends GxActiveRecord {

	public static function model($className=__CLASS__) {
		return parent::model($className);
	}

	public function tableName() {
		return 'caisse';
	}

	public static function label($n = 1) {
		return Yii::t('app', 'Caisse|Caisses', $n);
	}

	public static function representingColumn() {
		return 'create_date';
	}

	public function rules() {
		return array(
			array('inc_document_id, create_date, user_id', 'required'),
			array('inc_document_id, amount_to_budget, amount_to_department, payment_status, user_id', 'numerical', 'integerOnly'=>true),
			array('payment_date', 'safe'),
			array('amount_to_budget, amount_to_department, payment_date, payment_status', 'default', 'setOnEmpty' => true, 'value' => null),
			array('id, inc_document_id, amount_to_budget, amount_to_department, create_date, payment_date, payment_status, user_id', 'safe', 'on'=>'search'),
		);
	}

	public function relations() {
		return array(
			'incDocument' => array(self::BELONGS_TO, 'IncDocument', 'inc_document_id'),
			'user' => array(self::BELONGS_TO, 'User', 'user_id'),
		);
	}

	public function pivotModels() {
		return array(
		);
	}

	public function attributeLabels() {
		return array(
			'id' => Yii::t('app', 'ID'),
			'inc_document_id' => null,
			'amount_to_budget' => Yii::t('app', 'Amount To Budget'),
			'amount_to_department' => Yii::t('app', 'Amount To Department'),
			'create_date' => Yii::t('app', 'Create Date'),
			'payment_date' => Yii::t('app', 'Payment Date'),
			'payment_status' => Yii::t('app', 'Payment Status'),
			'user_id' => null,
			'incDocument' => null,
			'user' => null,
		);
	}

	public function search() {
		$criteria = new CDbCriteria;

		$criteria->compare('id', $this->id);
		$criteria->compare('inc_document_id', $this->inc_document_id);
		$criteria->compare('amount_to_budget', $this->amount_to_budget);
		$criteria->compare('amount_to_department', $this->amount_to_department);
		$criteria->compare('create_date', $this->create_date, true);
		$criteria->compare('payment_date', $this->payment_date, true);
		$criteria->compare('payment_status', $this->payment_status);
		$criteria->compare('user_id', $this->user_id);

		return new CActiveDataProvider($this, array(
			'criteria' => $criteria,
		));
	}
}