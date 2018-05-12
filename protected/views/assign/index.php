<?php
$this->breadcrumbs=array(
	'Assigns',
);

$this->menu=array(
	array('label'=>'Create Assign','url'=>array('create')),
	array('label'=>'Manage Assign','url'=>array('admin')),
);
?>

<h1>Assigns</h1>

<?php $this->widget('bootstrap.widgets.TbListView',array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
