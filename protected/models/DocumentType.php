<?php

Yii::import('application.models._base.BaseDocumentType');

class DocumentType extends BaseDocumentType
{
	public static function model($className=__CLASS__) {
		return parent::model($className);
	}
	
	public static function getDropDownList($parent_id=null,$level=1)
	{
		    $text_level=str_repeat("- - ",$level-1);
		    $result = array();
		    
		    $condition=($parent_id==null) ? 'parent_id IS NULL' : 'parent_id='.(int)$parent_id;
		    $roots=DocumentType::model()->findAll($condition);
		    foreach ($roots as $root)
		    {
		        $result[]=array(
					'id'=>$root->id,
	                'description'=>$text_level . CHtml::encode($root->description)
		        );
		        $result=array_merge($result,DocumentType::getDropDownList($root->id,++$level));
		        $level--;
		    }
		    return $result;
	}
	
	/**
	 * 
	 * Get droptdown which is not application rooot
	 * @param unknown_type $parent_id
	 * @param unknown_type $level
	 * @param $application_root_id
	 */
	public static function getDropDownListNotApplication($parent_id=null,$level=1,$application_root_id)
	{
		    $text_level=str_repeat("- - ",$level-1);
		    $result = array();
		    
		    $condition=($parent_id==null) ? 'parent_id IS NULL and id<>'.Yii::app()->params->Isapplication_id : 'parent_id='.(int)$parent_id;
		    $roots=DocumentType::model()->findAll($condition);
		    foreach ($roots as $root)
		    {
		        $result[]=array(
					'id'=>$root->id,
	                'description'=>$text_level . CHtml::encode($root->description)
		        );
		        $result=array_merge($result,DocumentType::getDropDownList($root->id,++$level));
		        $level--;
		    }
		    return $result;
	}
	
	/**
	 * 
	 * Get droptdown which is not application rooot
	 * @param unknown_type $parent_id
	 * @param unknown_type $level
	 * @param $application_root_id
	 */
	public static function getDropDownListApplication($parent_id=null,$level=1,$application_root_id)
	{
		    $text_level=str_repeat("- - ",$level-1);
		    $result = array();
		    
		    $condition=($parent_id==null) ? 'parent_id IS NULL and id='.Yii::app()->params->Isapplication_id : 'parent_id='.(int)$parent_id;
		    $roots=DocumentType::model()->findAll($condition);
		    foreach ($roots as $root)
		    {
		        $result[]=array(
					'id'=>$root->id,
	                'description'=>$text_level . CHtml::encode($root->description)
		        );
		        $result=array_merge($result,DocumentType::getDropDownList($root->id,++$level));
		        $level--;
		    }
		    return $result;
	}
}