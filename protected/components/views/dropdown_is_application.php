<?php



echo CHtml::activeLabel($model, 'is_application');
/*
echo CHtml::activeDropDownList($model,'is_application',
			Utils::enumItem(new IncDocument, 'is_application'),
			array(
                  'prompt' => Yii::t('app','--Please Select --'),
				  'ajax'  => array(
                  	'type'  => 'POST',
                  	'url' => Yii::app()->createUrl('site/getDropdownApplication'),
                  	//'update' => '#application_list', 
                  	'update' => '#AdvancedSearch_document_type_id',
                  	'data' => array('is_application'=>'js:this.value','model'=>$model),
                  ),
            )
);
?>
*/

echo CHtml::activeDropDownList($model,'is_application',
			Utils::enumItem(new IncDocument, 'is_application'),
			array(
                  'prompt' => Yii::t('app','--Please Select --'),
				  'ajax'  => array(
                  	'type'  => 'POST',
					'dataType'=>'json',
                  	'url' => Yii::app()->createUrl('site/getDropdownApplication'), 
                  	//'update' => '#AdvancedSearch_document_type_id',
					'success'=>'function(data){
						$("#companyname").html(data.companyname);
						$("#AdvancedSearch_document_type_id").html(data.applicationList);
					}',
                  	'data' => array('is_application'=>'js:this.value','model'=>$model),
                  ),
            )
);