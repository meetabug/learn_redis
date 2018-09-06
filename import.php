<?php
require 'vendor/autoload.php';

include('conn.php');

use PhpOffice\PhpSpreadsheet\Cell\Coordinate;
use PhpOffice\PhpSpreadsheet\IOFactory;

$reader = IOFactory::createReader('Xlsx');
$reader->setReadDataOnly(TRUE);
$spreadsheet = $reader->load('students.xlsx');

$worksheet = $spreadsheet->getActiveSheet();
$highestRow = $worksheet->getHighestRow();//总行数
$highestColumn = $worksheet->getHighestColumn();//总列数
$highestColumnIndex = Coordinate::columnIndexFromString($highestColumn);

$lines = $highestRow - 2;
 if($lines <= 0){
    exit('Excel表格中没有数据');
 }

 $sql = "INSERT INTO `student` (`name`,`chinese`,`maths`,`english`) VALUES ";

 for($row = 3;$row<=$highestRow;++$row){
     $name = $worksheet->getCellByColumnAndRow(1,$row)->getValue();
     $chinese = $worksheet->getCellByColumnAndRow(2,$row)->getValue();
     $maths = $worksheet->getCellByColumnAndRow(3,$row)->getValue();
     $english = $worksheet->getCellByColumnAndRow(4,$row)->getValue();

     $sql.="('$name','$chinese','$maths','$english'),";
 }
 $sql = rtrim($sql,',');
 try{
     $db->query($sql);
     echo "OK";
 }catch (Exception $e){
     echo $e->getMessage();
 }
