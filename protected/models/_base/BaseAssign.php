<?php

/**
 * This is the model base class for the table "assign".
 * DO NOT MODIFY THIS FILE! It is automatically generated by giix.
 * If any changes are necessary, you must set or override the required
 * property or method in class "Assign".
 *
 * Columns in table "assign" available as properties of the model,
 * followed by relations of table "assign" available as properties of the model.
 *
 * @property integer $id
 * @property integer $inc_document_document_id
 * @property integer $user_id
 *
 * @property IncDocument $incDocumentDocument
 * @property User $user
 */
abstract class BaseAssign extends GxActiveRecord {

	public static function model($className=__CLASS__) {
		return parent::model($className);
	}

	public function tableName() {
		return 'assign';
	}

	public static function label($n = 1) {
		return Yii::t('app', 'Assign|Assigns', $n);
	}

	public static function representingColumn() {
		return 'id';
	}

	public function rules() {
		return array(
			array('inc_document_document_id, user_id', 'required'),
			array('inc_document_document_id, user_id', 'numerical', 'integerOnly'=>true),
			array('id, inc_document_document_id, user_id', 'safe', 'on'=>'search'),
		);
	}

	public function relations() {
		return array(
			'incDocumentDocument' => array(self::BELONGS_TO, 'IncDocument', 'inc_document_document_id'),
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
			'inc_document_document_id' => null,
			'user_id' => null,
			'incDocumentDocument' => null,
			'user' => null,
		);
	}

	public function search() {
		$criteria = new CDbCriteria;

		$criteria->compare('id', $this->id);
		$criteria->compare('inc_document_document_id', $this->inc_document_document_id);
		$criteria->compare('user_id', $this->user_id);

		return new CActiveDataProvider($this, array(
			'criteria' => $criteria,
		));
	}
}