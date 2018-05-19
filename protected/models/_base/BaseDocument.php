<?php

/**
 * This is the model base class for the table "document".
 * DO NOT MODIFY THIS FILE! It is automatically generated by giix.
 * If any changes are necessary, you must set or override the required
 * property or method in class "Document".
 *
 * Columns in table "document" available as properties of the model,
 * followed by relations of table "document" available as properties of the model.
 *
 * @property integer $id
 * @property string $in_or_out
 * @property string $document_date
 * @property string $document_title
 * @property integer $related_document_id
 * @property integer $document_type_id
 * @property string $created
 * @property integer $created_by
 * @property string $last_modified
 * @property integer $last_modified_id
 * @property string $detail
 *
 * @property AttachFile[] $attachFiles
 * @property Comment[] $comments
 * @property DocumentType $documentType
 * @property User $createdBy
 * @property User $lastModified
 * @property IncDocument $incDocument
 * @property OutDocument $outDocument
 */
abstract class BaseDocument extends GxActiveRecord {

	public static function model($className=__CLASS__) {
		return parent::model($className);
	}

	public function tableName() {
		return 'document';
	}

	public static function label($n = 1) {
		return Yii::t('app', 'Document|Documents', $n);
	}

	public static function representingColumn() {
		return 'in_or_out';
	}

	public function rules() {
		return array(
			array('in_or_out, document_date, document_title, document_type_id, created, created_by, last_modified, last_modified_id', 'required'),
			array('related_document_id, document_type_id, created_by, last_modified_id', 'numerical', 'integerOnly'=>true),
			array('in_or_out', 'length', 'max'=>3),
			array('detail', 'safe'),
			array('related_document_id, detail', 'default', 'setOnEmpty' => true, 'value' => null),
			array('id, in_or_out, document_date, document_title, related_document_id, document_type_id, created, created_by, last_modified, last_modified_id, detail', 'safe', 'on'=>'search'),
		);
	}

	public function relations() {
		return array(
			'attachFiles' => array(self::HAS_MANY, 'AttachFile', 'document_id'),
			'comments' => array(self::HAS_MANY, 'Comment', 'document_id'),
			'documentType' => array(self::BELONGS_TO, 'DocumentType', 'document_type_id'),
			'createdBy' => array(self::BELONGS_TO, 'User', 'created_by'),
			'lastModified' => array(self::BELONGS_TO, 'User', 'last_modified_id'),
			'incDocument' => array(self::HAS_ONE, 'IncDocument', 'document_id'),
			'outDocument' => array(self::HAS_ONE, 'OutDocument', 'document_id'),
		);
	}

	public function pivotModels() {
		return array(
		);
	}

	public function attributeLabels() {
		return array(
			'id' => Yii::t('app', 'ID'),
			'in_or_out' => Yii::t('app', 'In Or Out'),
			'document_date' => Yii::t('app', 'Document Date'),
			'document_title' => Yii::t('app', 'Document Title'),
			'related_document_id' => Yii::t('app', 'Related Document'),
			'document_type_id' => null,
			'created' => Yii::t('app', 'Created'),
			'created_by' => null,
			'last_modified' => Yii::t('app', 'Last Modified'),
			'last_modified_id' => null,
			'detail' => Yii::t('app', 'Detail'),
			'attachFiles' => null,
			'comments' => null,
			'documentType' => null,
			'createdBy' => null,
			'lastModified' => null,
			'incDocument' => null,
			'outDocument' => null,
		);
	}

	public function search() {
		$criteria = new CDbCriteria;

		$criteria->compare('id', $this->id);
		$criteria->compare('in_or_out', $this->in_or_out, true);
		$criteria->compare('document_date', $this->document_date, true);
		$criteria->compare('document_title', $this->document_title, true);
		$criteria->compare('related_document_id', $this->related_document_id);
		$criteria->compare('document_type_id', $this->document_type_id);
		$criteria->compare('created', $this->created, true);
		$criteria->compare('created_by', $this->created_by);
		$criteria->compare('last_modified', $this->last_modified, true);
		$criteria->compare('last_modified_id', $this->last_modified_id);
		$criteria->compare('detail', $this->detail, true);

		return new CActiveDataProvider($this, array(
			'criteria' => $criteria,
		));
	}
}