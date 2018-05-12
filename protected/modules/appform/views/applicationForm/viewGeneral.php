<?php

$this->breadcrumbs = array(
	$model->label(2) => array('index'),
	Yii::t('app', 'Update'),
);
?>

<fieldset>
	<legend>Update General Application</legend>
	
<?php
    $type = ApplicationType::model()->findByPk($model->application_type_id);
    $doc = Yii::app()->controller->module->documentClass;
    $docNo = Yii::app()->controller->module->documentNo;
    $document=$doc::model()->findByPk($model->inc_document_id);
    $document_no = $document->$docNo;
?>

<div class="form">
<?php $form = $this->beginWidget('bootstrap.widgets.TbActiveForm',array(
    'id'=>'general-form',
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
<?php echo $form->labelEx($general,'project_name');?>
<span><code><?php echo $general->project_name;?></code></span>
</div>
</div>
<div class="row-fluid">
<div class="span9" style="margin-top:20px">
<?php echo $form->labelEx($general,'company_name');?>
<span><code><?php echo $general->company_name;?></code></span>
</div>
</div>

<div class="row-fluid">
<div class="span3" style="margin-top:20px">
<?php echo $form->checkBoxRow($general,'mou',array('disabled'=>'true'));?>
</div>
<div class="span3" style="margin-top:20px">
<?php echo $form->checkBoxRow($general,'develop_contract',array('disabled'=>'true'));?>
</div>
<div class="span3" style="margin-top:20px">
<?php echo $form->checkBoxRow($general,'consession_contract',array('disabled'=>'true'));?>
</div>
</div>

<div class="row-fluid">
<div class="span3" style="margin-top:20px">
<?php echo $form->labelEx($general,'business_sector_id');?>
<span><code><?php echo $general->businessSector; ?></code></span>
</div>
</div>

<fieldset>
<legend><b><?php echo Yii::t('app','Head office')?></b></legend>
<div class="row-fluid">
<div class="span3" style="margin-top:20px">
<?php echo $form->labelEx($general,'province_id');?>
<span><code><?php echo $general->province;?></code></span>
</div>
<div class="span3" style="margin-top:20px">
<?php echo $form->labelEx($general,'district_id');?>
<span><code><?php echo $general->district;?></code></span>
</div>
<div class="span3" style="margin-top:20px">
<?php echo $form->labelEx($general,'village_id');?>
<span><code><?php echo $general->village;?></code></span>
</div>
<div class="span3" style="margin-top:20px">
<?php echo $form->labelEx($general,'address');?>
<span><code><?php echo $general->address;?></code></span>
</div>
</div>
</fieldset>

<fieldset>
<legend><b><?php echo Yii::t('app','Project Site')?></b></legend>

<div class="row-fluid">
	<?php echo $this->renderPartial('_generalsite',array('model'=>$model,'general'=>$general));?>
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
