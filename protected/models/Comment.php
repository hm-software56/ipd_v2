<?php

Yii::import('application.models._base.BaseComment');

class Comment extends BaseComment
{
	public static function model($className=__CLASS__) {
		return parent::model($className);
	}
	
	public function scopes()
	{
		$userArrayID = NULL;
		$userID = Yii::app()->user->id;
		
		$organizationID = UserProfile::model()->findByPk($userID)->organization_id;
		$assignments = Assignments::model()->findAllByAttributes(array("itemname"=>"DG"));
		if($assignments)
		foreach ($assignments as $a)
		{
			$userArrayID[]= $a->userid;
		}
		return array(
			'public'=>array(
					'condition'=>"id not in (select distinct(comment_id) from comment_to_user)"
			),
			'to_me'=>array(
				'with'=>array(
					'commentToUsers'=>array(
						'condition'=>"commentToUsers.user_id=$userID or t.user_id=$userID",
						'order'=>'t.id DESC',
					)
				),
			)
		);
	}
	
	/*
	 * list comment delete 
	 */
	public function Listcomment($document_id)
	{
		$criteria=new CDbCriteria();
		$criteria->condition='document_id='.$document_id.'';
		$criteria->order='id DESC';
		
		$comments=Comment::model()->findAll($criteria);
		foreach ($comments as $cle=>$comment)
		{
			echo $comment->comment_detail.'<br/><span style="color:#999999; font-size:12px">Comment by: '.$comment->user->userProfile->first_name.'&nbsp;&nbsp;&nbsp;'.$comment->comment_time.'</span><hr/>';
		}
	}
	
	/**
	 * (non-PHPdoc)
	 * @see CActiveRecord::afterFind()
	 */
	public function afterFind()
	{
	    parent::afterFind();
	    if ($this->comment_time != '' && $this->comment_time != '0000-00-00 00:00:00')
	    {
	        $this->comment_time = date('d-m-Y H:i:s',strtotime($this->comment_time));
	    }
	}
}