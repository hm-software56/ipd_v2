<?php

$this->breadcrumbs = array(
	$model->label(2) => array('index'),
	Yii::t('app', 'Update'),
);
?>

<fieldset>
	<legend>Update Representative Application</legend>
	
	<?php $this->renderPartial('_repoffice',array(
	    'model'=>$model,
	    'repoffice'=>$repoffice,
	));?>
</fieldset>
