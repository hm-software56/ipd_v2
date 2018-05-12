<?php 
$cs=Yii::app()->clientScript;  
$cs->registerScriptFile(Yii::app()->baseUrl . '/js/jquery.ba-bbq.js', CClientScript::POS_HEAD);  
?>
Selected Document : <span id="itemselect"></span>

<?php 
//$this->widget('bootstrap.widgets.TbGridView', array(
$this->widget('CgridviewWithVariables', array(
	'id'=>'listdocuments-grid',
    'type'=>'striped bordered condensed',
   // 'dataProvider'=>$documents->search(array('pageSize'=>5)), // worked
   'dataProvider'=>$providers,
   // 'dataProvider'=>$documents->outdoc_to_me()->search(),
	'filter'=>$documents,
	'extraparam'=>$docID,
    //'template'=>"{items}",
    'columns'=>array(
        array('name' => 'id','value'=>'$data->id'),
        array('name'=>'document_no', 
        	'value'=>'($data->in_or_out=="INC")?$data->incDocument->inc_document_no:$data->outDocument->out_document_no'
        ),
		'document_title',
		'document_date',
        array(
        	'name'=>'document_type',
        	'value'=>'$data->documentType->description'
        ),
		array(
	        'header' => 'Related Document',
	        'type' => 'raw',
	        'value' => 'CHtml::radioButton("name","",
	        	array(
	            "labelOptions"=>array("style"=>"display:inline"), // add this code
	            "id"=>"name$data->id",
	            "value"=>$data->id,
	          	//"value"=>$this->grid->extraparam,
	            "style"=>($data->id==$this->grid->extraparam)?"display:none":"",
	            "separator"=>"",
		        "onClick"=>"{
						$.ajax({
                        	data:\"id=$data->id\",
                            url:\"'.CController::createUrl("selectDoc").'\",
                            type:\"GET\",
                            success:function(data){
                            			$(\"#itemselect\").html(data);
                            		}
                            }
						);  return true;
						}"
	        	))',
		),
    ),
    )
); 
	
?>