<?php

Yii::import('application.models._base.BaseCommentToUser');

class CommentToUser extends BaseCommentToUser
{
	public static function model($className=__CLASS__) {
		return parent::model($className);
	}
	
	/**
	 * 
	 * Enter description here ...
	 * @param $id
	 */
	public static function getReadcomment($id){
		$str="";
		$readcoment=CommentToUser::model()->findAll('user_id='.Yii::app()->user->id.' AND status="Unread"');
		if(!is_object($readcoment))
		{
			$_SESSION['doc_id']=NULL;
			$str.="<ul style='list-style-type: none; margin-left:-20px' >";
			foreach($readcoment as $readcoments)
			{ 
				$comment=Comment::model()->findByAttributes(array('id'=>$readcoments->comment_id,'document_id'=>$id));
				
				if(!empty($comment))
				{
					if($_SESSION['doc_id']!=$comment->document_id){
						$_SESSION['doc_id']=$comment->document_id;
						$str.="<li><span class='span1'>".CHtml::image(Yii::app()->baseUrl.'/../images/alert.gif','',array("width"=>"25px" ,"height"=>"25px"))." ".Yii::t('app','comment')."</span></li>";
					}
				}
			}
			$str.="</ul>";
		}
		return $str;
	}
}