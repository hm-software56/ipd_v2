<tr>
	<td>
	<?php 
echo CHtml::link(
    ($doc->in_or_out == "INC") ? $doc->incDocument->inc_document_no : $doc->outDocument->out_document_no,
    Yii::app()->controller->createUrl('viewDocument', array('id' => $doc->id, 'inout' => $doc->in_or_out))
);
?>
	</td>
	<td><?php echo $doc->document_date ?></td>
	<td><?php echo $doc->in_or_out ?></td>
	<td><?php echo $doc->documentType->description ?></td>
	
	<?php 
if ($doc->in_or_out == "OUT") {
    ?>
		<td colspan="2">
		<table cellpadding="0" cellspacing="0">
		<?php 
    foreach ($doc->outDocument->documentReceivers as $to) { ?>
		<tr>
			<td><?php echo $to->receiver_name ?></td>
			<td><?php echo $to->documentStatus->status_description ?></td>
		</tr>
		<?php 
}
?>
		</table></td>
	<?php 
} else {
    echo "<td>" . $doc->incDocument->fromOrganization->organization_name . "</td>";
    echo '<td>' . $doc->incDocument->documentStatus->status_description . "</td>";
}
?>
	
	</tr>