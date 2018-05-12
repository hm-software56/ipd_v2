<?php
if($document){
	echo $document->document_title;
	echo "<span id='docid' style='display:none'>";
	echo $document->id;
	echo "</span>";
	echo "<span id='docno' style='display:none'>";
	echo ($document->in_or_out=="INC")? $document->incDocument->inc_document_no:$document->outDocument->out_document_no;
	echo "</span>";
}