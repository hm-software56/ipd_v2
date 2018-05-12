<?php
$this->layout="column1";

$this->menu=array(
array('label'=>'List BusinessSector','url'=>array('index')),
array('label'=>'Create BusinessSector','url'=>array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
$('.search-form').toggle();
return false;
});
$('.search-form form').submit(function(){
$.fn.yiiGridView.update('business-sector-grid', {
data: $(this).serialize()
});
return false;
});
");
?>
<?php $this->widget('bootstrap.widgets.TbGridView',array(
'id'=>'business-sector-grid',
'dataProvider'=>$model->search(),
'filter'=>$model,
'columns'=>array(
		'id',
		'sector_name',
array(
'class'=>'bootstrap.widgets.TbButtonColumn',
),
),
)); ?>
