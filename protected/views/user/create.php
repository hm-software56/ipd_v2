<?php
$this->layout='column1';
/*$this->breadcrumbs=array(
	'Users'=>array('index'),
	'Create',
);*/

?>
<?php $this->beginWidget('bootstrap.widgets.TbBox', array(
    'title' => Yii::t('app','Create User'),
    'headerIcon' => 'icon-edit',
    ));
?>
	<?php echo $this->renderPartial('_form', array('model'=>$model,'assignment'=>$assignment)); ?>
<?php $this->endWidget(); ?>
