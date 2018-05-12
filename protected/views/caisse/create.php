<?php
$this->breadcrumbs=array(
	'Caisses'=>array('index'),
	'Create',
);

$this->menu=array(
array('label'=>'List Caisse','url'=>array('index')),
array('label'=>'Manage Caisse','url'=>array('admin')),
);
?>

<h1>Create Caisse</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>