<?php
$this->layout="column1";
/*$this->breadcrumbs=array(
	'Attach Files'=>array('index'),
	'Create',
);
*/
$this->menu=array(
	array('label'=>'List AttachFile','url'=>array('index')),
	array('label'=>'Manage AttachFile','url'=>array('admin')),
);
?>
<?php $this->beginWidget('bootstrap.widgets.TbBox', array(
    'title' => Yii::t('app','Upload Attach File'),
    'headerIcon' => 'icon-circle-arrow-up',
    ));
?>
	<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>
	<?php $this->widget('bootstrap.widgets.TbGridView',array(
		'id' => 'attach-file-grid',
		'dataProvider' =>$dataProvider,
		 'summaryText' => '',
		//'filter' => $model,
		'columns' => array(
			array(
				'name'=>'id',
				'value'=>'$data->id',
				'filter'=>false,
			),
			array(
					'name'=>'document_id',
					'value'=>'$data->document->document_title',
					'filter'=>false,
					),
			'title',
			array(
				'name'=>'file_name',
				'value'=>'$data->file_name',
				'filter'=>false,
			),
			array(
				'class'=>'bootstrap.widgets.TbButtonColumn',
				'template'=>'{view}{delete}',
				 'buttons'=>array(       
	                                'view' => array(
	                                  'url'=>'Yii::app()->controller->createUrl("attachFile/download", array("id"=>$data->id))',
	                                ),
	                        ),
			),
		),
	)); ?>
<?php $this->endWidget(); ?>