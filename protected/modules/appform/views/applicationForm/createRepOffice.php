<?php

$this->breadcrumbs = array(
	$model->label(2) => array('index'),
	Yii::t('app', 'Create'),
);
?>

<fieldset>
	<legend>Create Representative Application</legend>
	
	<?php $this->renderPartial('_repoffice',array(
	    'model'=>$model,
	    'repoffice'=>$repoffice,
	));?>
</fieldset>
