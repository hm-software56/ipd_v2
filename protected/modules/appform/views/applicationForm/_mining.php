<?php
    $type = ApplicationType::model()->findByPk($model->application_type_id);
    $doc = Yii::app()->controller->module->documentClass;
    $docNo = Yii::app()->controller->module->documentNo;
    $document=$doc::model()->findByPk($model->inc_document_id);
    $document_no = $document->$docNo;
    
    $criteria = new CDbCriteria;
    $criteria->order = 'id';
?>

<div class="form">
	<p class="note">
		<?php echo Yii::t('app', 'Fields with'); ?> <span class="required">*</span> <?php echo Yii::t('app', 'are required'); ?>.
	</p>
	
<?php $form = $this->beginWidget('bootstrap.widgets.TbActiveForm',array(
    'id'=>'mining-form',
    'enableAjaxValidation'=>false,
));?>

<?php echo $form->errorSummary(array($model,$mining));?>

<div class="row-fluid">
<div class="span3">
<?php echo $form->labelEx($model,'application_type_id');?>
<span><?php echo $type->description;?></span>
</div>
<div class="span3">
<?php echo $form->labelEx($model,'inc_document_id');?>
<span><?php echo $document_no;?></span>
</div>
<div class="span3">
<?php echo $form->dropDownListRow($model,'investor_region_id',
    CHtml::listData(InvestorRegion::model()->findAll(), 'id', InvestorRegion::representingColumn())
);?>
</div>
<div class="span3">
<?php echo $form->textFieldRow($model, 'contact_email');?>
</div>
</div>

<div class="row-fluid">
<div class="span3">
<?php echo $form->dropDownListRow($model,'application_step_id',
    CHtml::listData(ApplicationStep::model()->findAll(), 'id', ApplicationStep::representingColumn())
);?>
</div>
</div>

<div class="row-fluid">
<div class="span9">
<?php echo $form->textFieldRow($mining, 'company_name', array('style'=>'width:100%'));?>
</div>
</div>
<div class="row-fluid">
<div class="span9">
<?php echo $form->textFieldRow($mining, 'objective', array('style'=>'width:100%'));?>
</div>
</div>

<div class="row-fluid">
<div class="span3">
<?php echo $form->textFieldRow($mining,'total_capital');?>
</div>
<div class="span3">
<?php echo $form->textFieldRow($mining,'capital');?>
</div>
<div class="span3">
<?php echo $form->textFieldRow($mining,'fixed_asset');?>
</div>
<div class="span3">
<?php echo $form->textFieldRow($mining,'current_asset');?>
</div>
</div>

<fieldset>
<legend><b><?php echo Yii::t('app','Head office')?></b></legend>
<div class="row-fluid">
<div class="span3">
<?php echo $form->dropDownListRow($mining,'province_id',
    CHtml::listData(Province::model()->findAll($criteria), 'id', 
    Province::representingColumn()),
    array(
        'prompt'=>'Please select',
        'options'=>array($mining->province_id=>array('selected'=>'selected')),
        'ajax'=>array(
            'type'=>'POST',
            'url'=>Yii::app()->controller->createUrl('districtDropDownList6'),
            'success'=>'js:function(data){
                $("#Mining_district_id").html(data);
                $("#Mining_village_id").html("<option value=\"\">Please Select</option>");
            }',
        )
    )
);?>
</div>
<div class="span3">
<?php echo $form->dropDownListRow($mining,'district_id',
    CHtml::listData(District::model()->findAll('province_id=:pid',array(':pid'=>$mining->province_id)), 'id', 
    District::representingColumn()),
    array(
        'prompt'=>'Please select',
        'options'=>array($mining->district_id=>array('selected'=>'selected')),
        'ajax'=>array(
            'type'=>'POST',
            'url'=>Yii::app()->controller->createUrl('villageDropDownList6'),
            'success'=>'js:function(data){
                $("#Mining_village_id").html(data);
            }',
        )
    )
);?>
</div>
<div class="span3">
<?php echo $form->dropDownListRow($mining,'village_id',
    CHtml::listData(Village::model()->findAll('district_id=:did',array(':did'=>$mining->district_id)), 'id', 
    Village::representingColumn()),
    array(
        'prompt'=>'Please select',
        'options'=>array($mining->village_id=>array('selected'=>'selected')),
    )
);?>
</div>
<div class="span3">
<?php echo $form->textFieldRow($mining,'address');?>
</div>
</div>
</fieldset>
<fieldset>

