<?php 
$this->beginWidget('bootstrap.widgets.TbModal', array('htmlOptions'=>array('id'=>'myModal','style'=>'width:800px'))); ?>
 
<div class="modal-header">
    <a class="close" data-dismiss="modal">&times;</a>
    <h4><?php echo Yii::t('app','Organizations can recieve this organization send doc')?></h4>
</div>
 
<div class="modal-body">
    <p>One fine body...</p>
</div>
<?php $this->endWidget(); ?>

<?php
$this->layout='column1';
?>

<?php $this->widget('bootstrap.widgets.TbGridView',array(
	'id'=>'organization-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
'summaryText' => Yii::t('app','Displaying {start}-{end} of {count} result(s)'),
	'columns'=>array(
		'id',
		'parent_id',
		array(
			'class'=>'CLinkColumn',
			'label'=>Yii::t('app','Add'),
			'urlExpression'=>'Yii::app()->createUrl("organization/create", array("parent"=>$data->id))',
			'header'=>Yii::t('app','Add Sub Organization'),
		),
		'organization_name',
		'organization_code',
		array('name'=>'region_id', 'value'=>'$data->region->region_name'),
		/*array(
		        'filter'=>false,
		        'type'=>'raw',
				'value'=> 'CHtml::ajaxLink("'.Yii::t('app','Assign').'", array("organization/SenddocToreceiver/","id"=>$data->id),  
							array(
									"success"=>"js:function(data){
									$(\".modal-body\").html(data);
									$(\"#myModal\").modal(\"show\");
									//return false;
								}"
								))',      
		),*/
		array(
		'class'=>'bootstrap.widgets.TbButtonColumn',
		'template'=>'{Assign}',
		'buttons'=>array(
			'Assign'=>array(
				//'icon'=>'icon-dollar',
				'label'=>Yii::t('app','Assign'),
				'url'=>'Yii::app()->createUrl("organization/senddocToreceiver/", array("id"=>$data->id))',
				'options'=>array(
                            'ajax'=>array(
                                'type'=>'POST',
                                'url'=>"js:$(this).attr('href')",
                                'success'=>'function(data) { $("#myModal .modal-body").html(data); $("#myModal").modal(); }'
                            ),
                        ),
			),
		)
	),
		array(
			'class'=>'bootstrap.widgets.TbButtonColumn',
			'template'=>'{update}{delete}',
		),
	),
)); ?>
