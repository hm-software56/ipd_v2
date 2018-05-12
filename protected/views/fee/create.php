<?php
$this->layout="column1";
$this->breadcrumbs=array(
	'ຄ່າທໍານຽມ'=>array('index'),
	'ເພີ່ມຄ່າທໍານຽມ',
);
?>
<?php $this->beginWidget('bootstrap.widgets.TbBox', array(
    'title' => Yii::t('app','Fees'),
    'headerIcon' => 'icon-edit',
    ));
?>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>

<?php $this->endWidget(); ?>