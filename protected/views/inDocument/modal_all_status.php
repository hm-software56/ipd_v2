
<?=$title?>
<?php
$model=Document::model()->findByPk($doc_id);
?>
<br/>
<div align="right">
	<a href="#myModal_<?= $doc_id ?>" role="button" class="btn btn-link" data-toggle="modal"><?="ເບີ່ງ​ສະ​ຖາ​ນະ​ທັງ​ໝົດ>>"?></a>
</div>
<div class="md">
    <div  id="myModal_<?= $doc_id ?>" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            <h3 id="myModalLabel">ສະ​ຖາ​ນະ​ທັງ​ໝົດ​ຂອງ​ເອ​ກະ​ສານ​ນີ້</h3>
        </div>
        <div class="modal-body">
            <div class="row-fluid">
                <div class="row-fluid">
                    <div class="span1"><b><?php echo Yii::t('app', 'ເລກ​ທີ') . ":" ?></b></div>
                    <div class="span11">
                        <?php echo IncDocument::model()->findByPk($doc_id)->inc_document_no ?>
                    </div>
                </div>
                <div class="row-fluid">
                    <div class="span1"><b><?php echo Yii::t('app', 'Title') . ":" ?></b></div>
                    <div class="span11">
                        <?php echo $model->document_title ?>
                    </div>
                </div>
                <div class="row-fluid">
                    <div class="span1"><b><?php echo Yii::t('app', 'ສະ​ຖາ​ນະ') . ":" ?></b></div>
                    <div class="span11">
                        <?php echo IncDocument::model()->findByPk($doc_id)->documentStatus->status_description ?>
                    </div>
                </div>
                <div class="row-fluid">
                    <div class="span1"><b><?php echo Yii::t('app', 'ວັນ​ທີ') . ":" ?></b></div>
                    <div class="span11">
                        <?php echo IncDocument::model()->findByPk($doc_id)->status_date ?>
                    </div>
                </div>
                <div class="row-fluid">
                    <?php $this->beginWidget('bootstrap.widgets.TbBox', array(
                        'title' => Yii::t('app', 'ເອ​ກະ​ສານ ແລະ ສະ​ຖາ​ນະ​ທີ​ກ່ຽວ​ຂ້ອງ'),
                        'headerIcon' => 'icon-th',
                    )); ?>
                        <table class="table">
                            <tr style="background:#8297c1">
                                <th><?php echo Yii::t('app', 'Document #') ?></th>
                                <th><?php echo Yii::t('app', 'Document Status') ?></th>
                                <th><?php echo Yii::t('app', 'in_or_out_organization') ?></th>
                                <th><?php echo Yii::t('app', 'Date') ?></th>
                                <th><?php echo Yii::t('app', 'ມອບ​/ສົ່ງ​ຫາ') ?></th>
                            </tr>
                        <?php 
                        $data = Document::model()->getshowrelatestatus($model->id, $model->related_document_id, '');
                        //$data = Document::model()->getall($model->id, $model->related_document_id, '');
                        if (!empty($data)) {
                            echo $data;
                        } else {
                            echo "<tr><th colspan='3'>" . Yii::t('app', 'No send to section') . "</th></tr>";
                        }

                        ?>
                        </table>
                    <?php $this->endWidget(); ?>  
                </div>
            </div>
        </div>
    </div>
</div>
