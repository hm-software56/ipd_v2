<div class="wide form">

<?php $form = $this->beginWidget('GxActiveForm', array(
	'action' => Yii::app()->createUrl($this->route),
	'method' => 'get',
)); ?>

	<div class="row">
		<?php echo $form->label($model, 'id'); ?>
		<?php echo $form->textField($model, 'id'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model, 'application_type_id'); ?>
		<?php echo $form->dropDownList($model, 'application_type_id', GxHtml::listDataEx(ApplicationType::model()->findAllAttributes(null, true)), array('prompt' => Yii::t('app', 'All'))); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model, 'inc_document_id'); ?>
		<?php echo $form->textField($model, 'inc_document_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model, 'investor_region_id'); ?>
		<?php echo $form->dropDownList($model, 'investor_region_id', GxHtml::listDataEx(InvestorRegion::model()->findAllAttributes(null, true)), array('prompt' => Yii::t('app', 'All'))); ?>
	</div>

	<div class="row buttons">
		<?php echo GxHtml::submitButton(Yii::t('app', 'Search')); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->
