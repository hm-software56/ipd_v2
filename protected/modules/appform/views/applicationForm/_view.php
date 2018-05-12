<div class="view">

	<?php echo GxHtml::encode($data->getAttributeLabel('id')); ?>:
	<?php echo GxHtml::link(GxHtml::encode($data->id), array('view', 'id' => $data->id)); ?>
	<br />

	<?php echo GxHtml::encode($data->getAttributeLabel('application_type_id')); ?>:
		<?php echo GxHtml::encode(GxHtml::valueEx($data->applicationType)); ?>
	<br />
	<?php echo GxHtml::encode($data->getAttributeLabel('inc_document_id')); ?>:
	<?php echo GxHtml::encode($data->inc_document_id); ?>
	<br />
	<?php echo GxHtml::encode($data->getAttributeLabel('investor_region_id')); ?>:
		<?php echo GxHtml::encode(GxHtml::valueEx($data->investorRegion)); ?>
	<br />

</div>