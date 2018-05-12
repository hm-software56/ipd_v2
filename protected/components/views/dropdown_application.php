<?php
echo CHtml::activeLabel($model, 'document_type_id');
if($model->is_application=="Yes")
{
	echo CHtml::activeDropDownList($model,'document_type_id',
				CHtml::listData(DocumentType::getDropDownList(2,1), 'id', 'description'),
				array(
	                  'prompt' => Yii::t('app','--Please Select --'),
					  /*'ajax'  => array(
	                  	'type'  => 'POST',
	                  	'url' => Yii::app()->createUrl('site/getDropdownApplication'),
	                  	'update' => '#application_list',   //selector to update value 
	                  	'data' => array('is_application'=>'js:this.value','model'=>$model),
	                  ),*/
	            )
	);
}else{
	echo CHtml::activeDropDownList($model,'document_type_id',
				CHtml::listData(DocumentType::model()->findAll('type_level_id=2'), 'id', 'description'),
				array(
	                  'prompt' => Yii::t('app','--Please Select --'),
					  /*'ajax'  => array(
	                  	'type'  => 'POST',
	                  	'url' => Yii::app()->createUrl('site/getDropdownApplication'),
	                  	'update' => '#application_list',   //selector to update value 
	                  	'data' => array('is_application'=>'js:this.value','model'=>$model),
	                  ),*/
	            )
	);
}
?>