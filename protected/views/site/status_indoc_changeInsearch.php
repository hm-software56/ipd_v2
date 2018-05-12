<?php
if(Yii::app()->user->checkAccess("DG"))
{
	echo $statusIndoc->documentStatus->status_description;
}else{
	$this->Widget('bootstrap.widgets.TbEditableField', array(
						   'type'      => 'select',
						   'model'     => $statusIndoc,
						   'attribute' => 'document_status_id',
						   'url'=>$this->createUrl('/inDocument/statusChange'),
						   'source'  =>CHtml::listData(DocumentStatus::model()->findAll('status_type="INC"'), 'id', 'status_description'),		   
	));	
}
