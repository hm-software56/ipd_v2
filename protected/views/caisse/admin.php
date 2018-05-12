<?php
$this->layout="column1";
Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
$('.search-form').toggle();
return false;
});
$('.search-form form').submit(function(){
$.fn.yiiGridView.update('caisse-grid', {
data: $(this).serialize()
});
return false;
});
");
?>
<?php 
$this->beginWidget('bootstrap.widgets.TbModal', array('htmlOptions'=>array('id'=>'myModal','style'=>'width:800px'))); ?>
    <div class="modal-header">
        <a class="close" data-dismiss="modal">&times;</a>
        <h4><?php echo Yii::t('app','Comfirm Recieve Money')?></h4>
    </div>
 
    <div class="modal-body">
    	<p>Please wait loading...</p>
    </div>
 
<?php $this->endWidget(); ?>

<?php $this->widget('bootstrap.widgets.TbGridView',array(
'id'=>'caisse-grid',
'dataProvider'=>$model->search(),
'filter'=>$model,
'emptyText' => Yii::t('app','No results found.'),
'summaryText' => Yii::t('app','Displaying {start}-{end} of {count} result(s).'),
'columns'=>array(
		array(
			'name'=>'inc_document_no',
			'value'=>'$data->incDocument->inc_document_no'
		),
		'amount_to_budget',
		'amount_to_department',
		array(
		'name'=>'incDocument.fee.fee_type',
		'value'=>'$data->incDocument->fee->fee_type'
		),
		'create_date',
		'payment_date',
		array(
			'name'=>'payment_status',
			'value'=>'$data->payment_status==1?Yii::t(\'app\',\'Yes Payment\'):Yii::t(\'app\',\'No Payment\')',
		),
	array(
		'class'=>'bootstrap.widgets.TbButtonColumn',
		'template'=>'{pay} {print}',
		'buttons'=>array(
			'pay'=>array(
				'icon'=>'icon-dollar',
				'label'=>'Pay',
				/*'options' => array(
						'data-toggle' => 'modal',
						'data-target' => '#myModal',
				),*/
				'url'=>'Yii::app()->createUrl("caisse/view", array("id"=>$data->id))',
				'options'=>array(
                            'ajax'=>array(
                                'type'=>'POST',
                                'url'=>"js:$(this).attr('href')",
                                'success'=>'function(data) { $("#myModal .modal-body p").html(data); $("#myModal").modal(); }'
                            ),
                        ),
				'visible'=>'$data->payment_status==1?false:true;'
			),
			'print'=>array(
				'icon'=>'icon-print',
				'label'=>'Print',
				'options'=>array("target"=>"_blank"),
				'url'=>'Yii::app()->createUrl("caisse/print", array("id"=>$data->id),array("target"=>"_blank"))',
				'visible'=>'$data->payment_status!=1?false:true;'
			)
		)
	),
),
)); ?>