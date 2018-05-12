<?php
$this->layout="column1";
$this->breadcrumbs=array(
	'Out Documents'=>array('index'),
	$model->document_id,
);

$this->menu=array(
	array('label'=>'List OutDocument','url'=>array('index')),
	array('label'=>'Create OutDocument','url'=>array('create')),
	array('label'=>'Update OutDocument','url'=>array('update','id'=>$model->document_id)),
	array('label'=>'Delete OutDocument','url'=>'#','linkOptions'=>array('submit'=>array('delete','id'=>$model->document_id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage OutDocument','url'=>array('admin')),
);
?>

<h1>View OutDocument #<?php echo $model->document_id; ?></h1>

<?php $this->widget('bootstrap.widgets.TbDetailView',array(
	'data'=>$model,
	'attributes'=>array(
		'document_id',
		'out_document_no',
		'document_title',
		'document_date',
	),
)); ?>

<div>
<?php

$gridDataProvider= new CArrayDataProvider($model->receivers); 

	$this->widget('bootstrap.widgets.TbGridView', array(
	'id'=>'receiverslist-grid',
    'type'=>'striped bordered condensed',
    'dataProvider'=>$gridDataProvider,
    'template'=>"{items}",
    'columns'=>array(
        array('name'=>'id', 'header'=>'#'),
        array('name'=>'receiver_name', 'header'=>'Full Name'),
        array('name'=>'toOrganization.organization_name', 
        	  	'header'=>'Organization',
        		'value'=>'$data->toOrganization->organization_name'
        ),
        array('name'=>'documentStatus.status_description', 
        	  	'header'=>'Status',
        		'value'=>'$data->documentStatus->status_description'
        ),
        array('name'=>'status_date', 
        	  	'header'=>'Date',
        		'value'=>'$data->status_date'
        ),
    ),
));
?>
</div>

<div class="row-fluid">
	<div class="span12">
		<div class="row-fluid">	
			<div class="span4">
				<div class="row2"><?php echo Yii::t('app','Document No')?>: <?php echo $model->out_document_no;?></div>
				<div class="row2"><?php echo Yii::t('app','Title')?>: <?php echo $model->document->document_title;?></div>
				<div class="row2"><?php echo Yii::t('app','Organization')?>: <?php echo $model->document->createdBy->userProfile->organization->organization_name;?></div>
				<div class="row2"><?php echo Yii::t('app','Created By')?>: <?php echo $model->document->createdBy->userProfile->first_name;?></div>
			</div>
			<div class="span4">
				<div class="row2"><?php echo Yii::t('app','Create Date')?>: <?php echo $model->document->document_date;?></div>
				<div class="row2"><?php echo Yii::t('app','Type')?>: <?php echo $model->document->documentType->description;?></div>
			</div>
			<div class="span4">
				<div class="row2">Ref No: </div>
				<div class="row2">Status: </div>
				<div class="row2">Tel: </div>
			</div>
		</div>
		<p>
		<div class="row-fluid">
			<div class="span12">
				<div><?php echo $model->document->getAttributeLabel('detail')?></div> 
				<div class="well offset0"><?php echo $model->document->detail?></div>
				<?php 
				if($model->document->attachFiles!=NULL){
				?>
				<div><h6><?php echo Yii::t('app','Attached Files')?>:</h6></div>
				<?php 
					foreach($model->document->attachFiles as $file)
					{
						?>
						<div class="row">
							<div class="span4 offset1"><?php echo $file->file_name?></div>
							<div class="span4">
							<?php echo CHtml::link("<i class='icon-download-alt icon-red'></i>",
										Yii::app()->getBaseUrl()."/file/".$file->file_name,
										array('target'=>'_blank')
							)
							?>
							</div>
						</div>
						<?php
					}
				}
				?>
				<?php 
				$related_docs = Document::model()->findAllBySql(
					"select * from document where related_document_id=$model->document_id 
					OR id in(select related_document_id from document where id=$model->document_id)");
				if($related_docs)
				{
					?>
					<p>
					<div><h6><?php echo Yii::t('app','Related to the following documents')?>:</h6></div>
					<table class="table table-hover">
						<thead><tr>
							<th>ID</th>
							<th><?php echo Yii::t('app','Document No')?></th>
							<th><?php echo Yii::t('app','Date')?></th>
							<th><?php echo Yii::t('app','Title')?></th>
							<th><?php echo Yii::t('app','In or Out')?></th>
							<th><?php echo Yii::t('app','Type')?></th>
							<th><?php echo Yii::t('app','From')?></th>
							<th><?php echo Yii::t('app','Status')?></th>
						</tr></thead>
						<?php 
						foreach($related_docs as $doc)
						{
							?>
							<tr>
								<td><?php echo $doc->id ?></td>
								<td><?php 
									echo CHtml::link(($doc->in_or_out=="INC")?$doc->incDocument->inc_document_no:$doc->outDocument->out_document_no,
											   	Yii::app()->controller->createUrl('viewDocument',array('id'=>$doc->id,'inout'=>$doc->in_or_out))
											   );?>
								</td>
								<td><?php echo $doc->document_date?></td>
								<td><?php echo CHtml::link($doc->document_title,
											   	Yii::app()->controller->createUrl('viewDocument',array('id'=>$doc->id,'inout'=>$doc->in_or_out))
											   );
												?></td>
								<td><?php echo $doc->in_or_out?></td>
								<td><?php echo $doc->documentType->description?></td>
								<?php
								if($doc->in_or_out=="OUT"){
									?> 
									<td colspan="2">
									<?php 
										foreach($doc->outDocument->documentReceiver as $to)
										{
											echo "<div class='row'><div class='span6'>".$to->receiver_name."</div>";
											echo "<div class='span2'>".$to->documentStatus->status_description."</div></div>";
										}
									?>
									</td>
									<?php 
								}else{
									?>
									<td><?php echo $doc->incDocument->fromOrganization->organization_name?></td>
									<td><?php echo $doc->incDocument->documentStatus->status_description?></td>
								<?php 
								}
								?>
							</tr>
							<?php 
						}
						?>
					</table>
					<p/>
					<?php 	
				}
				?>
			</div>
		</div>
		<p/>
	</div>
</div>
