<?php
$this->breadcrumbs=array(
	'Business Sectors'=>array('index'),
	$model->id,
);

$this->menu=array(
array('label'=>'List BusinessSector','url'=>array('index')),
array('label'=>'Create BusinessSector','url'=>array('create')),
array('label'=>'Update BusinessSector','url'=>array('update','id'=>$model->id)),
array('label'=>'Delete BusinessSector','url'=>'#','linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
array('label'=>'Manage BusinessSector','url'=>array('admin')),
);
?>

<h1>View BusinessSector #<?php echo $model->id; ?></h1>

<?php $this->widget('bootstrap.widgets.TbDetailView',array(
'data'=>$model,
'attributes'=>array(
		'id',
		'sector_name',
),
)); ?>
