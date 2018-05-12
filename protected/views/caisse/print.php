<?php
$this->layout="null";
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
<style type="text/css">
	body {font-family:"Saysettha OT";}
	.line{
		border:thin;
	 }
	@media print {
.header, .hide { visibility: hidden;  }
}
@page{margin:0px none;}
</style>
</head>

<body>
<table width="700" class="line" align="center">
<tr><td>
<table width="700" align="center" border="0" cellspacing="0" cellpadding="5" >
  <tr>
    <td colspan="4" class="line">ກະຊວງ ແຜນການ ແລະ ການລົງທືນ</td>
  </tr>
  <tr>
    <td colspan="3">ກົມສົ່ງເສີມການລົງທືນ</td>
    <td width="85" align="right">ເລກທີ່:<?php echo $model->id?></td>
  </tr>
  <tr>
    <td colspan="4" ><h3 align="center">(ໃບບິນຈ່າຍເງີນ)</h3></td>
  </tr>
  <tr>
    <td width="124">ອົງກອນ/ບໍລິສັດ:</td>
    <td colspan="3"><?php echo $model->incDocument->sender?></td>
  </tr>
  <tr>
    <td>ເລື່ອງ:</td>
    <td colspan="3"><?php echo $model->incDocument->fee->fee_description?></td>
  </tr>
  <tr>
    <td colspan="2">ອີງຕາມເອກະສານສະບັບເລກທີ່:<?php echo $model->incDocument->inc_document_no?></td>
    <td width="54" align="right">ລົງວັນທີ່:</td>
    <td align="left"><?php echo date('d/m/Y',strtotime($model->incDocument->document->created))?></td>
  </tr>
  <tr>
    <td height="36" colspan="4">ລວມເປັນຈໍານວນເງີນທັງໝົດ:<?php echo number_format($model->amount_to_budget+$model->amount_to_department,2)?> 
    	<?php echo $model->incDocument->fee->fee_type?>
    </td>
  </tr>
  <tr>
    <td colspan="4">ພະແນກແຜນການສັງລວມ ແລະ ບໍລິການ (ໜ່ວຍງານປະຕູດຽວ)</td>
  </tr>
  <tr>
    <td><u>ຜູ້ຮັບ</u></td>
    <td width="397">&nbsp;</td>
    <td>&nbsp;</td>
    <td><u>ຜູ້ຈ່າຍ</u></td>
  </tr>
  <tr>
    <td height="157">&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>
    <div  class="header" align="center">
<?php 
    $this->widget('application.extensions.print.printWidget', array(                   
                   'cssFile' => '',
                   'printedElement'=>'',
                   )
               ); 
?>
</div>
    </td>
  </tr>
</table>
</td>
  </tr>
</table>
</body>
</html>
