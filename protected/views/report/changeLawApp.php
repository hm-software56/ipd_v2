<?php
$this->layout='column1';
?>
<div class="row">
	<div class="span5">
	<?php /** @var BootActiveForm $form */
	$form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
	    'id'=>'searchForm',
	    'type'=>'search',
	    'htmlOptions'=>array('class'=>'well'),
	)); ?>
	 
	 <div class="control-group">
	  <div class="controls">
	    <div class="input-prepend">
	      <span class="add-on"><i class="icon-search"></i></span>
	      <?php $this->widget('zii.widgets.jui.CJuiDatePicker', array(
		    'model'=>$modelIndoc,
	       'attribute'=>'start_date',
		    'options'=>array(
		        'dateFormat'=>'yy',
		        'yearRange'=>'-70:+0',
		      	'changeYear'=>'true',
		    ),
		)); ?>
	     </div>
	    <?php $this->widget('bootstrap.widgets.TbButton', array('buttonType'=>'submit', 'label'=>'Go')); ?>
	
	  </div>
	</div>
	<?php $this->endWidget(); ?>
	</div>
</div>
<table class="table table-bordered" >
<tr>
	<th><?php echo Yii::t('app','Year')?></th>
	<th><?php echo Yii::t('app','Company')?></th>
	<th><?php echo Yii::t('app','Representative Office')?></th>
</tr>
<?php 
foreach ($year as $years)
{
?>
<tr>
	<th><?php echo $years?></th>
	<td>
	<?php 
	$count=Yii::app()->db->createCommand(
		"SELECT COUNT(*) FROM document
					   JOIN user_profile
					   		ON user_profile.user_id=document.created_by
					   JOIN organization
					   		ON organization.id=user_profile.organization_id
					   JOIN region
					   		ON region.id=organization.region_id 
			WHERE  document_type_id=".Yii::app()->params->DoctypeID_Changlaw." AND YEAR(created)=".$years."
					AND document.related_document_id IN(SELECT inc_document_id FROM appform_application_form WHERE application_type_id<>".Yii::app()->params->ApptypeID.")
		"
	)->queryScalar();
	if(!empty($count))
	{
		echo $count;
	}
	?>
	</td>
	<td>
	<?php 
	$count=Yii::app()->db->createCommand(
		"SELECT COUNT(*) FROM document
					   JOIN user_profile
					   		ON user_profile.user_id=document.created_by
					   JOIN organization
					   		ON organization.id=user_profile.organization_id
					   JOIN region
					   		ON region.id=organization.region_id 
			WHERE  document_type_id=".Yii::app()->params->DoctypeID_Changlaw." AND YEAR(created)=".$years."
					AND document.related_document_id IN(SELECT inc_document_id FROM appform_application_form WHERE application_type_id=".Yii::app()->params->ApptypeID.")
		"
	)->queryScalar();
	if(!empty($count))
	{
		echo $count;
	}
	?>
	</td>
</tr>
<?php 
}
?>
</table>
