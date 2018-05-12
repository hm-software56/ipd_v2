<?php
$this->layout='column1';
?>

<?php $this->widget('bootstrap.widgets.TbGridView',array(
	'id'=>'document-status-grid',
	'dataProvider'=>$model->search(),
	//'filter'=>$model,
	'summaryText' => Yii::t('app','Displaying {start}-{end} of {count} result(s)'),
	
	'columns'=>array(
		'id',
		'status_type',
		'status_description',
		array(
			'class'=>'bootstrap.widgets.TbButtonColumn',
			'template'=>'{update}{delete}'
		),
	),
)); ?>