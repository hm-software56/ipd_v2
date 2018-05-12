<div class="form">


<?php $form = $this->beginWidget('GxActiveForm', array(
	'id' => 'application-form-form',
	'enableAjaxValidation' => false,
));
?>

	<p class="note">
		<?php echo Yii::t('app', 'Fields with'); ?> <span class="required">*</span> <?php echo Yii::t('app', 'are required'); ?>.
	</p>

	<?php echo $form->errorSummary($model); ?>

		<div class="row">
		<?php echo $form->labelEx($model,'application_type_id'); ?>
		<?php echo $form->dropDownList($model, 'application_type_id', GxHtml::listDataEx(ApplicationType::model()->findAllAttributes(null, true))); ?>
		<?php echo $form->error($model,'application_type_id'); ?>
		</div><!-- row -->
		<div class="row">
		<?php echo $form->labelEx($model,'inc_document_id'); ?>
		<?php echo $form->textField($model, 'inc_document_id'); ?>
		<?php echo $form->error($model,'inc_document_id'); ?>
		</div><!-- row -->
		<div class="row">
		<?php echo $form->labelEx($model,'investor_region_id'); ?>
		<?php echo $form->dropDownList($model, 'investor_region_id', GxHtml::listDataEx(InvestorRegion::model()->findAllAttributes(null, true))); ?>
		<?php echo $form->error($model,'investor_region_id'); ?>
		</div><!-- row -->

		<label><?php echo GxHtml::encode($model->getRelationLabel('investCompanies')); ?></label>
		<?php echo $form->checkBoxList($model, 'investCompanies', GxHtml::encodeEx(GxHtml::listDataEx(InvestCompany::model()->findAllAttributes(null, true)), false, true)); ?>
		<label><?php echo GxHtml::encode($model->getRelationLabel('repOffices')); ?></label>
		<?php echo $form->checkBoxList($model, 'repOffices', GxHtml::encodeEx(GxHtml::listDataEx(RepOffice::model()->findAllAttributes(null, true)), false, true)); ?>

<?php
echo GxHtml::submitButton(Yii::t('app', 'Save'));
$this->endWidget();
?>
</div><!-- form -->