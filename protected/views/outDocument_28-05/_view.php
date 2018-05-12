<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('document_id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->document_id),array('view','id'=>$data->document_id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('out_document_no')); ?>:</b>
	<?php echo CHtml::encode($data->out_document_no); ?>
	<br />


</div>