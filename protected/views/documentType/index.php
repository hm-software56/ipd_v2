<?php
$this->layout='column1';
?>

<?php $this->widget('bootstrap.widgets.TbGridView',array(
	'id'=>'document-type-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'summaryText' => Yii::t('app','Displaying {start}-{end} of {count} result(s)'),
	'columns'=>array(
		'id',
		'parent_id',
		array(
			'class'=>'CLinkColumn',
			'label'=>Yii::t('app', 'Add'),
			'urlExpression'=>'Yii::app()->createUrl("/documentType/create", array("parent"=>$data->id))',
			'header'=>Yii::t('app','Add sub document type'),
		),
		array('name'=>'type_level_id',
			'value'=>'$data->typeLevel->description',
		),
		'description',
		
		array(
			'class'=>'bootstrap.widgets.TbButtonColumn',
			'template'=>'{update}{delete}',
		),
	),
)); ?>
