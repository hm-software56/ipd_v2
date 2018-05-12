<div class="row-fluid">
<div class="span1">
<b><?php echo Yii::t('app','Title').":"?></b>
</div>
<div class="span11">
<?php echo $model->document_title?>
</div>
</div>
<div class="row-fluid">
<div class="span12">
<div>
<table class="table">
	<tr style="background:#8297c1">
		<th><?php echo Yii::t('app','Document #')?></th>
		<th><?php echo Yii::t('app','Document Status')?></th>
		<th><?php echo Yii::t('app','in_or_out_organization')?></th>
		<th><?php echo Yii::t('app','Date')?></th>
	</tr>
<?php 
	$data=Document::model()->getshowrelate($model->id, $model->related_document_id, '');
	if(!empty($data))
	{
		echo $data;
	}else{
		echo "<tr><th colspan='3'>".Yii::t('app','No send to section')."</th></tr>";
	}

?>
</table></div>
</div>
</div>