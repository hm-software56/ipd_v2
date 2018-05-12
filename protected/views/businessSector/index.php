<?php
$this->layout="column1";

$this->menu=array(
array('label'=>'Create BusinessSector','url'=>array('create')),
array('label'=>'Manage BusinessSector','url'=>array('admin')),
);
?>

<?php $this->widget('bootstrap.widgets.TbGridView',array(
'id'=>'business-sector-grid',
'dataProvider'=>$model->search(),
//'filter'=>$model,
'columns'=>array(
		'id',
		'sector_name',
array(
'class'=>'bootstrap.widgets.TbButtonColumn',
'template'=>'{update}'
),
),
)); ?>
