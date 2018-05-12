<?php

$this->breadcrumbs = array(
	$model->label(2) => array('index'),
	Yii::t('app', 'Update'),
);
?>

<fieldset>
	<legend>Update Mining Application</legend>
	
	<?php $this->renderPartial('_mining',array(
	    'model'=>$model,
	    'mining'=>$mining,
	    'projectSite'=>$projectSite,
	    'investCompany'=>$investCompany,
	));?>
</fieldset>
