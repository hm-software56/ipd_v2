<?php
$this->breadcrumbs=array(
	'Type Levels'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'List TypeLevel','url'=>array('index')),
	array('label'=>'Create TypeLevel','url'=>array('create')),
	array('label'=>'Update TypeLevel','url'=>array('update','id'=>$model->id)),
	array('label'=>'Delete TypeLevel','url'=>'#','linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage TypeLevel','url'=>array('admin')),
);
?>

<h1>View TypeLevel #<?php echo $model->id; ?></h1>

<?php $this->widget('bootstrap.widgets.TbDetailView',array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'description',
		'parent_id',
	),
)); ?>
