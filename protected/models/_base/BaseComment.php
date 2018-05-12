<?php

/**
 * This is the model base class for the table "comment".
 * DO NOT MODIFY THIS FILE! It is automatically generated by giix.
 * If any changes are necessary, you must set or override the required
 * property or method in class "Comment".
 *
 * Columns in table "comment" available as properties of the model,
 * followed by relations of table "comment" available as properties of the model.
 *
 * @property integer $id
 * @property integer $document_id
 * @property integer $user_id
 * @property string $comment_detail
 * @property string $comment_time
 *
 * @property Document $document
 * @property User $user
 * @property CommentToUser[] $commentToUsers
 */
abstract class BaseComment extends GxActiveRecord {

	public static function model($className=__CLASS__) {
		return parent::model($className);
	}

	public function tableName() {
		return 'comment';
	}

	public static function label($n = 1) {
		return Yii::t('app', 'Comment|Comments', $n);
	}

	public static function representingColumn() {
		return 'comment_detail';
	}

	public function rules() {
		return array(
			array('document_id, user_id,comment_time', 'required'),
			array('document_id, user_id', 'numerical', 'integerOnly'=>true),
			array('comment_detail', 'length', 'max'=>255),
			array('id, document_id, user_id, comment_detail, comment_time', 'safe', 'on'=>'search'),
		);
	}

	public function relations() {
		return array(
			'document' => array(self::BELONGS_TO, 'Document', 'document_id'),
			'user' => array(self::BELONGS_TO, 'User', 'user_id'),
			'commentToUsers' => array(self::HAS_MANY, 'CommentToUser', 'comment_id'),
		);
	}

	public function pivotModels() {
		return array(
		);
	}

	public function attributeLabels() {
		return array(
			'id' => Yii::t('app', 'ID'),
			'document_id' => null,
			'user_id' => null,
			'comment_detail' => Yii::t('app', 'Comment Detail'),
			'comment_time' => Yii::t('app', 'Comment Time'),
			'document' => null,
			'user' => null,
			'commentToUsers' => null,
		);
	}

	public function search() {
		$criteria = new CDbCriteria;

		$criteria->compare('id', $this->id);
		$criteria->compare('document_id', $this->document_id);
		$criteria->compare('user_id', $this->user_id);
		$criteria->compare('comment_detail', $this->comment_detail, true);
		$criteria->compare('comment_time', $this->comment_time, true);

		return new CActiveDataProvider($this, array(
			'criteria' => $criteria,
		));
	}
}