<?php
/* @var $this AdvancedSearchController */
/* @var $model AdvancedSearch */
/* @var $form CActiveForm */

$cs=Yii::app()->clientScript;  
$cs->registerScriptFile(Yii::app()->baseUrl . '/js/jquery.ba-bbq.js', CClientScript::POS_HEAD);
?>

<div class="form">

<?php 
$form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
//$form=$this->beginWidget('CActiveForm', array(
	'id'=>'advanced-search-advancedsearch-form',
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

<div class="row-fluide">
	<div class="span12">
		<div class="span3">	
		<?php echo $form->textFieldRow($model,'document_title'); ?>
		</div>
		<div class="span3">
		<?php echo $form->hiddenField($model,'in_or_out',array('value'=>'INC')); ?>
		<?php 
			echo $form->dropDownlistRow($model,'in_or_out',
						Utils::enumItem(new Document, 'in_or_out'),
						array(
			                  //'prompt' => Yii::t('app','--Please Select --'),
							  'ajax'  => array(
			                  	'type'  => 'POST',
								'dataType'=>'json',
			                  	'url' => Yii::app()->createUrl('site/getStatusList'), 
			                  	//'update' => '#AdvancedSearch_document_type_id',
								'success'=>'function(data){
									$("#AdvancedSearch_document_status_id").html(data.statusDropDown);
									//$("#AdvancedSearch_document_type_id").html(data.applicationList);
								}',
			                  	'data' => array('in_or_out'=>'js:this.value','model'=>$model),
			                  ),
			            )
				);
				?>
		</div>
		<div class="span3">
			<div id="companyname"></div>
		</div>
	</div>
	<div class="span12">
		<div class="span3">
		<?php echo $form->dropDownListRow($model,'document_type_id',
		  		CHtml::listData(DocumentType::model()->findAll('type_level_id=2'), 'id', 'description'),
		  		array('prompt'=>Yii::t('app','-- Please Select --'))
		  );?>
		</div>
		<div class="span3">
		<?php echo $form->dropDownListRow($model,'document_status_id',
					CHtml::listData(DocumentStatus::model()->findAll('status_type="'.$model->in_or_out.'"'), 'id', 'status_description'),
			  		array('prompt'=>Yii::t('app','-- Please Select --'))
		); ?>
		</div>
	</div>
	<div class="span12">
		<div class="span3">
		<?php echo $form->dropDownListRow($model,'from_organization_id',
					CHtml::listData(Organization::getList(), 'id', 'organization_name'),
			  		array('prompt'=>Yii::t('app','-- Please Select --'))
		); ?>
		</div>
		<div class="span3">
		<?php echo $form->dropDownListRow($model,'to_organization_id',
					CHtml::listData(Organization::getList(), 'id', 'organization_name'),
			  		array('prompt'=>Yii::t('app','-- Please Select --'))
		); ?>
		</div>
	</div>
	<div class="span12">
		<div class="span3">
		<?php echo $form->datepickerRow($model, 'from_date',
				array(	//'hint'=>'Policy start date' , 
						//'prepend'=>'<i class="icon-calendar"></i>', 
						'options'=>array('format' => 'dd-mm-yyyy' , 'weekStart'=> 1)
		        )
		);?>
		</div>
		<div class="span3">
		<?php echo $form->datepickerRow($model, 'to_date',
		array(	//'hint'=>'Policy start date' , 
				//'prepend'=>'<i class="icon-calendar"></i>', 
				'options'=>array('format' => 'dd-mm-yyyy' , 'weekStart'=> 1)
        ));?>
		</div>
		<div class="span2"><?php echo CHtml::submitButton('Submit'); ?></div>
	</div>
</div>

<?php $this->endWidget(); ?>

</div><!-- form -->

<?php 
if($provider)
$this->widget('bootstrap.widgets.TbGridView', array(
//$this->widget('CgridviewWithVariables', array(
	'id'=>'listdocuments-grid',
    'type'=>'striped bordered condensed',
   // 'dataProvider'=>$documents->search(array('pageSize'=>5)), // worked
   'dataProvider'=>$provider,
   'emptyText' => Yii::t('app','No results found.'),
	'summaryText' => Yii::t('app','Displaying {start}-{end} of {count} result(s).'),
	//'extraparam'=>$docID,
    //'template'=>"{items}",
    'columns'=>array(
        array('name' => 'id','value'=>'$data->id'),
        array('name'=>'document_no', 
        	'header'=>Yii::t('app','Document No'),
        	'value'=>'($data->in_or_out=="INC")?$data->incDocument->inc_document_no:$data->outDocument->out_document_no'
        ),
        array(
        	'class'=>'CLinkColumn',
        	//'name'=>'document_title',
        	'header'=>Yii::t('app','Document Title'),
        	'labelExpression'=>'$data->document_title',
        	'urlExpression'=>'Yii::app()->createUrl("search/view",array("docid"=>$data->id,"inorout"=>$data->in_or_out))'
        ),
		'document_date',
        array(
        	'name'=>'from_organization_id',
        	'header'=>Yii::t('app','From Organization'),
        	'value'=>'
        		($data->in_or_out=="INC")?
        			($data->incDocument)?$data->incDocument->fromOrganization->organization_name:""
        			:$data->createdBy->userProfile->organization->organization_name
        	'
        ),
      array(
        	'name'=>'to_organization_id',
      		'header'=>Yii::t('app','To Organization'),
      		'type'=>'raw',
        	'value'=>'
        		($data->in_or_out=="INC")?
        			($data->incDocument)?$data->incDocument->toOrganization->organization_name:""
        			:Outdocument::getReceivers($data->id)
        	'
        ),
        array(
        	'name'=>'document_type',
        	'header'=>Yii::t('app','Document Type'),
        	'value'=>'$data->documentType->description'
        ),
    ),
    )
); 
	
?>