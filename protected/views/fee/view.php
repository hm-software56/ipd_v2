<?php
$this->breadcrumbs=array(
	'Fees'=>array('index'),
	$model->id,
);

$this->menu=array(
array('label'=>'List Fee','url'=>array('index')),
array('label'=>'Create Fee','url'=>array('create')),
array('label'=>'Update Fee','url'=>array('update','id'=>$model->id)),
array('label'=>'Delete Fee','url'=>'#','linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
array('label'=>'Manage Fee','url'=>array('admin')),
);
?>

<h1>View Fee #<?php echo $model->id; ?></h1>

<?php $this->widget('bootstrap.widgets.TbDetailView',array(
'data'=>$model,
'attributes'=>array(
		'id',
		'fee_description',
		'amount_to_budget',
		'amount_to_department',
),
)); ?>
