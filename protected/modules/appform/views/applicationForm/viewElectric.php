<?php

$this->breadcrumbs = array(
	$model->label(2) => array('index'),
	Yii::t('app', 'View'),
);
?>

<fieldset>
	<legend>View Electric Application</legend>
	
<?php
    $type = ApplicationType::model()->findByPk($model->application_type_id);
    $doc = Yii::app()->controller->module->documentClass;
    $docNo = Yii::app()->controller->module->documentNo;
    $document=$doc::model()->findByPk($model->inc_document_id);
    $document_no = $document->$docNo;
?>

<div class="form">
<?php $form = $this->beginWidget('bootstrap.widgets.TbActiveForm',array(
    'id'=>'electric-form',
    'enableAjaxValidation'=>false,
));?>

<div class="row-fluid">
<div class="span3" style="margin-top:20px">
<?php echo $form->labelEx($model,'application_type_id');?>
<span><code><?php echo $type->description;?></code></span>
</div>
<div class="span3" style="margin-top:20px">
<?php echo $form->labelEx($model,'inc_document_id');?>
<span><code><?php echo $document_no;?></code></span>
</div>
<div class="span3" style="margin-top:20px">
<?php echo $form->labelEx($model,'investor_region_id');?>
<span><code><?php echo $model->investorRegion;?></code></span>
</div>
<div class="span3" style="margin-top:20px">
<?php echo $form->labelEx($model,'contact_email');?>
<span><code><?php echo $model->contact_email;?></code></span>
</div>
</div>

<div class="row-fluid">
<div class="span9" style="margin-top:20px">
<?php echo $form->labelEx($electric,'project_name');?>
<span><code><?php echo $electric->project_name;?></code></span>
</div>
</div>
<div class="row-fluid">
<div class="span9" style="margin-top:20px">
<?php echo $form->labelEx($electric,'company_name');?>
<span><code><?php echo $electric->company_name;?></code></span>
</div>
</div>

<div class="row-fluid">
<div class="span3" style="margin-top:20px">
<?php echo $form->checkBoxRow($electric,'mou',array('disabled'=>'true'));?>
</div>
<div class="span3" style="margin-top:20px">
<?php echo $form->checkBoxRow($electric,'develop_contract',array('disabled'=>'true'));?>
</div>
<div class="span3" style="margin-top:20px">
<?php echo $form->checkBoxRow($electric,'consession_contract',array('disabled'=>'true'));?>
</div>
</div>

<fieldset>
<legend><b><?php echo Yii::t('app','Head office')?></b></legend>
<div class="row-fluid">
<div class="span3" style="margin-top:20px">
<?php echo $form->labelEx($electric,'province_id');?>
<span><code><?php echo $electric->province;?></code></span>
</div>
<div class="span3" style="margin-top:20px">
<?php echo $form->labelEx($electric,'district_id');?>
<span><code><?php echo $electric->district;?></code></span>
</div>
<div class="span3" style="margin-top:20px">
<?php echo $form->labelEx($electric,'village_id');?>
<span><code><?php echo $electric->village;?></code></span>
</div>
<div class="span3" style="margin-top:20px">
<?php echo $form->labelEx($electric,'address');?>
<span><code><?php echo $electric->address;?></code></span>
</div>
</div>
</fieldset>

<fieldset>
<legend><b><?php echo Yii::t('app','Project Site')?></b></legend>

<div class="row-fluid">
	<?php echo $this->renderPartial('_electricsite',array('model'=>$model,'electric'=>$electric));?>
</div>

</fieldset>

<fieldset>
	<legend><b><?php echo Yii::t('app','Invest Company')?></b></legend>
    <div class="row-fluid">
        <?php echo $this->renderPartial('_invest',array('model'=>$model));?>
    </div>	
</fieldset>

<?php $this->endWidget();?>
</div><!-- form -->
</fieldset>
