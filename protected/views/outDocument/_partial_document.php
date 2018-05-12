<?php
$this->beginWidget('bootstrap.widgets.TbModal', array('htmlOptions'=>array('id'=>'myModal','style'=>'width:800px')));?>
 
<div class="modal-header">
    <a class="close" data-dismiss="modal">&times;</a>
    <h4>Select a related document</h4>
</div>
 
<div class="modal-body">
    <p>One fine body...</p>
</div>
 
<div class="modal-footer">
	<?php $this->widget('bootstrap.widgets.TbButton', array(
        'type'=>'primary',
        'label'=>'Save changes',
        'url'=>'#',
        'htmlOptions'=>array('data-dismiss'=>'modal',
        	'onClick'=>"js:$(\"#Document_related_document_no\").html($(\"#docno\").html());
        				$(\"#Document_related_document_id\").val($(\"#docid\").html());
        "),
    )); ?>
    <?php $this->widget('bootstrap.widgets.TbButton', array(
        'label'=>'Close',
        'url'=>'#',
        'htmlOptions'=>array('data-dismiss'=>'modal'),
    )); ?>	
</div>
 
<?php $this->endWidget(); ?>