<?php
$this->pageTitle =' ດາວ​ໂຫຼດ​ຖານ​ຂໍ້​ມູນ​ເກັບ​ໄວ້';
?>
<div class="span6">
<h1>ດາວ​ໂຫຼດ​ຖານ​ຂໍ້​ມູນ​ເກັບ​ໄວ້</h1>
<?php
$fileNames = array_diff(scandir($path.'/db'), array('..', '.'));
krsort($fileNames);
$i=0;
foreach ($fileNames as $fileName) {
    if($i++>12)
    {
        unlink($path.'/db/'.$fileName);
    }else{
        echo '<a href="' . $url . '/db/' . $fileName . '">' . $fileName . '</a><br/>';
    }
}
?>
</div>
<div class="span6">
<h1>ດາວ​ໂຫຼດ​ໄຟ​ຣ​ອັບ​ໂຫຼດ​ເກັບ​ໄວ້</h1>
<?php
$fileNames = array_diff(scandir($path . '/files'), array('..', '.'));
krsort($fileNames);
$i = 0;
foreach ($fileNames as $fileName) {
    if ($i++ > 12) {
        unlink($path . '/files/' . $fileName);
    } else {
        echo '<a href="' . $url . '/files/' . $fileName . '">' . $fileName . '</a><br/>';
    }
}
?>
</div>