<fieldset>
<legend><?php echo Yii::t('app','Project Site')?></legend>


<div class="row-fluid">
	<div class="span3">
	<?php echo $form->dropDownListRow($projectSite,'province_id',
	    CHtml::listData(Province::model()->findAll($criteria), 'id', 
	    Province::representingColumn()),
	    array(
	        'prompt'=>'Please select',
	        'options'=>array($projectSite->province_id=>array('selected'=>'selected')),
	        'ajax'=>array(
	            'type'=>'POST',
	            'url'=>Yii::app()->controller->createUrl('districtDropDownList2'),
	            'success'=>'js:function(data){
					$("#MiningProjectSite_district_id").html(data);
					$("#MiningProjectSite_village_id").html("<option value=\"\">Please Select</option>");
	            }',
	        )
	    )
	);?>
	</div>
	<div class="span3">
	<?php echo $form->dropDownListRow($projectSite,'district_id',
	    CHtml::listData(District::model()->findAll('province_id=:pid',array(':pid'=>$projectSite->province_id)), 'id', 
	    District::representingColumn()),
	    array(
	        'prompt'=>'Please select',
	        'options'=>array($projectSite->district_id=>array('selected'=>'selected')),
	        'ajax'=>array(
	            'type'=>'POST',
	            'url'=>Yii::app()->controller->createUrl('villageDropDownList2'),
	            'success'=>'js:function(data){
					$("#MiningProjectSite_village_id").html(data);
	            }',
	        ),
	    )
	);?>
	</div>
	<div class="span3">
	<?php echo $form->dropDownListRow($projectSite,'village_id',
	    CHtml::listData(Village::model()->findAll('district_id=:did',array(':did'=>$projectSite->district_id)),'id',
	    Village::representingColumn()),
	    array(
	        'prompt'=>'Please select',
	        'options'=>array($projectSite->village_id=>array('selected'=>'selected')),
	    )
	);?>
	</div>
	<?php $this->widget('bootstrap.widgets.TbButton',array(
	    'id'=>'project-site-button',
	    'label'=>Yii::t('app','Add Site'),
	    'buttonType'=>'ajaxButton',
	    'type'=>'success',
	    'url'=>$this->createUrl('applicationForm/addSite'),
	    'htmlOptions'=>array(
	        'style'=>'margin-top:28px',
	        'class'=>'pull-right',
	    ),
	    'ajaxOptions'=>array(
	        'type'=>'POST',
	        'url'=>$this->createUrl('applicationForm/addSite'),
	        'success'=>'js:function(data){
				$.fn.yiiGridView.update("mining-site-grid");
				if(data!="") {
					alert(data);
				}
	        }',
	    ),
	));?>
</div>

<div class="row-fluid">
	<?php echo $this->renderPartial('_miningsite',array('model'=>$model,'mining'=>$mining));?>
</div>

</fieldset>

<fieldset>
	<legend><?php echo Yii::t('app','Invest Company')?></legend>
	
	<div class="row-fluid">
	<?php $this->widget('bootstrap.widgets.TbButton',array(
	    'id'=>'modal-button',
	    'label'=>Yii::t('app','Add Invest Company'),
	    'type'=>'warning',
	    'htmlOptions' => array(
	        'class'=>'pull-right',
            'data-toggle' => 'modal',
            'data-target' => '#myModal',
            'Readonly' => 'Readonly'
        ),
	));?>
	</div>
	
	<?php echo $this->renderPartial('_investModal',array('model'=>$model,'mining'=>$mining,'investCompany'=>$investCompany,'form'=>$form));?>

    <div class="row-fluid">
        <?php echo $this->renderPartial('_invest',array('model'=>$model));?>
    </div>	
</fieldset>

<div class="form-actions">
    <?php $this->widget('bootstrap.widgets.TbButton', array(
        'id'=>'appform-button',
        'buttonType'=>'button',
        'type'=>'primary',
        'label'=>$model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Save'),
        'htmlOptions'=>array('onclick'=>'js:$("#mining-form").submit()')
    )); ?>
    <?php $this->widget('bootstrap.widgets.TbButton', array(
        'label'=> Yii::t('app', 'Cancel'),
        'htmlOptions' => array('onclick' => 'javascript:history.go(-1)')
    )); ?>
</div>

<?php $this->endWidget();?>
</div><!-- form -->