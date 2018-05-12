<?php

Yii::import('application.models._base.BaseOrganization');

class Organization extends BaseOrganization
{   
	public static function model($className=__CLASS__) {
		return parent::model($className);
	}
		
	/**
	 * This function is to query the root nodes
	 * @param integer $region_id
	 * @return array
	 */
	public function getRoots($region_id='')
	{
	    $condition=($region_id != '') 
	        ? 'region_id='.$region_id. ' AND parent_id IS NULL' 
	        : 'parent_id IS NULL';
	    return Organization::model()->findAll($condition);
	}
	
	/**
	 * Get Children Organization 
	 * @param integer $id
	 * @return array 
	 */
	public function treeChild($id)
	{
	    $result=array();
	    $current=Organization::model()->findByPk((int)$id);
	    if ($current != NULL)
	    {
	        $children=Organization::model()->findAllByAttributes(array('parent_id'=>$id));
	        if (count($children) > 0) {
	            foreach ($children as $child)
	            {
	                $aChild=array(
	                    'id'=>$child->id,
	                    'text'=>$child->organization_name,
	                    'children'=>$this->treeChild($child->id),
	                );
	                $result[]=$aChild;
	            }
	        }
	    }
	    return $result;
	}
	
	/**
	 * Get treedata of organization
	 */
	public function treeData($region_id='')
	{
	    $result=array();
	    
	    //get roots
	    $roots=$this->getRoots($region_id);
	    	    
	    //get children of each root
	    foreach ($roots as $root)
	    {
	        $aRoot=array(
	            'id'=>$root->id,
	            'text'=>$root->organization_name,
	            'children'=>$this->treeChild($root->id),
	        );
	        $result[]=$aRoot;
	    }
	    
	    return $result;
	}

	/**
	 * This function is used to get dropdown list of organization.
	 * Example: 
	 * <?php echo $form->dropDownListRow($model,'from_organization_id',
	 * CHtml::listData(Organization::getList(), 'id', 'organization_name')); ?>
	 * @param integer $id
	 * @param integer $level
	 */
	public static function getList($id=0,$level=0)
	{
		$list=array();
	    $text_level=str_repeat("- - ",$level);
	    $condition=($id == 0) 
	        ? 'parent_id IS NULL' 
	        : 'parent_id='.(int)$id;
	    $models=Organization::model()->findAll($condition);
	    foreach ($models as $model)
	    {	
	        $level = ($model->parent_id == NULL) ? 0 : $level;
	        $list=array_merge($list,array(array('id'=>$model->id,'organization_name'=>$text_level . $model->organization_name)));
	        $childList=Organization::getList($model->id, ++$level);
	        if (count($childList)>0)
	            $list=array_merge($list,$childList);
	    }
	    return $list;
	}
	
	/**
	 * Function to retrieve dropdown list
	 * of the node and all children of the
	 * node
	 * @param integer $id
	 * @param integer $level
	 * @return html option list
	 */
	public static function getChild($id, $level=1)
	{
	    $text_level=str_repeat("- - ",$level);
	    $result = '';
	    $condition='parent_id='. (int)$id;
	    $childs = Organization::model()->findAll($condition);
	    foreach ($childs as $child)
	    { 
	    	//Current node
	        $result .= CHtml::tag('option',
	            array('value'=>$child->id),
	            $text_level . CHtml::encode($child->organization_name),
	            true
	        );
	        //Recursive
	        $result .= Organization::getChild($child->id, ++$level);
	    }
	    return $result;
	}
	
	/**
	 * Get Condition String to get Incoming Documents
	 * @param integer $id
	 * @return string $condition
	 */
	public static function getChildCondition($id)
	{
	    $condition="";
	    $models=Organization::model()->findAll('parent_id=:id',array(':id'=>(int)$id));	    
	    foreach ($models as $model)
	    {
	        $condition .= ($condition != "") ? ",'" : "'";
	        $condition .= $model->id . "'";
	        $child = Organization::getChildCondition($model->id);
	        if ($child != "")
	            $condition .= ",".$child;
	    }
	    return ($condition != "") ? $condition . ",'" . (int)$id . "'" : "";
	}
	
	public static function getlistfromtoreciever($id=0,$level=0)
	{
		$UserProfile=UserProfile::model()->findByPK(Yii::app()->user->id);
	    $list=array();
	    $text_level=str_repeat("- - ",$level);
	    $condition=($id == 0) 
	        ? 'parent_id IS NULL' 
	        : 'parent_id='.(int)$id;
	    $models=Organization::model()->findAll($condition);
	    foreach ($models as $model)
	    {
	        	$level = ($model->parent_id == NULL) ? 0 : $level;
	        	$fromto=FromTo::model()->findAll('from_organization_id='.$UserProfile->organization_id.' and to_organization_id='.$model->id.'');
		    	if($fromto && $UserProfile->organization_id!=Yii::app()->params->Organization_id)
		    	{
	        		$list=array_merge($list,array(array('id'=>$model->id,'organization_name'=>$text_level . $model->organization_name)));
		    	}
		    	elseif ($UserProfile->organization_id==Yii::app()->params->Organization_id)
		    	{
		    		$list=array_merge($list,array(array('id'=>$model->id,'organization_name'=>$text_level . $model->organization_name)));
		    	}
	        	$childList=Organization::getlistfromtoreciever($model->id, ++$level);
	        	if (count($childList)>0){
	            	$list=array_merge($list,$childList);
	        	}
	    	
	    }
	    return $list;
	    
	}
}