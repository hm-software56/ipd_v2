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
 <?php $this->beginWidget('bootstrap.widgets.TbBox', array(
    'title' => Yii::t('app','Document description'),
    'headerIcon' => 'icon-book',
    )); ?>
    <table>
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
	</table>
 <?php $this->endWidget(); ?>
 
 <?php $this->beginWidget('bootstrap.widgets.TbBox', array(
    'title' => Yii::t('app','Document status'),
    'headerIcon' => 'icon-question-sign',
    )); ?>
    <?php
    	Yii::app()->session['status_id']=null;
		$indocHistory=IncDocumentHistory::model()->findAll('document_id='.$model->document_id.'');
		if($indocHistory)
		{
			foreach ($indocHistory as $indocHis)
			{
				$status=DocumentStatus::model()->findByPK($indocHis->document_status_id);
				if($status->id!=Yii::app()->session['status_id'])
				{
					echo "<div class='span3'><div>".$status->status_description."</div></div>";
					echo "<div class='span5'><div>".$indocHis->last_modified."</div></div>";
				}
				Yii::app()->session['status_id']=$indocHis->document_status_id;	
			}
		}	
		if($model->document_status_id !=Yii::app()->session['status_id'])
		{
			echo "<div class='span3'><div>".$model->documentStatus->status_description."</div></div>";
			echo "<div class='span5'><div>".$model->document->last_modified."</div></div>";
		}
	?>
 <?php $this->endWidget(); ?>
 
 <?php $this->beginWidget('bootstrap.widgets.TbBox', array(
    'title' => Yii::t('app','Detail'),
    'headerIcon' => 'icon-home',
    )); ?>
	  <?php 
	 	 echo $model->document->detail;
	  ?>
 <?php $this->endWidget(); ?>
 
 <?php $this->beginWidget('bootstrap.widgets.TbBox', array(
    'title' => Yii::t('app','Comment'),
    'headerIcon' => 'icon-comment',
    )); ?>
	  <table width="100%" cellpadding="0" cellspacing="0">
		  <?php 
		  $comments=Comment::model()->public()->findAll("document_id=".$model->document->id);
		  if($comments)
		  foreach ($comments as $comment)
		  {
		  ?>
		  	<tr>
		  	<td width="85%"><?php echo $comment->comment_detail?></td>
		  	<td><span style="color:#999999; font-size:12px"><?php echo $comment->comment_time?></span></td>
		  	</tr>
		  <?php 
		  }
		  ?>
	  </table>
 <?php $this->endWidget(); ?>
 
 <?php $this->beginWidget('bootstrap.widgets.TbBox', array(
    'title' => Yii::t('app','Comment from DG'),
    'headerIcon' => 'icon-comment',
    )); ?>
	  <table width="100%" cellpadding="0" cellspacing="0">
		  <?php 
		  $comments=Comment::model()->to_me()->findAll("document_id=".$model->document->id);
		  if($comments)  
		  foreach ($comments as $comment)
		  {
		  	$modelcomment=Comment::model()->findByPK($comment->id);
		  ?>
		  	<tr>
		  	<td width="80%">
		  <?php echo $comment->comment_detail?></td>
		  	<td width="20%"><span style="color:#999999; font-size:12px"><?php echo $comment->comment_time?></span></td>
		  	</tr>
		  <?php 
		  }
		  ?>
	</table>	
 <?php $this->endWidget(); ?>
 <?php 
	if(Yii::app()->user->checkAccess('DG'))
	{
?>
 <?php $this->beginWidget('bootstrap.widgets.TbBox', array(
    'title' => Yii::t('app','Add Comment for DG'),
    'headerIcon' => 'icon-edit',
    )); ?>
	<table>
  	<tr><td colspan="3">
	<link rel="stylesheet" href="<?php echo Yii::app()->baseUrl?>/js/jquery-ui.css" />
  	<script src="<?php echo Yii::app()->baseUrl?>/js/jquery-1.9.1.js"></script>
	<script src="<?php echo Yii::app()->baseUrl?>/js/jquery-ui.js"></script>
	<script>
	  $(function() {
	    $( "#accordion" ).accordion();
	  });
	</script>
	  
		  <?php 
		  	$form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
				'id'=>'comment-form',
				'enableAjaxValidation'=>false,
			));
			
		  	$users = User::model()->with(array('userProfile'))->findAll("id!=".Yii::app()->user->id,array('order'=>'organization_id'));
		  	//$users=UserProfile::model()->findAll("user_id!=".Yii::app()->user->id."");
		  	//$organization=Organization::model()->findAll();
		  	
		  if($users)
			{
			$mylist = null;
			foreach ($users as $u)
			{
			$member = NULL;
			$member=array('value'=>$u->id,'label'=>$u->userProfile->first_name.' '.$u->userProfile->last_name);
			$mylist[$u->userProfile->organization->organization_name][]= $member;
			}
			?>
			<div id="accordion">
			<?php 
			foreach(array_keys($mylist) as $key)
			{
			?><h3><?php echo $key?></h3>
			<div><?php 
			foreach($mylist[$key] as $member)
			{
			echo CHtml::checkBoxList('toUsers[]',NULL,array($member['value']=>$member['label']),array('labelOptions'=>array('style'=>'display:inline'))).'<br/>';
			}
			?>
			</div><?php 
			}
			?></div>
			<?php 
			
			}
		  	
			?>
		
			<?php
			echo $form->textAreaRow(new Comment,'comment_detail',array( 'rows'=>'5','class'=>'span5'));
			?>
			<div>
			<?php 
			$this->widget('bootstrap.widgets.TbButton', array(
				'buttonType'=>'submit',
				'type'=>'primary',
				'label'=>'Save Comment',
			));?>
			</div>
			<?php 
			$this->endWidget();
			?>
	</td>
  </tr>	
	  </table>

 <?php $this->endWidget(); ?>
 <?php 
	}
?>

 <?php $this->beginWidget('bootstrap.widgets.TbBox', array(
    'title' => Yii::t('app','Attach file'),
    'headerIcon' => 'icon-file',
    )); ?>
 	
 	<table>
 	<tr>
  <td >
  <?php 
  $attach=AttachFile::model()->findallbyattributes(array('document_id'=>$model->document_id));
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
 	</table>
 	
 <?php $this->endWidget(); ?>  
 
 <?php $this->beginWidget('bootstrap.widgets.TbBox', array(
    'title' => Yii::t('app','Relate document'),
    'headerIcon' => 'icon-th',
    )); ?>
    <table>
	<tr>
  <td colspan="3">
  <?php 
	$related_docs = Document::model()->findAllBySql(
		"select * from document where related_document_id=$model->document_id 
		OR id in(select related_document_id from document where id=$model->document_id)");
	if($related_docs)
	{
	?>
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
        foreach($doc->outDocument->documentReceivers as $to)
        {?>
      <tr>
      	<td><?php echo $to->receiver_name?></td>
		<td><?php echo $to->documentStatus->status_description?></td>
      </tr>
      <?php 
        }
      ?>
      </table></td>
  <?php 
	}else {
		echo "<td>".$doc->incDocument->fromOrganization->organization_name."</td>";
		echo '<td>'.$doc->incDocument->documentStatus->status_description."</td>";
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

 <?php $this->endWidget(); ?>   

 
