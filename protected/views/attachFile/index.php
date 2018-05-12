<?php
$this->breadcrumbs=array(
	'Attach Files',
);

$this->menu=array(
	array('label'=>'Create AttachFile','url'=>array('create')),
	array('label'=>'Manage AttachFile','url'=>array('admin')),
);
?>

<h1>Attach Files</h1>

<?php $this->widget('bootstrap.widgets.TbListView',array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
