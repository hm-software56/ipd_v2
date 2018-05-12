<?php
$this->layout='column1';
?>
<?php $this->widget('bootstrap.widgets.TbGridView',array(
	'id'=>'type-level-grid',
	'dataProvider'=>$model->search(),
	//'filter'=>$model,
	'summaryText' => Yii::t('app','Displaying {start}-{end} of {count} result(s)'),
	'columns'=>array(
		'id',
		'description',
		array(
			'class'=>'CLinkColumn',
			'label'=>Yii::t('app','Add'),
			'urlExpression'=>'Yii::app()->createUrl("typeLevel/create", array("parent"=>$data->id))',
			'header'=>Yii::t('app','Add sub type level'),
		),
		'parent_id',
		array(
			'class'=>'bootstrap.widgets.TbButtonColumn',
			'template'=>'{update}{delete}',
		),
	),
)); ?>