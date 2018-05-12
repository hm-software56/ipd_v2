<?php

$this->breadcrumbs = array(
	$model->label(2) => array('index'),
	Yii::t('app', 'Update'),
);
?>

<fieldset>
	<legend>Update Electric Application</legend>
	
	<?php $this->renderPartial('_electric',array(
	    'model'=>$model,
	    'electric'=>$electric,
	    'projectSite'=>$projectSite,
	    'investCompany'=>$investCompany,
	));?>
</fieldset>
