<?php
$this->layout="column1";
?>

<div class="row-fluid">
	<div class="span12">
		<?php $this->beginWidget('bootstrap.widgets.TbBox', array(
			    'title' => Yii::t('app','Document description'),
			    'headerIcon' => 'icon-book',
			    ));?>
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
				<div class="row2"><?php echo Yii::t('app','Ref No')?>: </div>
				<div class="row2"><?php echo Yii::t('app','Status')?>: </div>
				<div class="row2"><?php echo Yii::t('app','Tel')?>: </div>
			</div>
		</div>
		<?php $this->endWidget()?>
		<p>
		
		<div>
		<?php
		$this->beginWidget('bootstrap.widgets.TbBox', array(
			    'title' => Yii::t('app','Sent to'),
			    'headerIcon' => 'icon-user',
			    ));
		$gridDataProvider= new CArrayDataProvider($model->receivers); 
		
			$this->widget('bootstrap.widgets.TbGridView', array(
			'id'=>'receiverslist-grid',
		    'type'=>'striped bordered condensed',
		    'dataProvider'=>$gridDataProvider,
		    'template'=>"{items}",
		    'columns'=>array(
		        array('name'=>'receiver_name', 'header'=>Yii::t('app','Full Name')),
		        array('name'=>'toOrganization.organization_name', 
		        	  	'header'=>Yii::t('app','Organization'),
		        		'value'=>'$data->toOrganization->organization_name'
		        ),
		        array('name'=>'documentStatus.status_description', 
		        	  	'header'=>Yii::t('app','Status'),
		        		'value'=>'$data->documentStatus->status_description'
		        ),
		        array('name'=>'status_date', 
		        	  	'header'=>Yii::t('app','Date'),
		        		'value'=>'$data->status_date'
		        ),
		    ),
		));
		$this->endWidget();
		?>
		</div>
		<?php 
			$sql = "Select min(status_date),document_receiver_history.*
					FROM document_receiver_history
					WHERE out_document_id=$model->document_id
					group by document_status_id,to_organization_id
					order by status_date desc
			";
			
			$sql = "Select *
					FROM document_receiver_history
					WHERE out_document_id=$model->document_id
					order by receiver_name,status_date desc
			";
			
			//$status_history = DocumentReceiverHistory::model()->findAllBySql($sql);
			$status_history = DocumentReceiverHistory::model()->findAllBySql($sql);
			if($status_history)
			{
				$this->beginWidget('bootstrap.widgets.TbBox', array(
			    'title' => Yii::t('app','Document status'),
			    'headerIcon' => 'icon-question-sign',
			    ));
				$dataprovider = new CArrayDataProvider($status_history,
					array('keyField'=>'id')
				);
				$this->widget('bootstrap.widgets.TbGroupGridView', array(
					'filter'=>NULL,
					'type'=>'striped bordered',
					'dataProvider' => $dataprovider,
					'template' => "{items}",
					'mergeColumns' => array('to_organization_id','receiver_name'),
			//		'extraRowColumns'=> array('firstLetter'),
			//		'extraRowExpression' =>  '"<b style=\"font-size: 3em; color: #333;\">".substr($data->firstName, 0, 1)."</b>"',
			//		'extraRowHtmlOptions' => array('style'=>'padding:10px'),
					'columns' => array(
						array(
							'name'=>'to_organization_id',
							'header' => Yii::t('app','Sent to organization'),
							'value'=>'$data->organization->organization_name'
						),
						array(
							'name'=>'receiver_name',
							'header' => Yii::t('app','Receiver Name'),
							'value'=>'$data->receiver_name'
						),
						array(
							'name'=>'document_status_id',
							'header' => Yii::t('app','Status'),
							'value'=>'$data->documentStatus->status_description'
						),
						'status_date',
						array(
							'name'=>'user_action_id',
							'header' => Yii::t('app','Modified by'),
							'value'=>'$data->userProfile->first_name'
						)
					),
				));
				$this->endWidget();
			}
		?>
		<div class="row-fluid">
			<div class="span12">
						<?php $this->beginWidget('bootstrap.widgets.TbBox', array(
					    'title' => Yii::t('app','Detail'),
					    'headerIcon' => 'icon-home',
					    ));
    						echo $model->document->detail;
    					$this->endWidget();
    					?>
    					
					<div class="row-fluid">
					<?php
						$this->beginWidget('bootstrap.widgets.TbBox', array(
							'title' => Yii::t('app','Comment'),
							'headerIcon' => 'icon-comment',
						)); 
					  $comments=Comment::model()->public()->findAll("document_id=".$model->document_id);
					  if($comments)
					  {
						  foreach ($comments as $comment)
						  {
						  ?>
						  <div>
						  	<div class="span9"><div><?php echo $comment->comment_detail?></div></div>
						  	<div class="span3"><div><?php echo $comment->comment_time?></div></div>
						  </div>
						  <?php 
						  }
					  }
					  $this->endWidget()?>
				</div>
			</div>
		</div>
		</div>
		<div class="row-fluid">
				<?php 
				  $comments=Comment::model()->to_me()->findAll("document_id=".$model->document_id);
				  if($comments)
				  {
						$this->beginWidget('bootstrap.widgets.TbBox', array(
							'title' => Yii::t('app','Comment from DG'),
							'headerIcon' => 'icon-comment',
						));
					  foreach ($comments as $comment)
					  {
					  ?>
					  	<div>
					  	<div class="span9"><div><?php echo $comment->comment_detail?></div></div>
					  	<div class="span2"><div><?php echo $comment->comment_time?></div></div>
					  	</div>
					  <?php 
					  }
					  $this->endWidget();					
				  }
				  ?>
		</div>
	<div class="row-fluid">
	<div class="span12">
				<?php 
				  if(Yii::app()->user->checkAccess('DG'))
				  {
				  	$this->beginWidget('bootstrap.widgets.TbBox', array(
					    'title' => Yii::t('app','Add Comment for DG'),
					    'headerIcon' => 'icon-edit',
					    )); ?>
				  	<div class="well">
				  	<link rel="stylesheet" href="<?php echo Yii::app()->baseUrl?>/js/jquery-ui.css"/>
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
						'label'=>Yii::t('app','Save Comment'),
					));?>
					</div>
					<?php 
					$this->endWidget();
					?>
					</div>
					<?php
					$this->endWidget();
				  }	?>
			<?php $this->beginWidget('bootstrap.widgets.TbBox', array(
			    'title' => Yii::t('app','Attach file'),
			    'headerIcon' => 'icon-file',
			)); ?>
				<?php 
				if($model->document->attachFiles!=NULL){
					foreach($model->document->attachFiles as $file)
					{
						?>
						<div>
							<div class="span4 offset1"><?php echo ($file_>title)?$file_>title:$file->file_name?></div>
							<div class="span4">
							<?php echo CHtml::link("<i class='icon-download-alt icon-red'></i>",
										Yii::app()->getBaseUrl()."/file/".$file->file_name,
										array('target'=>'_blank')
							)
							?></div>
						</div>
						<?php
					}
				}?>
	<?php $this->endWidget()?>
	
	<?php $this->beginWidget('bootstrap.widgets.TbBox', array(
		    'title' => Yii::t('app','Relate document'),
		    'headerIcon' => 'icon-th',
		    )); ?>
		<?php 
				$related_docs = Document::model()->findAllBySql(
					"select * from document where related_document_id=$model->document_id 
					OR id in(select related_document_id from document where id=$model->document_id)");
				if($related_docs)
				{
					?>
					<p>
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
										foreach($doc->outDocument->documentReceivers as $to)
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
		<?php $this->endWidget(); ?> 
			</div>
		</div>
		<p/>
</div>
