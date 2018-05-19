<?php
$this->layout='column1';
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
	'title' => Yii::t('app', 'Detail'),
	'headerIcon' => 'icon-home',
)); ?>
	  <?php 
		echo $model->document->detail;
		?>
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
					echo "<div class='span6'><div>".$status->status_description."</div></div>";
					echo "<div class='span6'><div>".$indocHis->last_modified."</div></div>";
				}
				Yii::app()->session['status_id']=$indocHis->document_status_id;	
			}
		}	
		if($model->document_status_id !=Yii::app()->session['status_id'])
		{
			echo "<div class='span4'><div>".$model->documentStatus->status_description."</div></div>";
			echo "<div class='span4'><div>".$model->document->last_modified."</div></div>";
		}
		$assign=Assign::model()->findAllByAttributes(['inc_document_document_id'=>$model->document_id]);
		if($assign)
		{
			foreach ($assign as $assign) {
					echo "<div class='span4'><div>" . $assign->user->userProfile->first_name;
			}
		}
	?>
 <?php $this->endWidget(); ?>
 <?php $this->beginWidget('bootstrap.widgets.TbBox', array(
    'title' => Yii::t('app','ເອ​ກະ​ສານ ແລະ ສະ​ຖາ​ນະ​ທີ​ກ່ຽວ​ຂ້ອງ'),
    'headerIcon' => 'icon-th',
    )); ?>
    <table class="table">
	<tr style="background:#8297c1">
		<th><?php echo Yii::t('app', 'Document #') ?></th>
		<th><?php echo Yii::t('app', 'Document Status') ?></th>
		<th><?php echo Yii::t('app', 'in_or_out_organization') ?></th>
		<th><?php echo Yii::t('app', 'Date') ?></th>
	</tr>
	<?php 
		$data = Document::model()->getshowrelatepublic($model->document->id, $model->document->related_document_id, '');
		if (!empty($data)) {
			echo $data;
		} else {
			echo "<tr><th colspan='3'>" . Yii::t('app', 'No send to section') . "</th></tr>";
		}

	?>
</table>
 <?php $this->endWidget(); ?>   

 
