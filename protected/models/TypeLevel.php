<?php

Yii::import('application.models._base.BaseTypeLevel');

class TypeLevel extends BaseTypeLevel
{
	public static function model($className=__CLASS__) {
		return parent::model($className);
	}

	/**
	 * Function to retrieve the list
	 * of the node and all children of the
	 * node
	 * @param integer $id
	 * @param integer $level
	 * @return array $result
	 */
	public static function getChild($id, $level=1)
	{
	    $text_level=str_repeat("- - ",$level-1);
	    $result = array();
	    $node=TypeLevel::model()->findByPk($id);
	    if ($node != null)
	        $result[]=array(
	            'id'=>$node->id,
	            'description'=>(($level != 1) ? $text_level : '') . CHtml::encode($node->description) 
	        );
	        
	    $condition='parent_id='. (int)$id;
	    $childs = TypeLevel::model()->findAll($condition);
	    foreach ($childs as $child)
	    {
	        //Recursive
	        $result = array_merge($result,TypeLevel::getChild($child->id, ++$level));
	    }
	    return $result;
	}
}