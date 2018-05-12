<?php
$this->layout='column1';
/*
$this->breadcrumbs=array(
	'Inc Documents'=>array('index'),
	$model->document_id,
);

$this->menu=array(
	array('label'=>'List IncDocument','url'=>array('index')),
	array('label'=>'Create IncDocument','url'=>array('create')),
	array('label'=>'Update IncDocument','url'=>array('update','id'=>$model->document_id)),
	array('label'=>'Delete IncDocument','url'=>'#','linkOptions'=>array('submit'=>array('delete','id'=>$model->document_id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage IncDocument','url'=>array('admin')),
);*/

Yii::app()->clientScript->registerScript(
   'myHideEffect',
   '$(".info").animate({opacity: 1.0}, 3000).fadeOut("slow");',
   CClientScript::POS_READY
);

?>

<?php if(Yii::app()->user->hasFlash('success')):?>
    <div class="info">
        <?php echo Yii::app()->user->getFlash('success'); ?>
    </div>
<?php endif; ?>
<?php echo'<b>'.Yii::t('app','Document description').'<b>'?>
<table class="table">
  <tr>
    <td>
    <?php echo Yii::t('app','inc_document_no').": ".$model->inc_document_no?>
    <br/>
    <?php echo Yii::t('app','Document Title').": ".$model->document->document_title?>
    <br/>
    <?php echo Yii::t('app','Organization Name').": ".$model->fromOrganization->organization_name?>
    <br/>
    <?php 
    if(!empty($model->document->last_modified_id))
    	echo Yii::t('app','Single window employee').": ".$model->document->createdBy->userProfile->first_name;
    else 
    	echo Yii::t('app','Single window employee').": ".$model->document->lastModified->userProfile->first_name;
    ?>
    </td>
    <td>
    <?php echo Yii::t('app','Created').": ".date('d-m-Y',strtotime($model->document->created))?>
    <br/>
    <?php echo Yii::t('app','Type').": ".$model->document->documentType->description?>
    <br/>
    <?php echo Yii::t('app','Sender').": ".$model->sender?>
    <br/>
    <?php echo Yii::t('app','Sender contact').": ".$model->sender_contact?> 
    </td>
    <td>
    <?php echo Yii::t('app','Sender ref').": ".$model->sender_ref?> 
    <br/>
    <?php echo Yii::t('app','Status').": ".$model->documentStatus->status_description?>
    </td>
  </tr>
  <tr>
  <td colspan="3" >
  <b><u><?php echo Yii::t('app','Detail')?></u></b><br/>
  <?php 
 	 echo $model->document->detail;
  ?>
  </td>
  </tr>
  <tr>
  <td colspan="3" class="well">
  <b><u><?php echo Yii::t('app','Comment')?></u></b>
  <table width="100%" cellpadding="0" cellspacing="0">
  <?php 
  $comment=Comment::model()->findAllByAttributes(array('document_id'=>$model->document->id));
  foreach ($comment as $comments)
  {
  ?>
  	<tr>
  	<td width="85%"><?php echo $comments->comment_detail?></td>
  	<td><span style="color:#999999; font-size:12px"><?php echo $comments->comment_time?></span></td>
  	</tr>
  <?php 
  }
  ?>
  </table>
  </td>
  </tr>
  <tr>
  <td colspan="3">
  <b><u><?php echo Yii::t('app','Relate information')?></u></b>
  <?php 
  $appform=ApplicationForm::model()->findByAttributes(array('inc_document_id'=>$model->document_id));
  if(is_object($appform))
  {
  ?>
  <table width="100%">
  <?php 
  if($appform->application_type_id==1)
  {
  	$investcompany=RepOffice::model()->findAllByAttributes(array('application_form_id'=>$appform_id));
  	foreach ($investcompany as$investcompanys)
  	{
  ?>
  <tr>
  <td>
  <?php echo Yii::t('app','Company name').': '.$investcompanys->parent_company?>
  </td>
  <td><?php echo Yii::t('app','President').': '.$investcompanys->first_name." ".$investcompanys->last_name?></td>
  <td><?php echo Yii::t('app','Register place').': '.$investcompanys->register_place?></td>
  <td><?php echo Yii::t('app','Total capital').': '.number_format($investcompanys->cash,2)?></td>
  </tr>
  <?php 
  }}
  else 
  { 
  $investcompany=InvestCompany::model()->findAllByAttributes(array('application_form_id'=>$appform_id));
  	foreach ($investcompany as $investcompanys)
  	{ 
  ?>
  <tr>
  <td>
  <?php echo Yii::t('app','Company name').': '.$investcompanys->company_name?>
  </td>
  <td><?php echo Yii::t('app','President').': '.$investcompanys->president_first_name." ".$investcompanys->president_last_name?></td>
  <td><?php echo Yii::t('app','Register place').': '.$investcompanys->register_place?></td>
  <td><?php echo Yii::t('app','Total capital').': '.number_format($investcompanys->total_capital,2)?></td>
  </tr>
  <?php 
  }}
  ?>
  </table>
  <?php 
  }
  ?>
  </td>
  </tr>
  <tr>
  <td colspan="1">
  <?php 
  $attach=AttachFile::model()->findallbyattributes(array('document_id'=>$model->document_id));
  if(!is_object($attach))
  {
  	echo "<b><u>". Yii::t('app','Attach file')."</u></b>";
  }
  ?>
  <table width="100%">
  <?php
  foreach ($attach as $attachs)
  {
  ?>
  <tr>
  <td>
  <?php echo $attachs->title?>
  </td>
  <td>
  <?php 
  echo CHtml::link(CHtml::image('../../images/download.jpg'),array("attachFile/download","id"=>$attachs->id));
  ?>
  </td>
  </tr>
  <?php 
  }
  ?>
  </table>
  </td>
  </tr>
  <tr>
  <td colspan="3">
  <?php 
	$related_docs = Document::model()->findAllBySql(
		"select * from document where related_document_id=$model->document_id 
		OR id in(select related_document_id from document where id=$model->document_id)");
	if($related_docs)
	{
	?>
  <b><u><?php echo Yii::t('app','Relate document ');?></u></b>
  <table width="100%">
  <thead>
  <tr>
  <th><?php echo Yii::t('app','Document No')?></th>
  <th><?php echo Yii::t('app','Date')?></th>
  <th><?php echo Yii::t('app','Title')?></th>
  <th><?php echo Yii::t('app','In or Out')?></th>
  <th><?php echo Yii::t('app','Type')?></th>
  <th><?php echo Yii::t('app','From')?></th>
  <th><?php echo Yii::t('app','Status')?></th>
  </tr>
  </thead>
  <?php 
	foreach($related_docs as $doc)
	{
  ?>
  <tr>
  <td>
  <?php
  	echo CHtml::link(($doc->in_or_out=="INC")?$doc->incDocument->inc_document_no:$doc->outDocument->out_document_no,
	Yii::app()->controller->createUrl('viewDocument',array('id'=>$doc->id,'inout'=>$doc->in_or_out))
	);
  ?>
  </td>
  <td><?php echo $doc->document_date?></td>
  <td>
  <?php echo CHtml::link($doc->document_title,
  	Yii::app()->controller->createUrl('viewDocument',array('id'=>$doc->id,'inout'=>$doc->in_or_out)));
  ?>
  </td>
  <td><?php echo $doc->in_or_out?></td>
  <td><?php echo $doc->documentType->description?></td>
  <?php 
  if($doc->in_or_out=="OUT"){
  ?>
  <td colspan="2">
	  <table cellpadding="0" cellspacing="0">
	  <?php 
		foreach($doc->outDocument->documentReceiver as $to)
		{
	  ?>
	  <tr>
	  <td><?php echo $to->receiver_name?></td>
	  <td><?php echo $to->documentStatus->status_description?></td>
	  </tr>
	  <?php 
		}
	  ?>
	  </table>
  </td>
  <?php 
	}
	else 
	{
	?>
  <td><?php echo $doc->incDocument->fromOrganization->organization_name;?></td>
  <td><?php echo $doc->incDocument->documentStatus->status_description;?>
  </td>
  <?php
  }
  ?>
  </tr>
  <?php 
	}
  ?>
  </table>
  <?php 
	}
  ?>
  </td>
  </tr>
</table>

