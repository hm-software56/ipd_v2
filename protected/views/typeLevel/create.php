<?php
$this->layout='column1';
?>
<?php $this->beginWidget('bootstrap.widgets.TbBox', array(
    'title' => Yii::t('app','Create Type Level'),
    'headerIcon' => 'icon-edit',
    ));
?>
	<?php echo $this->renderPartial('_form',array('model'=>$model)); ?>
<?php $this->endWidget(); ?>