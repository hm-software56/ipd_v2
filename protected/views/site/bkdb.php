<?php
$this->pageTitle =' ດາວ​ໂຫຼດ​ຖານ​ຂໍ້​ມູນ​ເກັບ​ໄວ້';
?>
<h1>ດາວ​ໂຫຼດ​ຖານ​ຂໍ້​ມູນ​ເກັບ​ໄວ້</h1>
<?php
$fileNames = array_diff(scandir($path), array('..', '.'));
krsort($fileNames);
$i=0;
foreach ($fileNames as $fileName) {
    echo '<a href="' . $url . '/' . $fileName . '">' . $fileName . '</a><br/>';
    if($i++ ==12)
    {
        break;
    }
}
?>