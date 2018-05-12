<?php
$this->breadcrumbs=array(
	Yii::t('app','Fees'),
);
?>

<h1><?php echo Yii::t('app','Fees');?></h1>

<?php $this->widget('bootstrap.widgets.TbListView',array(
'dataProvider'=>$dataProvider,
'itemView'=>'_view',
)); ?>
