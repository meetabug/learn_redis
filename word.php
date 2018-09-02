<?php
require 'vendor/autoload.php';

use PhpOffice\PhpWord\IOFactory;
use PhpOffice\PhpWord\PhpWord;
use PhpOffice\PhpWord\SimpleType\Jc;
use PhpOffice\PhpWord\Style\Font;

//实例化
$phpWord  = new PhpWord();
//新增一个空白页
$section = $phpWord->addSection();
//向空白页添加文字内容，可以设置文字的样式，包括字体、颜色、字号、粗体等等。
$fontStyle = [
    'name' => 'Microsoft Yahei UI',
    'size' => 20,
    'color' => '#ff6600',
    'bold' =>  true
];
$textrun = $section->addTextRun();
$textrun->addText('你好，这是生成的Word文档。',$fontStyle);
//链接
//可以为Word文档中的文字添加用于点击跳转的链接。
$section->addLink('https://www.helloweba.net','欢迎访问Helloweba',array('color'=>'0000FF','underline'=>Font::UNDERLINE_SINGLE));
$section->addTextBreak();
//图片
//可以在word中添加图片，如图片地址logo.png，尺寸为64x64。图片源也可以是远程图片。
$section->addImage('logo.png',array('width'=>64,'height'=>64));
//页眉
//为Word文档添加页眉
$header = $section->addHeader();
$header->addText('Subsequent pages in Section 1 will Have this!');
//页脚
//为word文档添加页脚，页脚内容是页码，格式居中。
$footer = $section->addFooter();
$footer->addPreserveText('Page {PAGE} of {NUMPAGES}.',null, array('alignment' =>Jc::CENTER));
//增加一页
//继续增加一页，加入内容。
$section = $phpWord->addSection();
$section->addText('新的一页');
//表格
//增加一个基础表格，可以设置表格的样式。
$header = array('size'=>16,'bold'=>true);
$rows = 10;
$cols = 5;
$section->addText('Basic table',$header);
$table = $section->addTable();
for($r = 1; $r <= 8; $r++){
    $table->addRow();
    for ($c = 1; $c <= 5; $c++){
        $table->addCell(1750)->addText("Row {$r}, Cell {$c}");
    }
}
//生成Word文档
//如果你想生成word文档放在服务器上，可以使用：
$objWriter = IOFactory::createWriter($phpWord,'Word2007');
$objWriter->save('hell0weba.docx');

//下载Word文档
//如果你想直接下载Word文档，不在服务器上保存的话，可以使用：
$file = 'test.docx';
header("Content-Description: File Transfer");
header('Content-Disposition: attachment; filename="' . $file . '"');
header('Content-Type: application/vnd.openxmlformats-officedocument.wordprocessingml.document');
header('Content-Transfer-Encoding: binary');
header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
header('Expires: 0');
$xmlWriter = IOFactory::createWriter($phpWord, 'Word2007');
$xmlWriter->save("php://output");











