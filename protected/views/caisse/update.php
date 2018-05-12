<?php
$this->breadcrumbs=array(
	'Caisses'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

	$this->menu=array(
	array('label'=>'List Caisse','url'=>array('index')),
	array('label'=>'Create Caisse','url'=>array('create')),
	array('label'=>'View Caisse','url'=>array('view','id'=>$model->id)),
	array('label'=>'Manage Caisse','url'=>array('admin')),
	);
	?>

	<h1>Update Caisse <?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form',array('model'=>$model)); ?>