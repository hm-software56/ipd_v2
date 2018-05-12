<?php

$this->breadcrumbs = array(
	$model->label(2) => array('index'),
	GxHtml::valueEx($model) => array('view', 'id' => GxActiveRecord::extractPkValue($model, true)),
	Yii::t('app', 'Update'),
);
?>

<fieldset>
	<legend><?php echo Yii::t('appform', 'Update') . ' ' . GxHtml::encode($model->label()); ?></legend>
    <?php
        $this->renderPartial('_form', array(
			'model' => $model));
    ?>
</fieldset>
