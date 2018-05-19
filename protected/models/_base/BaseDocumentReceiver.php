<?php

/**
 * This is the model base class for the table "document_receiver".
 * DO NOT MODIFY THIS FILE! It is automatically generated by giix.
 * If any changes are necessary, you must set or override the required
 * property or method in class "DocumentReceiver".
 *
 * Columns in table "document_receiver" available as properties of the model,
 * followed by relations of table "document_receiver" available as properties of the model.
 *
 * @property integer $id
 * @property integer $out_document_id
 * @property integer $to_organization_id
 * @property integer $document_status_id
 * @property string $status_date
 * @property string $receiver_name
 *
 * @property Organization $toOrganization
 * @property OutDocument $outDocument
 * @property DocumentStatus $documentStatus
 */
abstract class BaseDocumentReceiver extends GxActiveRecord {

	public static function model($className=__CLASS__) {
		return parent::model($className);
	}

	public function tableName() {
		return 'document_receiver';
	}

	public static function label($n = 1) {
		return Yii::t('app', 'DocumentReceiver|DocumentReceivers', $n);
	}

	public static function representingColumn() {
		return 'status_date';
	}

	public function rules() {
		return array(
			array('out_document_id, to_organization_id, document_status_id, status_date', 'required'),
			array('out_document_id, to_organization_id, document_status_id', 'numerical', 'integerOnly'=>true),
			array('receiver_name', 'length', 'max'=>255),
			array('receiver_name', 'default', 'setOnEmpty' => true, 'value' => null),
			array('id, out_document_id, to_organization_id, document_status_id, status_date, receiver_name', 'safe', 'on'=>'search'),
		);
	}

	public function relations() {
		return array(
			'toOrganization' => array(self::BELONGS_TO, 'Organization', 'to_organization_id'),
			'outDocument' => array(self::BELONGS_TO, 'OutDocument', 'out_document_id'),
			'documentStatus' => array(self::BELONGS_TO, 'DocumentStatus', 'document_status_id'),
		);
	}

	public function pivotModels() {
		return array(
		);
	}

	public function attributeLabels() {
		return array(
			'id' => Yii::t('app', 'ID'),
			'out_document_id' => null,
			//'to_organization_id' => null,
			'to_organization_id' => Yii::t('app', 'Sent to organization'),
			'document_status_id' => null,
			'status_date' => Yii::t('app', 'Status Date'),
			'receiver_name' => Yii::t('app', 'Receiver Name'),
			'toOrganization' => null,
			'outDocument' => null,
			'documentStatus' => null,
		);
	}

	public function search() {
		$criteria = new CDbCriteria;

		$criteria->compare('id', $this->id);
		$criteria->compare('out_document_id', $this->out_document_id);
		$criteria->compare('to_organization_id', $this->to_organization_id);
		$criteria->compare('document_status_id', $this->document_status_id);
		$criteria->compare('status_date', $this->status_date, true);
		$criteria->compare('receiver_name', $this->receiver_name, true);

		return new CActiveDataProvider($this, array(
			'criteria' => $criteria,
		));
	}
}