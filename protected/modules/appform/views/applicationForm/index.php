<?php Yii::app()->bootstrap->registerCoreCss(); ?>
<?php Yii::app()->bootstrap->registerCoreScripts(); ?>
<?php Yii::app()->bootstrap->registerYiiCss(); ?>
<?php
$this->breadcrumbs = array(
	'Application Forms',
	Yii::t('app', 'Index'),
);
?>

<?php 
$this->beginWidget('bootstrap.widgets.TbModal', array('htmlOptions'=>array('id'=>'myModal1','style'=>'width:800px'))); ?>
 
<div class="modal-header">
    <a class="close" data-dismiss="modal">&times;</a>
    <h4><b><?php echo Yii::t('app','')?></b></h4>
</div>
 
<div class="modal-body1">
    <p>One fine body...</p>
</div>
<?php $this->endWidget(); ?>

<fieldset>
	<legend>Application Forms</legend>
	
</fieldset>

<?php $this->widget('bootstrap.widgets.TbGridView',array(
	'id'=>'application-form-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
    'summaryText' => Yii::t('app', 'Displaying {start}-{end} of {count} result(s).'),
    'emptyText' => Yii::t('app', 'No results found.'),
    'columns'=>array(
        array(
            'name'=>'application_type_id',
            'value'=>'isset($data->applicationType)?$data->applicationType:null',
            'filter'=>CHtml::listData(ApplicationType::model()->findAll(), 'id', 'description'),
            'header'=>Yii::t('app','App. Type'),
        ),
      /*  array(
            'name'=>'document_no',
            //'value'=>'isset($data->document)?$data->document:null',
            'header'=>Yii::t('app','Document#'),
        ),*/
        
        array(
        		'header'=>Yii::t('app','Document#'),
        		'name'=>'document_no',
		        'type'=>'raw',
        		'value'=>'CHtml::ajaxLink("$data->document_no", array("applicationForm/showrelate/","docid"=>$data->indocument->document_id),  
							array(
									"success"=>"js:function(data){
									$(\".modal-body1\").html(data);
									$(\"#myModal1\").modal(\"show\");
									//return false;
								}"
								))',   
		),
		
        array(
            'name'=>'document_title',
            'header'=>Yii::t('app','Document Title'),
            'filter'=>false,
        ),
        array(
            'name'=>'document_date',
            'header'=>Yii::t('app','Date'),
            'filter'=>false,
        ),
        array(
            'name'=>'investor_region_id',
            'value'=>'isset($data->investorRegion)?$data->investorRegion:null',
            'filter'=>CHtml::listData(InvestorRegion::model()->findAll(), 'id', 'region_name'),
            'header'=>Yii::t('app','Investor Region'),
        ),
        array(
            'class'=>'bootstrap.widgets.TbButtonColumn',
            'template'=>'{view}{update}',
            'updateButtonUrl'=>'Yii::app()->controller->createUrl("update",array("id"=>$data->id))',
        	'visible'=>!Yii::app()->user->checkAccess('DG')
        ),
    ),
)); ?>