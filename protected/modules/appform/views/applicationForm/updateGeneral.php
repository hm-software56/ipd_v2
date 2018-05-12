<?php

$this->breadcrumbs = array(
	$model->label(2) => array('index'),
	Yii::t('app', 'Update'),
);
?>

<fieldset>
	<legend>Update General Application</legend>
	
	<?php $this->renderPartial('_general',array(
	    'model'=>$model,
	    'general'=>$general,
	    'projectSite'=>$projectSite,
	    'investCompany'=>$investCompany,
	));?>
</fieldset>
