<?php
// need for jquery of cgrid view next button...etc 
$cs=Yii::app()->clientScript;  
$cs->registerScriptFile(Yii::app()->baseUrl . '/js/jquery.ba-bbq.js', CClientScript::POS_HEAD);
?>
<?php echo Yii::t('app','Selected Document')?> : <span id="itemselect"></span>

<?php 
//$this->widget('bootstrap.widgets.TbGridView', array(
$this->widget('CgridviewWithVariables', array(
	'id'=>'listdocuments-grid',
    'type'=>'striped bordered condensed',
   // 'dataProvider'=>$documents->search(null,array('pageSize'=>5)), // worked
   'dataProvider'=>$providers,
    //'dataProvider'=>$documents->search($myCriteria,array('pageSize'=>5)),
	'filter'=>$documents,
	'extraparam'=>$docID,
    //'template'=>"{items}",
    'columns'=>array(
      //  array('name' => 'id','value'=>'$data->id'),
        array('name'=>'document_no', 
        	'header' => Yii::t('app','Document No'),
        	'value'=>'($data->in_or_out=="INC")?$data->incDocument->inc_document_no:$data->outDocument->out_document_no'
        ),
		'document_title',
		'document_date',
        array(
        	'name'=>'document_type_id',
        	'value'=>'$data->documentType->description',
        	'filter'=>CHtml::listData(DocumentType::model()->findAll(), 'id', 'description'),
        	//'header' => Yii::t('app','Document Type'),
        ),
		array(
	        'header' => Yii::t('app','Related Document'),
	        'type' => 'raw',
	        'value' => 'CHtml::radioButton("name",false,
	        	array(
	            "id"=>"name$data->id",
	            "value"=>$data->id,
	            "style"=>($data->id==$this->grid->extraparam || $data->related_document_id==$this->grid->extraparam)?"display:none":"",
	            "separator"=>"",
		        "onClick"=>"{
						$.ajax({
                        	data:\"id=$data->id\",
                            url:\"'.CController::createUrl("selectDoc").'\",
                            type:\"GET\",
                            success:function(data){
                            			$(\"#itemselect\").html(data);
                            }
                        });  return true;
				}"
	        	)
	        )',
		),
    ),
    )
); 
	
?>